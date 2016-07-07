<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');


//payment ,检查索引是否存在
$fields_index_query = $db->query("show index from wz_payment");
$fields_index = $db->fetch_array($fields_index_query);
if($fields_index['Column_name']!='id' && $fields_index['Key_name']!='PRIMARY') {
	$db->query("ALTER TABLE `wz_payment` ADD PRIMARY KEY(`id`)");
}
//member_group
$fields_arr = $db->get_fields('member_group');
if(!in_array('pid',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member_group` ADD `pid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'");
}

//member
$fields_arr = $db->get_fields('member');
if(!in_array('pw_reset',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member` ADD `pw_reset` TINYINT(1) NOT NULL DEFAULT '1'");
}

//model
$fields_arr = $db->get_fields('model');
if(!in_array('manage_template',$fields_arr)) {
	$db->query("ALTER TABLE `wz_model` ADD `manage_template` VARCHAR(30) NOT NULL");
}
//model_field
$fields_arr = $db->get_fields('model_field');
if(!in_array('workflow_field',$fields_arr)) {
	$db->query("ALTER TABLE `wz_model_field` ADD `workflow_field` SMALLINT(5) NOT NULL DEFAULT '0'");
}
//member_company_data
$fields_arr = $db->get_fields('member_company_data');
if(!in_array('worktype',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member_company_data` ADD `worktype` TINYINT(1) NOT NULL DEFAULT '1'");
}
if(!in_array('companyname',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member_company_data` ADD `companyname` VARCHAR(30) NOT NULL");
}
//pay
$fields_arr = $db->get_fields('pay');
if(!in_array('keytype',$fields_arr)) {
	$db->query("ALTER TABLE `wz_pay` ADD `keytype` TINYINT(3) NOT NULL DEFAULT '1'");
}
//site
$fields_arr = $db->get_fields('site');
if(!in_array('url',$fields_arr)) {
	$db->query("ALTER TABLE `wz_site` ADD `url` VARCHAR(100) NOT NULL");
}
//block
$fields_arr = $db->get_fields('block');
if(!in_array('siteid',$fields_arr)) {
	$db->query("ALTER TABLE `wz_block` ADD `siteid` TINYINT(3) UNSIGNED NOT NULL DEFAULT '1'");
}
if(!in_array('lang',$fields_arr)) {
	$db->query("ALTER TABLE `wz_block` ADD `lang` VARCHAR(10) NOT NULL");
}
//message
$fields_arr = $db->get_fields('message');
if(!in_array('msgtype',$fields_arr)) {
	$db->query("ALTER TABLE `wz_message` ADD `msgtype` TINYINT(3) NOT NULL DEFAULT '0'");
}
//video_data
$fields_arr = $db->get_fields('video_data');
if(!in_array('youku',$fields_arr)) {
	$db->query("ALTER TABLE `wz_video_data` ADD `youku` CHAR( 255 ) NOT NULL DEFAULT ''");
}
if(!in_array('tudou',$fields_arr)) {
	$db->query("ALTER TABLE `wz_video_data` ADD `tudou` CHAR( 255 ) NOT NULL DEFAULT ''");
}
//video_data
$fields_arr = $db->get_fields('video_data');
if(!in_array('youku',$fields_arr)) {
	$db->query("ALTER TABLE `wz_video_data` ADD `youku` CHAR( 255 ) NOT NULL DEFAULT ''");
}
//setting
$fields_arr = $db->get_fields('setting');
if(!in_array('title',$fields_arr)) {
	$db->query("ALTER TABLE `wz_setting` ADD `title` VARCHAR(80) NOT NULL");
}
//copyfrom
$fields_arr = $db->get_fields('copyfrom');
if(!in_array('remark',$fields_arr)) {
	$db->query("ALTER TABLE `wz_copyfrom` ADD `remark` TEXT NOT NULL");
}
//menu
$fields_arr = $db->get_fields('menu');
if(!in_array('isopenid',$fields_arr)) {
	$db->query("ALTER TABLE `wz_menu` ADD `isopenid` TINYINT(1) NOT NULL DEFAULT '0'");
}

//----------------

$rs = $db->get_one('menu', array('m' =>'core','f'=>'set','v'=>'global_vars'));
if(!$rs) {
	$db->query("INSERT INTO `wz_menu`(`name`,`pid`,`m`,`f`,`v`,`data`,`display`) VALUES ('自定义全局变量','2','core','set','global_vars','','1'");
	$menu_pid = $db->insert_id;
	$db->query("INSERT INTO `wz_menu`(`name`,`pid`,`m`,`f`,`v`,`data`,`display`,`menuid`) VALUES ('添加自定义变量',$menu_pid,'core','set','add_global_vars','','1')");
	$db->query("INSERT INTO `wz_menu`(`name`,`pid`,`m`,`f`,`v`,`data`,`display`) VALUES ('修改自定义变量','5001','core','set','edit_global_vars','','0')");
}

$rs = $db->get_one('menu', array('m' =>'core','f'=>'site','v'=>'listing'));
if(!$rs) {
	$db->query("INSERT INTO `wz_menu` (`pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES(2, '站点管理', 'core', 'site', 'listing', '', 7, 1, 0)");
	$menu_pid = $db->insert_id;
	$db->query("INSERT INTO `wz_menu` (`pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES($menu_pid, '添加站点', 'core', 'site', 'add', '', 0, 1, 0),($menu_pid, '站点切换', 'core', 'site', 'changesite', '', 0, 0, 0)");
}

$rs = $db->get_one('menu', array('m' =>'member','f'=>'index','v'=>'check_list'));
if(!$rs) {
	$db->query("INSERT INTO `wz_menu`(`name`,`pid`,`m`,`f`,`v`,`data`,`display`,`isopenid`) VALUES ('审批新会员','6','member','index','check_list','','1','0')");
}

//最后更新菜单缓存
load_class('cache_menu');