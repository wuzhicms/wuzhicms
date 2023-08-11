<?php
require COREFRAME_ROOT . 'vendor/autoload.php';

use OSS\OssClient;
use OSS\Core\OssException;

class WUZHI_aliyun_oss
{
    private $config = [];
    private $ossClient;
    private $object, $filePath;

    public function __construct()
    {
        $this->config = get_config('aliyun_oss_config');
        try{
            $this->ossClient = new OssClient($this->config['accessKeyId'], $this->config['accessKeySecret'], $this->config['endpoint']);
        } catch (OssException $e) {
            MSG($e->getMessage());
        }
    }
    //设置目标地址
    public function setObject($object)
    {
        $this->object = $object;
    }
   //获取目标地址
    public function getObject()
    {
        return $this->object;
    }
    //设置源资源地址
    public function setFilePath($filePath)
    {
       $this->filePath = $filePath;
    }
    //获取源资源地址
    public function getFilePath()
    {
        return $this->filePath;
    }
    //上传资源
    public function upload()
    {
        try{
            $this->ossClient->uploadFile($this->config['bucket'], $this->object, $this->filePath);
        } catch ( OssException $e ) {
            MSG(__FUNCTION__ . ": FAILED\n" .$e->getMessage());
        }

    }
    //删除资源
    public function delete()
    {
        try {
            $this->deleteObject($this->config['bucket'], $this->object);
        } catch (OssException $e) {
            Msg(__FUNCTION__ . ": FAILED\n" . $e -> getMessage());
        }
    }


}