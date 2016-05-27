<?php
/**
 * 将文字生成图片
 *
 * 仅支持数字,字母,如需中文,需要将字体文件修改为中文字体文件.
 *
 * 用法:
 * urlencode(encode('phpip@qq.com'));
 *
 * http://www.wuzhicms.com/api/str2img.php?token=IQzA9SpN2Os6zKO%2FackBknQg0moSZuJ%2B
 */

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$string = strip_tags($GLOBALS['token']);

$string = decode($string);
$fontsize = 11;

$string = str_replace("\r","",$string);
$string = explode("\n",$string);

$maxlen = 0;
foreach ($string as $str){
	if (strlen($str) > $maxlen){
		$maxlen = strlen($str);
	}
}
//set font size
$font_size = $fontsize;

// Create image width dependant on width of the string
$width  = $maxlen*7;
if($fontsize>9) $width = $maxlen*12;
// Set height to that of the font
$height = $font_size*1.5+4;
// Create the image pallette
$img = imagecreate($width,$height);
// Grey background
$bg  = imagecolorallocate($img, 255, 255, 255);
// White font color
$color = imagecolorallocate($img, 0, 0, 0);

$fontfile = COREFRAME_ROOT.'app/core/libs/fonts/micross.ttf';
imagefttext($img, $font_size, 0, 0, $fontsize+2, $color, $fontfile,$str, array('lineheight'=>1.0) );

// Return the image
header("Content-Type: image/jpeg");
imagegif($img);
// Remove image
imagedestroy($img);
?>