<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');
/**
 * 网站后台首页
 * 每小时内密码错误次数达到5次，锁定登录。
 * 记录用户登录的历史记录
 * 记录用户登录的错误记录
 */
load_class('admin');

final class index extends WUZHI_admin
{
    private $db;
    private $filesystem;

    public function __construct()
    {
        $this->db         = load_class('db');
        $this->filesystem = load_class('filesystem', $m = 'appupdate');
        $this->app_client = load_class('app_client', $m = 'appupdate');
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

        $rootDirectory = SYSTEM_ROOT;

        if (!is_writeable("{$rootDirectory}www")) {
            $errors[] = 'www目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}www/api")) {
            $errors[] = 'www/api目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}www/configs")) {
            $errors[] = 'www/configs目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}www/res")) {
            $errors[] = 'www/res目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}coreframe")) {
            $errors[] = 'coreframe目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}caches")) {
            $errors[] = 'cache目录无写权限';
        }

        if (!is_writeable("{$rootDirectory}/www/configs/web_config.php")) {
            $errors[] = 'www/configs/web_config.php文件无写权限';
        }
        $this->createJsonErrors($errors);
    }

    /**
     * 检查是否需要备份文件
     */
    public function backupFile()
    {
        //TODO LIST
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
        //TODO LIST
        $errors = array();
        $this->createJsonErrors($errors);
    }

    /**
     * @param $packageId
     * @return array
     * 下载文件
     */
    function downloadPackageForUpdate()
    {
        $packageId = isset($GLOBALS['packageId']) ? $GLOBALS['packageId'] : '';
        $errors    = array();

        try {
            $package = $this->app_client->getUpdatePackage($packageId); //获取url

            if (empty($package)) {
                throw $this->createServiceException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
            }
            $filepath = $this->app_client->downloadPackage($packageId);

            $this->unzipPackageFile($filepath, $this->getPackageFileUnzipDir($package));
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->createJsonErrors($errors);
    }

    /**
     * @param $packageId
     * @return array
     * 处理下载文件
     * $packageId, $type, $index = 0
     */
    public function beginUpgrade()
    {
        $errors    = array();
        $packageId = isset($GLOBALS['packageId']) ? intval($GLOBALS['packageId']) : MSG(L('parameter_error'));
        $type      = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;


        try {
            $package = $this->app_client->getUpdatePackage($packageId);

            if (empty($package)) {
                throw $this->createServiceException("应用包#{$packageId}不存在或网络超时，读取包信息失败");
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
            $errors[] = "应用安装升级成功，但刷新缓存失败！请检查{$cachePath}的权限";
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
        if (!$this->filesystem->exists($packageDir . '/delete')) {
            return;
        }

        $handle = fopen($packageDir . '/delete', 'r');

        while ($filePath = fgets($handle)) {
            //get file full path
            $fullPath = SYSTEM_ROOT . trim($filePath);

            if ($this->filesystem->exists($fullPath)) {
                $this->filesystem->remove($fullPath);
            }
        }

        fclose($handle);
    }

    protected function _replaceFileForPackageUpdate($packageDir)
    {
        $this->filesystem->mirror("{$packageDir}/source", SYSTEM_ROOT, null, array(
            'override'        => true,
            'copy_on_windows' => true
        ));
    }

    protected  function _execScriptForPackageUpdate($package, $packageDir, $type){

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
        $tmpUnzipDir = $unzipDir . '_tmp';

        if ($this->filesystem->exists($tmpUnzipDir)) {
            $this->filesystem->remove($tmpUnzipDir);
        }
        $this->filesystem->mkdir($tmpUnzipDir);

        $zip = new \ZipArchive;
        if ($zip->open($filePath) === true) {
            $tmpUnzipFullDir = $tmpUnzipDir . '/' . $zip->getNameIndex(0);
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
        } else if (isset($errors['index'])) {
            echo json_encode($errors);
        } else {
            echo json_encode(array('status' => 'error', 'errors' => $errors));
        }

    }

    private function getPackageFileUnzipDir($package)
    {
        return DOWNLOAD_PATH . $package['fileName'];
    }
}
