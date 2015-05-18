<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

/**
 * 验证码类
 */
class WUZHI_identifying_code {
    public $fonts = array('ttf0.ttf', 'ttf1.ttf', 'ttf2.ttf', 'ttf3.ttf','1.ttf');
    public $code;//验证码
    private $codelen = 4;//验证码长度
    public $width = 120;//宽度
    public $height = 27;//高度
    private $img;//图形资源句柄
    private $font;//指定的字体
    private $fontsize = 16;//指定字体大小
    private $fontcolor;//指定字体颜色

    public function __construct() {
        $this->font = COREFRAME_ROOT . 'app/core/libs/fonts/'.$this->fonts[rand(0,4)];
    }

    public function image_one($code,$width = 120, $height = 27) {
        $this->code = $code;
        $this->width = $width;
        $this->height = $height;
        $this->createBg();
        $this->createLine();
        $this->createFont();
        $this->outPut();
    }

    //生成背景
    private function createBg() {
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
        imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
    }
    //生成文字
    private function createFont() {
        $_x = $this->width / $this->codelen;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
        }
    }
    //生成线条、雪花
    private function createLine() {
        //线条
        for ($i=0;$i<6;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
        //雪花
        for ($i=0;$i<100;$i++) {
            $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
        }
    }
    //输出
    private function outPut() {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }
}

?>