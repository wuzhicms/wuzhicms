<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * admin管理员入口文件
 */

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',dirname(__FILE__).'/');

require './configs/web_config.php';
if(defined('_SU')) {
    header("Location: ".WEBURL.'index.php?m=core&v=login&_su='._SU);
}
?>