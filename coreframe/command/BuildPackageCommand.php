<?php

/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 4/23/16
 * Time: 20:43
 */
class BuildPackageCommand
{
    private $root = __DIR__ . '/../..';
    //需要三个参数
    public function execute()
    {
        $packageDirectory = $this->createDirectory('MAIN', '2.0.5');
        $diffFile         = '/build/diff-2.03';
        $this->generateFile($diffFile, $packageDirectory);
    }

    /**
     * 生成目录,如果已经存在,递归删除文件和目录,此处先简化处理
     * @param $name
     * @param $version
     * @return string
     */
    private function createDirectory($name, $version)
    {

        $path = "{$this->root}/build/{$name}_{$version}";
        if (!file_exists($path)) {
            mkdir($path);
        };
        return $path;
    }

    private function generateFile($diffFile, $packageDirectory)
    {
        if (!file_exists($diffFile)) {
            echo "{$diffFile} 差异文件不存在,无法生成差异文件!\n";
            return false;
        }
        $file = fopen($this->root . $diffFile, 'r');

        while (!feof($file)) {
            $line = fgets($file);
            if (!in_array($line[0], array('M', "A", 'D'))) {
                echo "无法处理该文件: {$line[0]}";
                continue;
            }
            $opFile = trim(substr($line, 1));
            if (empty($opFile)) {
                echo "无法处理该文件: {$opFile}";
            }
            //假如升级脚本放在这个地方,则忽略该文件下的文件
            if (strpos($opFile, 'app/DoctrineMigrations') === 0) {
                echo "忽略文件：{$opFile}";
                continue;
            }
            //忽略安装文件
            if (strpos($opFile, 'www/install') === 0) {
                echo "忽略文件：{$opFile}";
                continue;
            }

            if ($line[0] == 'M' || $line[0] == 'A') {
                echo "增加更新文件: {$opFile}\n";

                $this->copyFileAndDir($opFile, $packageDirectory);
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


    public function copy($originFile, $targetFile, $override = false)
    {
        var_dump($originFile);
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
            // https://bugs.php.net/bug.php?id=64634
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

}

$command = new BuildPackageCommand();

$command->execute();