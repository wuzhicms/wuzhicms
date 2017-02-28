<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//wz_site
$fields_arr = $db->get_fields('site');
if(!in_array('baidu_site',$fields_arr)) {
	$db->query("ALTER TABLE `wz_site` ADD `baidu_site` VARCHAR(50) NOT NULL");
}
if(!in_array('baidu_token',$fields_arr)) {
	$db->query("ALTER TABLE `wz_site` ADD `baidu_token` VARCHAR(32) NOT NULL");
}

$fields_arr = $db->get_fields('member');
if(!in_array('companyname',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member` ADD `companyname` CHAR(80) NOT NULL");
}
$fields_arr = $db->get_fields('coupon_card');
if(!in_array('groupname',$fields_arr)) {
	$db->query("ALTER TABLE `wz_coupon_card` ADD `groupname` VARCHAR(10) NOT NULL");
}
$fields_arr = $db->get_fields('linkage_data');
if(!in_array('isgroup',$fields_arr)) {
	$db->query("ALTER TABLE `wz_linkage_data` ADD `isgroup` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'");
}
