<?php

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';

load_class('session');
if(!isset($GLOBALS['param'])) {
	exit('{"info":"验证码错误","status":"n"}');
} elseif($GLOBALS['param']=='') {
	exit('{"info":"验证码错误","status":"n"}');
}
if($_SESSION['code'] == strtolower(trim($GLOBALS['param']))) {
	exit('{"info":"输入正确","status":"y"}');
} else {
	exit('{"info":"验证码错误","status":"n"}');
}