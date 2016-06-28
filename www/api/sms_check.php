<?php

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';


if(!isset($GLOBALS['param'])) {
	exit('{"info":"验证失败","status":"n"}');
} elseif($GLOBALS['param']=='') {
	exit('{"info":"验证失败","status":"n"}');
}
$code = strip_tags($GLOBALS['param']);
$posttime = SYS_TIME-300;//5分钟内有效
$db = load_class('db');
$r = $db->get_one('sms_checkcode',"`code`='$code' AND `posttime`>$posttime",'*',0,'id DESC');
if($r) {
	exit('{"info":"验证通过","status":"y"}');
} else {
	exit('{"info":"验证失败","status":"n"}');
}
