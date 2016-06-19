<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');

/**
 * 系统升级
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
        echo "\n\n开始制作升级包\n\n";

        $packageDirectory = $this->createDirectory($code, $version);

        $this->generateFile($diff, $packageDirectory);

        $this->copyUpgradeScript($packageDirectory, $version);

        echo "升级包制作完毕\n";
    }

    /**
     * 生成目录,如果已经存在,递归删除文件和目录
     * @param  $name
     * @param  $version
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
            echo "{$diffFile} 差异文件不存在,无法生成差异文件!\n";
            return false;
        }

        $file = fopen($filePath, 'r');

        while (!feof($file)) {
            $line = fgets($file);

            if (!in_array($line[0], array('M', "A", 'D'))) {
                echo "无法处理该文件: {$line[0]}\n\n";
                continue;
            }

            $opFile = trim(substr($line, 1));

            if (empty($opFile)) {
                echo "无法处理该文件: {$opFile}\n";
            }

            //假如升级脚本放在这个地方,则忽略该文件下的文件

            //忽略caches文件
            if (strpos($opFile, 'caches') === 0) {
                echo "忽略文件：{$opFile}\n";
                continue;
            }

            //忽略安装文件
            if (strpos($opFile, 'www/install') === 0) {
                echo "忽略文件：{$opFile}\n";
                continue;
            }

            //忽略升级文件
            if (strpos($opFile, 'upgrade') === 0) {
                echo "忽略文件：{$opFile}\n";
                continue;
            }

            if ($line[0] == 'M' || $line[0] == 'A') {
                echo "增加更新文件: {$opFile}\n";

                $this->copyFileAndDir($opFile, $packageDirectory);
            }

            if ($line[0] == 'D') {
                echo "增加删除文件: {$opFile}\n";
                //如果有软连接,需要处理软连接的地址
                $this->insertDelete($opFile, $packageDirectory);
            }

            //增加模板处理
            if (strpos($opFile, 'coreframe/templates') === 0) {
                echo "增加模板文件：{$opFile}\n";
                //如果有软连接,需要处理软连接的地址
                $this->insertemplates($opFile, $packageDirectory);
            }
        }
    }

    private function copyFileAndDir($source, $packageDirectory)
    {
        $dest = $packageDirectory . '/source/' . $source;

        if ($this->filesystem->exists(dirname($dest))) {
            $this->filesystem->mkdir(dirname($dest));
        }
        $this->filesystem->copy(WWW_ROOT . $source, $dest);
    }

    private function copyUpgradeScript($dir, $version)
    {
        echo "拷贝升级脚本：\n";

        $path = realpath(__DIR__ . "/../../www/app/data/scripts/") . "/upgrade-" . $version . ".php";

        if (!file_exists($path)) {
            echo "无升级脚本\n";
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

    private function insertemplates($opFile, $packageDirectory)
    {
        file_put_contents("{$packageDirectory}/template", "{$opFile}\n", FILE_APPEND);
    }

}