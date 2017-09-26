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
    private $root = __DIR__.'/../..';

    public function __construct()
    {
        $this->filesystem = load_class('filesystem', $m = 'appupdate');
    }

    public function run($code, $version, $diff)
    {
        echo "\n begin to build upgrade package \n";

        $packageDirectory = $this->createDirectory($code, $version);

        $this->generateFile($diff, $packageDirectory);

        $this->copyUpgradeScript($packageDirectory, $version);

        echo "\n finish building upgrade package \n";
    }

    /**
     * @param  $code
     * @param  $version
     * @return string
     */
    private function createDirectory($code, $version)
    {
        $path = BUILD_PATH.$code.'_'.$version;

        if ($this->filesystem->exists($path)) {
            $this->filesystem->remove($path);
        }
        $this->filesystem->mkdir($path);
        return $path;
    }

    private function generateFile($diffFile, $packageDirectory)
    {
        $filePath = BUILD_PATH.$diffFile;

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
            if (strpos($opFile, 'www/configs') === 0) {
                echo " 忽略配置文件：{$opFile}\n";
                continue;
            }
            //www/configs/
            if (strpos($opFile, '.gitignore') === 0) {
                echo " 忽略git文件：{$opFile}\n";
                continue;
            }
			if (strpos($opFile, '.DS_Store') === 0) {
				echo " 忽略mac系统文件：{$opFile}\n";
				continue;
			}
            if (strpos($opFile, 'upgrade') === 0) {
                echo " 忽略升级文件：{$opFile}\n";
                continue;
            }
            if (strpos($opFile, 'www/promote') === 0) {
                echo " 忽略升级文件：{$opFile}\n";
                continue;
            }
            if (strpos($opFile, 'www/uploadfile') === 0) {
                echo " 忽略升级文件：{$opFile}\n";
                continue;
            }
            if (strpos($opFile, 'tools/') === 0) {
                echo " 忽略升级文件：{$opFile}\n";
                continue;
            }
			if (strpos($opFile, 'README.md') === 0) {
				echo " 忽略升级文件：{$opFile}\n";
				continue;
			}
			if (strpos($opFile, 'bin/build.php') === 0) {
				echo " 忽略打包文件：{$opFile}\n";
				continue;
			}
			if (strpos($opFile, 'www/favicon.ico') === 0) {
				echo " 忽略默认icon文件：{$opFile}\n";
				continue;
			}

            $this->insterCopyFile($opFile, $packageDirectory);

            if ($line[0] == 'M' || $line[0] == 'A') {
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
     * copy file and directory
     * @param $source
     * @param $packageDirectory
     */
    private function copyFileAndDirectory($source, $packageDirectory)
    {
        $dest = $packageDirectory.'/source/'.$source;

        try {
            $this->filesystem->copy(WWW_ROOT.$source, $dest);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function copyUpgradeScript($dir, $version)
    {
        echo " 拷贝升级SQL脚本：\n";

        $version            = explode('.', VERSION);
        $executefile        = WWW_ROOT."upgrade/upgrade.php";
        $sqlfile            = WWW_ROOT.'upgrade/'.$version[0].'.'.$version[1].'/'.$version[2].'/sql.sql';
        $auto_execute_file  = WWW_ROOT.'upgrade/'.$version[0].'.'.$version[1].'/'.$version[2].'/upgrade.php';

        if (!file_exists($executefile) || !file_exists($sqlfile)) {
            echo " 没有SQL脚本\n";
        } else {
            $targetExecutefile = realpath($dir).'/upgrade.php';
            $targetSqlPath     = realpath($dir).'/sql.sql';
            $targetAuto_execute_filePath     = realpath($dir).'/auto_execute.php';
            echo '1 . '.$executefile." -> {$targetExecutefile}\n";
            echo '2 . '.$sqlfile." -> {$targetSqlPath}\n";
            echo '3 . '.$sqlfile." -> {$targetAuto_execute_filePath}\n";
            $this->filesystem->copy($executefile, $targetExecutefile, true);
            $this->filesystem->copy($sqlfile, $targetSqlPath, true);
            $this->filesystem->copy($auto_execute_file, $targetAuto_execute_filePath, true);
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

    private function insterCopyFile($opFile, $packageDirectory)
    {
        file_put_contents("{$packageDirectory}/backup", "{$opFile}\n", FILE_APPEND);
    }
}
