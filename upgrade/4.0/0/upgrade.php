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
//特殊：改字段名称
$fields_arr = $db->get_fields('tag');
if(in_array('linkage',$fields_arr)) {
	$db->query("ALTER TABLE `wz_tag` CHANGE `linkage` `linkageid` SMALLINT(5) UNSIGNED NOT NULL COMMENT '类别'");
	$db->query("INSERT INTO `wz_menu` (`menuid`, `pid`, `name`, `m`, `f`, `v`, `data`, `sort`, `display`, `isopenid`) VALUES(307, 5, '模块管理', 'core', 'app', 'init', '', 307, 1, 0)");

}

//更新模版缓存
$c_template = load_class('template');
$dirs = COREFRAME_ROOT."templates";
$c_template->cache_dir_template($dirs);
//更新菜单缓存
load_class('cache_menu');
//更新模型
$c_model = load_class('cache_model');
$c_model->cache_all();