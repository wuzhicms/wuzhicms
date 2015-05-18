<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 程序入口文件
 */

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',substr(dirname(__FILE__),0,-3));

require WWW_ROOT.'configs/web_config.php';
require COREFRAME_ROOT.'core.php';

$GLOBALS['m'] = 'content';
$GLOBALS['f'] = 'map';
$GLOBALS['v'] = 'init';

$app = load_class('application');
$app->run();
?>