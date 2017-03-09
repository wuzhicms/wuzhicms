<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2016 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
function exit_json($array) {
	echo json_encode($array,true);
	exit();
}

if(!isset($GLOBALS['m']) || $GLOBALS['m'] == '') exit_json(array('code'=>-3));
if(!isset($GLOBALS['f']) || $GLOBALS['f'] == '') exit_json(array('code'=>-4));


//定义常量
define('INTERFACE_CONTROL',true);

$m = $GLOBALS['m'];
$f = $GLOBALS['f'];
$v = isset($GLOBALS['v']) ? $GLOBALS['v'] : '';


if (!preg_match('/([^a-z0-9_]+)/i',$m) && !preg_match('/([^a-z_0-9\-]+)/i',$f) && file_exists(COREFRAME_ROOT.'interface_control/'.$m.'/'.$f.'.php')) {
	$db = load_class('db');
	include COREFRAME_ROOT.'interface_control/'.$m.'/'.$f.'.php';
} else {
	exit_json(array('code'=>-6,'msg'=>'file not exists:'.COREFRAME_ROOT.'interface_control/'.$m.'/'.$f.'.php'));
}