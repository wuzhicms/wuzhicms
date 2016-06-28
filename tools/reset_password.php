<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 重置密码,放置程序到根目录.执行
 * reset_password.php
 */

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',dirname(__FILE__).'/');

require './configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$formdata = array();
$formdata['factor'] = random_string('diy',6,'0123456789abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ');
$formdata['password'] = md5(md5('wuzhicms').$formdata['factor']);
$db = load_class('db');
$r = $db->get_one('admin', array('uid' => 1));
if(!$r) MSG('admin 表 uid = 1 不存在');
$r2 = $db->get_one('member', array('uid' => 1));
if(!$r) MSG('member 表 uid = 1 不存在');
$db->update('admin', $formdata, array('uid' => 1));
$db->update('member', $formdata, array('uid' => 1));
MSG('密码重置成功');
?>