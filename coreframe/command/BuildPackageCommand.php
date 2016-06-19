<?php

/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 4/23/16
 * Time: 20:43
 *
 * use: php BuildPackageCommand.php code version  diff-file-path  eg.   php coreframe/command/BuildPackageCommand.php MAIN 3.0.1 upgrade/build/diff-3.0.1
 */
class BuildPackageCommand
{
    private $code;
    private $version;
    private $diff;
    private $root = __DIR__ . '/../..';

    public function __construct($code, $version, $diff)
    {
        $this->code    = $code;
        $this->version = $version;
        $this->diff    = $diff;
    }

    public function execute()
    {
        echo "\n\n开始制作升级包\n\n";
        $packageDirectory = $this->createDirectory($this->code, $this->version);
        $this->generateFile($this->diff, $packageDirectory);

        $this->copyUpgradeScript($packageDirectory, $this->version);

        echo "升级包制作完毕\n";
    }

    /**
     * 生成目录,如果已经存在,递归删除文件和目录
     * @param  $name
     * @param  $version
     * @return string
     */
    private function createDirectory($name, $version)
    {
        $path = "{$this->root}/upgrade/build/{$name}_{$version}";

        if (file_exists($path)) {
            $this->remove($path);
        }
        mkdir($path);
        return $path;
    }

    private function generateFile($diffFile, $packageDirectory)
    {
        $filePath = "{$this->root}/$diffFile";
        if (!file_exists($filePath)) {
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
        }
    }

    private function copyFileAndDir($opFile, $packageDirectory)
    {
        $destPath = $packageDirectory . '/source/' . $opFile;

        if (!file_exists(dirname($destPath))) {
            mkdir(dirname($destPath), 0777, true);
        }

        $root = __DIR__ . '/../..';
        $this->copy("{$root}/{$opFile}", $destPath);
    }

    private function copyUpgradeScript($dir, $version)
    {
        echo "拷贝升级脚本：\n";

        $path = realpath(__DIR__ . "/../../www/app/data/scripts/") . "/upgrade-" . $this->version . ".php";

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

    public function copy($originFile, $targetFile, $override = false)
    {
        if (stream_is_local($originFile) && !is_file($originFile)) {
            throw new Exception(sprintf('Failed to copy %s because file not exists', $originFile));
        }

        if (!is_dir(dirname($targetFile))) {
            mkdir(dirname($targetFile), 0777, true);
        }

        $doCopy = true;

        if (!$override && null === parse_url($originFile, PHP_URL_HOST) && is_file($targetFile)) {
            $doCopy = filemtime($originFile) > filemtime($targetFile);
        }

        if ($doCopy) {
            $source = fopen($originFile, 'r');
            // Stream context created to allow files overwrite when using FTP stream wrapper - disabled by default
            $target = fopen($targetFile, 'w', null, stream_context_create(array('ftp' => array('overwrite' => true))));
            stream_copy_to_stream($source, $target);
            fclose($source);
            fclose($target);
            unset($source, $target);

            if (!is_file($targetFile)) {
                throw new \Exception(sprintf('Failed to copy %s to %s', $originFile, $targetFile));
            }
        }
    }

    private function remove($dir)
    {
        if (!file_exists($dir)) {
            return false;
        }

        $iter = new RecursiveDirectoryIterator($dir);

        foreach (new RecursiveIteratorIterator($iter, RecursiveIteratorIterator::CHILD_FIRST) as $f) {
            if (in_array($f->getFileName(), array('.', '..'))) {
                continue;
            }

            if ($f->isDir()) {
                rmdir($f->getPathname());
            } else {
                unlink($f->getPathname());
            }
        }

        rmdir($dir);
    }
}

if (count($argv) !== 4) {
    echo "\nuse: php BuildPackageCommand.php code version  diff-file-path  eg.   php coreframe/command/BuildPackageCommand.php MAIN 3.0.1 upgrade/build/diff-3.0.1\n";
    exit();
}

$command = new BuildPackageCommand($argv[1], $argv[2], $argv[3]);

$command->execute();
