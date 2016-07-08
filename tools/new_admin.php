<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------

$username = '管理员帐号';//用户名
$password = 'wuzhicms';//密码

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',dirname(__FILE__).'/');

require './configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$formdata = array();
$formdata['factor'] = random_string('diy',5,'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789');
$formdata['password'] = md5(md5($password).$formdata['factor']);
$db = load_class('db');

$formdata2 = array();
$formdata2 = $formdata;
$formdata2['username'] = $username;
$formdata2['modelid'] = 10;
$formdata2['groupid'] = 3;
$uid = $db->insert('member', $formdata2);

$formdata3 = array();
$formdata3 = $formdata;
$formdata3['uid'] = $uid;
$formdata3['role'] = ',1,';
$db->insert('admin', $formdata3);

MSG('管理员帐号添加成功,密码请打开当前程序查看');
?>