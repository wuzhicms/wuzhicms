<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 自定义程序入口文件
 * web.php?at=1
 */

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',dirname(__FILE__).'/');

require './configs/web_config.php';
require COREFRAME_ROOT.'core.php';
if(!isset($GLOBALS['at'])) MSG(L('parameter_error'));
$at = intval($GLOBALS['at']);
if(!$at) MSG(L('parameter_error'));
$atfile = ceil($at/100);

$route_config = get_cache('route_'.$atfile,'route');

$GLOBALS['m'] = $route_config[$at]['m'];
$GLOBALS['f'] = $route_config[$at]['f'];
$GLOBALS['v'] = $route_config[$at]['v'];
if(isset($route_config[$at]['extend'])) {
    //TODO 缓存的时候，如果extend为空，则不缓存该字段
    parse_str($route_config[$at]['extend']);
}
$app = load_class('application');
$app->run();
?>