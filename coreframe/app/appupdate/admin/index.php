<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');
define('CLI_DISPLAY',true);
/**
 * 升级
 */
load_class('admin');

final class index extends WUZHI_admin
{
    public function __construct()
    {
        $this->db         = load_class('db');
        $this->filesystem = load_class('filesystem', $m = 'appupdate');
        $this->app_client = load_class('app_client', $m = 'appupdate');
        $this->systemRoot = '';
    }

    /**
     * 检查环境
     */
    public function checkEnvironment()
    {
        $errors = array();
        if (!class_exists('ZipArchive')) {
            $errors[] = "php_zip扩展未激活";
        }

        if (!function_exists('curl_init')) {
            $errors[] = "php_curl扩展未激活";
        }

        $downloadDirectory = DOWNLOAD_PATH;

        if (file_exists($downloadDirectory)) {
            if (!is_writeable($downloadDirectory)) {
                $errors[] = "下载目录({$downloadDirectory})无写权限";
            }
        } else {
            try {
                mkdir($downloadDirectory, 0777, true);
            } catch (\Exception $e) {
                $errors[] = "下载目录({$downloadDirectory})创建失败";
            }
        }

        $backupdDirectory = BACKUP_PATH;

        if (file_exists($backupdDirectory)) {
            if (!is_writeable($backupdDirectory)) {
                $errors[] = "备份({$backupdDirectory})无写权限";
            }
        } else {
            try {
                mkdir($backupdDirectory, 0777, true);
            } catch (\Exception $e) {
                $errors[] = "备份({$backupdDirectory})创建失败";
            }
        }


        if (!is_writeable(WWW_ROOT)) {
            $errors[] = WWW_ROOT.'目录无写权限';
        }

        if (!is_writeable(WWW_ROOT."api")) {
            $errors[] = WWW_ROOT.'api目录无写权限';
        }

        if (!is_writeable(WWW_ROOT."configs")) {
            $errors[] = WWW_ROOT.'configs目录无写权限';
        }

        if (!is_writeable(WWW_ROOT."res")) {
            $errors[] = WWW_ROOT.'res目录无写权限';
        }

        if (!is_writeable(COREFRAME_ROOT)) {
            $errors[] = 'coreframe目录无写权限';
        }

        if (!is_writeable(CACHE_ROOT)) {
            $errors[] = 'cache目录无写权限';
        }

        if (!is_writeable(WWW_ROOT."configs/web_config.php")) {
            $errors[] = WWW_ROOT.'configs/web_config.php文件无写权限';
        }
        $this->createJsonErrors($errors);
    }

    /**
     * 检查是否需要备份文件
     */
    public function backupFile()
    {
        $errors = array();

        $this->filesystem->touch("filesystem", $mode = 0777);
        $this->filesystem->remove('filesystem');
        $this->createJsonErrors($errors);
    }

    /**
     * 检查是否需要备份数据库
     */
    public function backupDb()
    {
        $errors = array();
        $this->createJsonErrors($errors);
    }

    /**
     * 下载文件
     * @param  $packageId
     * @return array
     */
    public function downloadPackage()
    {
        $packageId = isset($GLOBALS['packageId']) ? $GLOBALS['packageId'] : '';
        $errors    = array();

        try {
            $package = $this->app_client->getUpdatePackage($packageId); //获取url

            if (empty($package)) {
                throw new \RuntimeException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
            $filepath = $this->app_client->downloadPackage($packageId);

            $this->unzipPackageFile($filepath, $this->getPackageFileUnzipDir($package));
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->createJsonErrors($errors);
    }

    /**
     * 备份升级包中对应的系统文件
     * @return [type] [description]
     */
    public function backupUpgradeFile()
    {
        $errors    = array();
        $packageId = isset($GLOBALS['packageId']) ? intval($GLOBALS['packageId']) : MSG(L('parameter_error'));
        try {
            $package = $this->app_client->getUpdatePackage($packageId);

            if (empty($package)) {
                throw new \RuntimeException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
            $packageDir = $this->getPackageFileUnzipDir($package);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            goto last;
        }

        if (!$this->filesystem->exists($packageDir.'/backup')) {
            goto last;
        }

        $handle = fopen($packageDir.'/backup', 'r');

        if($this->filesystem->exists(BACKUP_PATH."{$package['fromVersion']}")){
            $this->filesystem->remove(BACKUP_PATH."{$package['fromVersion']}");
        }
        while ($filePath = fgets($handle)) {
            $filePath= trim($filePath);
            if(substr($filePath,0,9)=='coreframe') {
                $originFile = COREFRAME_ROOT.substr($filePath,9);
            } elseif(substr($filePath,0,3)=='www') {
                $originFile = WWW_ROOT.substr($filePath,3);
            }


            $targetFile = BACKUP_PATH."{$package['fromVersion']}/".trim($filePath);
            if ($this->filesystem->exists($originFile)) {
                $this->filesystem->copy($originFile, $targetFile, $override = true);
            }
        }
        fclose($handle);

        last:
        $this->createJsonErrors($errors);
    }

    /**
     * [proccessTpl 处理模版]
     * 对比本次升级包中是否含有更新模板，如果有则将每一个和系统中的该模板对比，如果没有改动则忽略，如果有改动则记录下来，并提示用户是否需要覆盖，或者忽略
     * @return [type] [description]
     */
    public function proccessTpl()
    {
        $errors    = array();
        $packageId = isset($GLOBALS['packageId']) ? intval($GLOBALS['packageId']) : MSG(L('parameter_error'));

        try {
            $package = $this->app_client->getUpdatePackage($packageId);

            if (empty($package)) {
                throw new \RuntimeException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
            $packageDir = $this->getPackageFileUnzipDir($package);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            goto last;
        }

        if (!$this->filesystem->exists($packageDir.'/template')) {
            goto last;
        }

        $diffTpls = array();

        $handle = fopen($packageDir.'/template', 'r');
        while ($filePath = fgets($handle)) {
            $filePath = trim($filePath);
            $fullPath        = COREFRAME_ROOT.substr($filePath,9);
            $fullUpgradePath = $packageDir.'/source/'.trim($filePath);

            if (md5_file($fullPath) !== md5_file($fullUpgradePath)) {
                array_push($diffTpls, trim($filePath));
            }
        }
        fclose($handle);

        if (!empty($diffTpls)) {
            array_walk($diffTpls, function ($tpl, $key, $path) {
                $key == 0 ? file_put_contents($path, $tpl."\n") : file_put_contents($path, $tpl."\n", FILE_APPEND);
            }, $packageDir.'/template');
            return $this->createJsonResponse($diffTpls);
        } else {
            $this->filesystem->remove($packageDir.'/template');
        }

        last:
        $this->createJsonErrors($errors);
    }

    /**
     * 处理下载文件
     * $packageId, $type, $index = 0
     * @param  $packageId
     * @return array
     */
    public function beginUpgrade()
    {
        $errors            = array();
        $packageId         = isset($GLOBALS['packageId']) ? intval($GLOBALS['packageId']) : MSG(L('parameter_error'));
        $type              = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
        $coveringUpdateTpl = isset($GLOBALS['coveringUpdateTpl']) ? (bool) $GLOBALS['coveringUpdateTpl'] : false;

        try {
            $package = $this->app_client->getUpdatePackage($packageId);

            if (empty($package)) {
                throw new \RuntimeException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
            $packageDir = $this->getPackageFileUnzipDir($package);
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
            goto last;
        }

        try {
            $this->_deleteFilesForPackageUpdate($packageDir);
        } catch (\Exception $e) {
            $errors[] = "删除文件时发生了错误：{$e->getMessage()}";
            goto last;
        }

        try {
            $this->_proccessTplFile($package, $packageDir, $coveringUpdateTpl);
        } catch (\Exception $e) {
            $errors[] = "处理模板文件时发生了错误：{$e->getMessage()}";
            goto last;
        }

        try {
            $this->_replaceFileForPackageUpdate($packageDir);
        } catch (\Exception $e) {
            $errors[] = "复制升级文件时发生了错误：{$e->getMessage()}";
            goto last;
        }

        try {
            $this->_execScriptForPackageUpdate($package, $packageDir, $type);
        } catch (\Exception $e) {
            $errors[] = "执行升级/安装脚本时发生了错误：{$e->getMessage()}";
            goto last;
        }

        try {
            //refresh cache
            // $this->filesystem->remove(CACHE_ROOT);
        } catch (\Exception $e) {
            $errors[] = "应用安装升级成功，但刷新缓存失败！请检查权限";
            goto last;
        }

        if (empty($errors)) {
            $this->updateAppForPackageUpdate($package);
        }
        last:
        $this->createJsonErrors($errors);
    }

    protected function _deleteFilesForPackageUpdate($packageDir)
    {
        if (!$this->filesystem->exists($packageDir.'/delete')) {
            return;
        }

        $handle = fopen($packageDir.'/delete', 'r');

        while ($filePath = fgets($handle)) {
            $filePath= trim($filePath);
            if(substr($filePath,0,9)=='coreframe') {
                $fullPath = COREFRAME_ROOT.substr($filePath,9);
                if ($this->filesystem->exists($fullPath)) {
                    $this->filesystem->remove($fullPath);
                }
            } elseif(substr($filePath,0,3)=='www') {
                $fullPath = WWW_ROOT.substr($filePath,3);
                if ($this->filesystem->exists($fullPath)) {
                    $this->filesystem->remove($fullPath);
                }
            }

        }

        fclose($handle);
    }

    /**
     * 如果存在template文件，则说明用户的模板有更新，此时需要做如下事情
     * 1. 覆盖更新，将讲用户的模板内容存放到历史模版中，次之，在coreframe/templates/upgrade/{version}/下覆盖用户的文件
     * 2. 忽略文件，将要更新的模版放倒，coreframe/templates/upgrade/{version}/下
     *
     * 按照我的想法更新时不语提示，但是仍要对比md5值,这样就知道用户更改了那些文件，然后对于有更改的文件，直接放倒该模版文件的历史纪录中，升级简单且用户方便查找哪些文件被覆盖了，并且可以在新的模版上继续修改
     * @param  [type] $packageDir        [description]
     * @param  [type] $tplCoveringUpdate [description]
     * @return [type] [description]
     */
    protected function _proccessTplFile($package, $packageDir, $coveringUpdateTpl)
    {
        if (!$this->filesystem->exists($packageDir.'/template')) {
            return;
        }

        $handle = fopen($packageDir.'/template', 'r');

        while ($filePath = fgets($handle)) {
            $filePath = trim($filePath);
            $originFile  = COREFRAME_ROOT.substr($filePath,9);
            $upgradeFile = "{$packageDir}/source/".$filePath;

            if ($coveringUpdateTpl) {
                //覆盖更新  -> 备份系统中的模版文件并覆盖更新
                $targetFile = BACKUP_PATH."{$package['fromVersion']}/cover/".trim($filePath);
                if ($this->filesystem->exists($originFile)) {
                    $this->filesystem->copy($originFile, $targetFile, $override = true);
                }
            } else {
                //忽略更新   -> 删除升级文件中对应的文件模板
                $targetFile = BACKUP_PATH."{$package['fromVersion']}/".trim($filePath);
                if ($this->filesystem->exists($upgradeFile)) {
                    $this->filesystem->copy($upgradeFile, $targetFile, $override = true);
                    $this->filesystem->remove($upgradeFile);
                }
            }
        }
        fclose($handle);
    }

    protected function _replaceFileForPackageUpdate($packageDir)
    {
        $this->systemRoot = COREFRAME_ROOT;
        $this->filesystem->mirror("{$packageDir}/source/coreframe", $this->systemRoot, null, array(
            'override'        => true,
            'copy_on_windows' => true
        ));
        $this->systemRoot = WWW_ROOT;
        $this->filesystem->mirror("{$packageDir}/source/www", $this->systemRoot, null, array(
            'override'        => true,
            'copy_on_windows' => true
        ));
    }

    protected function _execScriptForPackageUpdate($package, $packageDir, $type)
    {
        $upgrade = $packageDir.'/upgrade.php';
        $name    = 'upgrade';
        if ($this->filesystem->exists($upgrade)) {
            require_once $upgrade;
            $upgrade = new $name();
            $upgrade->updateScheme();
        }
    }

    protected function updateAppForPackageUpdate($package)
    {
        $newApp = array(
            'code'          => $package['product']['code'],
            'name'          => $package['product']['name'],
            'description'   => $package['product']['description'],
            'icon'          => $package['product']['icon'],
            'version'       => $package['toVersion'],
            'fromVersion'   => $package['fromVersion'],
            'developerId'   => $package['product']['developerId'],
            'developerName' => $package['product']['developerName'],
            'updatedTime'   => time()
        );

        $app = $this->db->get_one('cloud_app', array('code' => $package['product']['code']));

        if (empty($app)) {
            $newApp['installedTime'] = time();
            $this->db->insert('cloud_app', $newApp);
            $app = $this->db->get_one('cloud_app', array('code' => $package['product']['code']));
        }
        $this->db->update('cloud_app', $newApp, array('id' => $app['id']));
        return $app;
    }

    private function unzipPackageFile($filePath, $unzipDir)
    {
        if ($this->filesystem->exists($unzipDir)) {
            $this->filesystem->remove($unzipDir);
        }
        $tmpUnzipDir = $unzipDir.'_tmp';

        if ($this->filesystem->exists($tmpUnzipDir)) {
            $this->filesystem->remove($tmpUnzipDir);
        }
        $this->filesystem->mkdir($tmpUnzipDir);

        $zip = new \ZipArchive;
        if ($zip->open($filePath) === true) {
            $tmpUnzipFullDir = $tmpUnzipDir.'/'.$zip->getNameIndex(0);
            $zip->extractTo($tmpUnzipDir);
            $zip->close();
            $this->filesystem->rename($tmpUnzipFullDir, $unzipDir);
            $this->filesystem->remove($tmpUnzipDir);
        } else {
            throw new \Exception('无法解压缩安装包！');
        }
    }

    private function createJsonErrors($errors)
    {
        if (empty($errors)) {
            echo json_encode(array('status' => 'ok'));
        } elseif (isset($errors['index'])) {
            echo json_encode($errors);
        } else {
            echo json_encode(array('status' => 'error', 'errors' => $errors));
        }
    }

    private function createJsonResponse($response)
    {
        echo json_encode(array('status' => 'ok', 'type' => 'tpl', 'response' => $response));
    }

    private function getPackageFileUnzipDir($package)
    {
        return DOWNLOAD_PATH.$package['fileName'];
    }
}
