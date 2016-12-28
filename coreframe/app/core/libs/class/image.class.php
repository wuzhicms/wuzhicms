<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 图像类
 */
class WUZHI_image{

    /**
     * @var string $fileName 文件名
     * @access private
     */
    private $fileName = '';

    /**
     * @var gd resource $imageResource 原图像
     * @access private
     */
    private $imageResource = NULL;

    /**
     * @var int $imageWidth 原图像宽
     * @access private
     */
    private $imageWidth = NULL;

    /**
     * @var int $imageHeight 原图像高
     * @access private
     */
    private $imageHeight = NULL;

    /**
     * @var int $imageType 原图像类型
     * @access private
     */
    private $imageType = NULL;

    /**
     * @var int $imageWidth 原图像宽
     * @access private
     */
    public $width = NULL;

    /**
     * @var int $imageHeight 原图像高
     * @access private
     */
    public $height = NULL;

    /**
     * @var int $imageType 原图像类型
     * @access private
     */
    public $type = NULL;

    /**
     * @var int $newResource 新图像
     * @access private
     */
    private $newResource = NULL;

    /**
     * @var int $newResType 新图像类型
     * @access private
     */
    private $newResType = NULL;

    /**
     * 构造函数
     * @param string $fileName 文件名
     */
    public function __construct() {

    }
    public function set_image($fileName) {
        $this->fileName = $fileName;
        $this->imageResource = '';
        $this->getSrcImageInfo($this->fileName);
    }
    /**
     * 取源图像信息
     * @access private
     * @return void
     */
    private function getSrcImageInfo($fileName) {
        $info = $this->getImageInfo($fileName);
        $this->imageWidth = $info[0];
        $this->imageHeight = $info[1];
        $this->imageType = $info[2];
        $this->width = $info[0];
        $this->height = $info[1];
        $this->type = $info[2];
    }

    /**
     * 取图像信息
     * @param string $fileName 文件名
     * @access private
     * @return array
     */
    private function getImageInfo($fileName = NULL) {
        if ($fileName==NULL) {
            $fileName = $this->fileName;
        }
        $info = getimagesize($fileName);
        return $info;
    }

    /**
     * 创建源图像GD 资源
     * @access private
     * @return void
     */
    private function createSrcImage () {
        $this->imageResource = $this->createImageFromFile();
    }

    /**
     * 跟据文件创建图像GD 资源
     * @param string $fileName 文件名
     * @return gd resource
     */
    public function createImageFromFile($fileName = NULL)
    {
        if (!$fileName) {
            $fileName = $this->fileName;
            $imgType = $this->imageType;
        }
        if (!is_readable($fileName) || !file_exists($fileName)) {

            throw new Exception('Unable to open file "' . $fileName . '"');
        }

        if (!isset($imgType) || !$imgType) {
            $imageInfo = $this->getImageInfo($fileName);
            $imgType = $imageInfo[2];
        }

        switch ($imgType) {
            case IMAGETYPE_GIF:
                $tempResource = imagecreatefromgif($fileName);
                break;
            case IMAGETYPE_JPEG:
                $tempResource = imagecreatefromjpeg($fileName);
                break;
            case IMAGETYPE_PNG:
                $tempResource = imagecreatefrompng($fileName);
                break;
            case IMAGETYPE_WBMP:
                $tempResource = imagecreatefromwbmp($fileName);
                break;
            case IMAGETYPE_XBM:
                $tempResource = imagecreatefromxbm($fileName);
                break;
            default:
                throw new Exception('Unsupport image type');
        }
        return $tempResource;
    }
    /**
     * 改变图像大小
     * @param int $width 宽
     * @param int $height 高
     * @param string $flag 一般而言,允许截图则用4,不允许截图则用1;  假设要求一个为4:3比例的图像,则:4=如果太长则自动刪除一部分 0=长宽转换成参数指定的 1=按比例缩放,自动判断太长还是太宽,长宽约束在参数指定内 2=以宽为约束缩放 3=以高为约束缩放
     * @param string $bgcolor 如果不为null,则用这个参数指定的颜色作为背景色,并且图像扩充到指定高宽,该参数应该是一个数组;
     * @return string
     */
    public function resizeImage($width, $height, $flag=1, $bgcolor=null) {
        $widthRatio = $width/$this->imageWidth;
        $heightRatio = $height/$this->imageHeight;
        switch ($flag) {
            case 1:
                if ($this->imageHeight < $height && $this->imageWidth < $width) {
                    $endWidth = $this->imageWidth;
                    $endHeight = $this->imageHeight;
                    //return;
                } elseif (($this->imageHeight * $widthRatio)>$height) {
                    $endWidth = ceil($this->imageWidth * $heightRatio);
                    $endHeight = $height;
                } else {
                    $endWidth = $width;
                    $endHeight = ceil($this->imageHeight * $widthRatio);
                }
                break;
            case 2:
                $endWidth = $width;
                $endHeight = ceil($this->imageHeight * $widthRatio);
                break;
            case 3:
                $endWidth = ceil($this->imageWidth * $heightRatio);
                $endHeight = $height;
                break;
            case 4:
                $endWidth2 = $width;
                $endHeight2 = $height;
                if ($this->imageHeight < $height && $this->imageWidth < $width) {
                    $endWidth = $this->imageWidth;
                    $endHeight = $this->imageHeight;
                    //return;
                } elseif (($this->imageHeight * $widthRatio)<$height) {
                    $endWidth = ceil($this->imageWidth * $heightRatio);
                    $endHeight = $height;
                } else {
                    $endWidth = $width;
                    $endHeight = ceil($this->imageHeight * $widthRatio);
                }
                break;
            default:
                $endWidth = $width;
                $endHeight = $height;
                break;
        }
        if ($this->imageResource==NULL) {
            $this->createSrcImage();
        }
        if($bgcolor){
            $this->newResource = imagecreatetruecolor($width,$height);
            $bg=ImageColorAllocate($this->newResource,$bgcolor[0],$bgcolor[1],$bgcolor[2]);
            ImageFilledRectangle($this->newResource,0,0,$width,$height,$bg);
            $tox=ceil(($width-$endWidth)/2);
            $toy=ceil(($height-$endHeight)/2);
            if($tox<0) $tox=0;
            if($toy<0) $toy=0;
        }else if ($flag==4) {
            $this->newResource = imagecreatetruecolor($endWidth2,$endHeight2);
        }else {
            $this->newResource = imagecreatetruecolor($endWidth,$endHeight);
        }
        $this->newResType = $this->imageType;
        imagecopyresampled($this->newResource, $this->imageResource, $tox, $toy, 0, 0, $endWidth, $endHeight,$this->imageWidth,$this->imageHeight);

    }

    /**
     * 给图像加水印
     * @param string $waterContent 水印内容可以是图像文件名，也可以是文字
     * @param int $pos 位置0-9可以是数组
     * @param int $textFont 字体大字，当水印内容是文字时有效
     * @param string $textColor 文字颜色，当水印内容是文字时有效
     * @return string
     */
    public function water_mark($waterContent, $pos = 0, $textFont=5, $textColor="#ffffff") {
        $isWaterImage = file_exists($waterContent);
        if ($isWaterImage) {
            $waterImgRes = $this->createImageFromFile($waterContent);
            $waterImgInfo = $this->getImageInfo($waterContent);
            $waterWidth = $waterImgInfo[0];
            $waterHeight = $waterImgInfo[1];
        } else {

            $waterText = $waterContent;
            $temp = imagettfbbox(ceil($textFont*2.5),0,COREFRAME_ROOT.'app/core/libs/fonts/watermark.ttf',$waterContent);
            if ($temp) {
                $waterWidth = $temp[2]-$temp[6];
                $waterHeight = $temp[3]-$temp[7];
            } else {
                $waterWidth = 100;
                $waterHeight = 12;
            }
        }
        if ($this->imageResource==NULL) {
            $this->createSrcImage();
        }
        switch($pos)
        {
            case 0://随机
                $posX = rand(0,($this->imageWidth - $waterWidth));
                $posY = rand(0,($this->imageHeight - $waterHeight));
                break;
            case 1://1为顶端居左
                $posX = 0;
                $posY = 0;
                break;
            case 2://2为顶端居中
                $posX = ($this->imageWidth - $waterWidth) / 2;
                $posY = 0;
                break;
            case 3://3为顶端居右
                $posX = $this->imageWidth - $waterWidth;
                $posY = 0;
                break;
            case 4://4为中部居左
                $posX = 0;
                $posY = ($this->imageHeight - $waterHeight) / 2;
                break;
            case 5://5为中部居中
                $posX = ($this->imageWidth - $waterWidth) / 2;
                $posY = ($this->imageHeight - $waterHeight) / 2;
                break;
            case 6://6为中部居右
                $posX = $this->imageWidth - $waterWidth;
                $posY = ($this->imageHeight - $waterHeight) / 2;
                break;
            case 7://7为底端居左
                $posX = 0;
                $posY = $this->imageHeight - $waterHeight;
                break;
            case 8://8为底端居中
                $posX = ($this->imageWidth - $waterWidth) / 2;
                $posY = $this->imageHeight - $waterHeight;
                break;
            case 9://9为底端居右
                $posX = $this->imageWidth - $waterWidth-20;
                $posY = $this->imageHeight - $waterHeight-10;
                break;
            default://随机
                $posX = rand(0,($this->imageWidth - $waterWidth));
                $posY = rand(0,($this->imageHeight - $waterHeight));
                break;
        }
        imagealphablending($this->imageResource, true);
        if($isWaterImage) {
            imagecopy($this->imageResource, $waterImgRes, $posX, $posY, 0, 0, $waterWidth,$waterHeight);
        } else {
            $R = hexdec(substr($textColor,1,2));
            $G = hexdec(substr($textColor,3,2));
            $B = hexdec(substr($textColor,5));

            $textColor = imagecolorallocate($this->imageResource, $R, $G, $B);
            imagestring ($this->imageResource, $textFont, $posX, $posY, $waterText, $textColor);
        }
        $this->newResource =  $this->imageResource;
        $this->newResType = $this->imageType;
    }

    /**
     * 显示输出图像
     * @return void
     */
    public function display($fileName='', $quality=100) {

        $imgType = $this->newResType;
        $imageSrc = $this->newResource;
        switch ($imgType) {
            case IMAGETYPE_GIF:
                if ($fileName=='') {
                    header('Content-type: image/gif');
                }
                imagegif($imageSrc, $fileName, $quality);
                break;
            case IMAGETYPE_JPEG:
                if ($fileName=='') {
                    header('Content-type: image/jpeg');
                }
                imagejpeg($imageSrc, $fileName, $quality);
                break;
            case IMAGETYPE_PNG:
                if ($fileName=='') {
                    header('Content-type: image/png');
                    imagepng($imageSrc);
                } else {
                    imagepng($imageSrc, $fileName);
                }
                break;
            case IMAGETYPE_WBMP:
                if ($fileName=='') {
                    header('Content-type: image/wbmp');
                }
                imagewbmp($imageSrc, $fileName, $quality);
                break;
            case IMAGETYPE_XBM:
                if ($fileName=='') {
                    header('Content-type: image/xbm');
                }
                imagexbm($imageSrc, $fileName, $quality);
                break;
            default:
                throw new Exception('Unsupport image type');
        }
        imagedestroy($imageSrc);
    }

    /**
     * 保存图像
     * @param int $fileNameType 文件名类型 0使用原文件名，1使用指定的文件名，2在原文件名加上后缀，3产生随机文件名
     * @param string $folder 文件夹路径 为空为与原文件相同
     * @param string $param 参数$fileNameType为1时为文件名2时为后缀
     * @return void
     */
    public function save($fileNameType = 0, $folder = NULL, $param = '_miniature') {
        if ($folder==NULL) {
            $folder = dirname($this->fileName).DIRECTORY_SEPARATOR;

        }
        $fileExtName = '.'.get_ext($this->fileName);
        $fileBesicName = basename($this->fileName);
        switch ($fileNameType) {
            case 1:
                $newFileName = $folder.$param;
                break;
            case 2:
                $newFileName = $folder.$fileBesicName.$param.$fileExtName;
                break;
            case 3:
                $tmp = date('YmdHis');
                $fileBesicName = $tmp;
                $i = 0;
                while (file_exists($folder.$fileBesicName.$fileExtName)) {
                    $fileBesicName = $tmp.$i;
                    $i++;
                }
                $newFileName = $folder.$fileBesicName.$fileExtName;
                break;
            default:
                $newFileName = $this->fileName;
                break;
        }
        $this->display($newFileName);
        return $newFileName;
    }
}