<?php
//http://p1.zgw.wuzhicms.com/api/getuserinfo.php?jsoncallback=callback&_=1494218946423

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
header('Content-type: application/json');
$jsoncallback = htmlspecialchars($_REQUEST ['jsoncallback']);//把预定义的字符转换为 HTML 实体。

$_uid = get_cookie('_uid');
$_username = get_cookie('_username');

if(!$_uid) {
	$arr = array('is_login'=>0);
} else {
	$arr = array('is_login'=>1,'zguid'=>1,'username'=>$_username);
}


$json_data=json_encode($arr);//转换为json数据
echo $jsoncallback . "(" . $json_data . ")";