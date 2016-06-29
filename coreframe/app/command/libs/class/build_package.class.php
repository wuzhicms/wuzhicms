<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');

/**
 * system upgrade
 */
class WUZHI_build_package
{
    private $code;
    private $version;
    private $diff;
    private $root = __DIR__ . '/../..';

    public function __construct()
    {
        $this->filesystem = load_class('filesystem', $m = 'appupdate');
    }

    public function run($code, $version, $diff)
    {
        echo "\n\n begin to build upgrade package \n\n";

        $packageDirectory = $this->createDirectory($code, $version);

        $this->generateFile($diff, $packageDirectory);

        $this->copyUpgradeScript($packageDirectory, $version);

        echo "finish building upgrade package \n\n";
    }

    /**
     * @param $code
     * @param $version
     * @return string
     */
    private function createDirectory($code, $version)
    {
        $path = WWW_ROOT . 'upgrade/build/' . $code . '_' . $version;

        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }
        $this->filesystem->mkdir($path);
        return $path;
    }

    private function generateFile($diffFile, $packageDirectory)
    {
        $filePath = WWW_ROOT . $diffFile;

        if (!$this->filesystem->exists($filePath)) {
            echo "{$diffFile} diff file does not exist,unable to generate a difference file!\n";
            return false;
        }

        $file = @fopen($filePath, 'r');

        while (!feof($file)) {
            $line = fgets($file);

            if (!in_array($line[0], array('M', "A", 'D'))) {
                echo " 无法处理该差异文件: {$line[0]}\n\n";
                continue;
            }

            $opFile = trim(substr($line, 1));

            if (empty($opFile)) {
                echo " 无法处理该差异文件: {$opFile}\n";
            }

            if (strpos($opFile, 'caches') === 0) {
                echo " 忽略缓存文件：{$opFile}\n";
                continue;
            }

            if (strpos($opFile, 'www/install') === 0) {
                echo " 忽略安装文件：{$opFile}\n";
                continue;
            }
            if (strpos($opFile, '.gitignore') === 0) {
                echo " 忽略git文件：{$opFile}\n";
                continue;
            }

            if (strpos($opFile, 'upgrade') === 0) {
                echo " 忽略升级文件：{$opFile}\n";
                continue;
            }

            if ($line[0] == 'M' || $line[0] == 'A') {
                //单独处理更新模版
                echo "+增加更新文件: {$opFile}\n";
                $this->copyFileAndDirectory($opFile, $packageDirectory);
            }

            if (strpos($opFile, 'coreframe/templates') === 0 && ($line[0] == 'M')) {
                echo " 模版文件：{$opFile}\n";
                $this->insertTplFile($opFile, $packageDirectory);
            }

            if ($line[0] == 'D') {
                echo " 删除文件: {$opFile}\n";
                $this->insertDelete($opFile, $packageDirectory);
            }
        }
    }

    /**
     * @param $source
     * @param $packageDirectory
     * copy file and directory
     */
    private function copyFileAndDirectory($source, $packageDirectory)
    {
        $dest = $packageDirectory . '/source/' . $source;

        try {
            $this->filesystem->copy(WWW_ROOT . $source, $dest);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    private function copyUpgradeScript($dir, $version)
    {
        echo " 拷贝升级SQL脚本：\n";

        $path = WWW_ROOT . "upgrade/scripts/upgrade-" . $version . ".php";

        if (!file_exists($path)) {
            echo " 没有SQL脚本\n";
        } else {
            $targetPath = realpath($dir) . '/Upgrade.php';
            echo $path . " -> {$targetPath}\n";
            $this->copy($path, $targetPath, true);
        }
    }

    private function insertDelete($opFile, $packageDirectory)
    {
        file_put_contents("{$packageDirectory}/delete", "{$opFile}\n", FILE_APPEND);
    }

    private function insertTplFile($opFile, $packageDirectory)
    {
         file_put_contents("{$packageDirectory}/template", "{$opFile}\n", FILE_APPEND);
    }
}