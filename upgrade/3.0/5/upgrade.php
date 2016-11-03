<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//linkage_data
$fields_arr = $db->get_fields('linkage_data');
if(!in_array('initial',$fields_arr)) {
	$db->query("ALTER TABLE `wz_linkage_data` ADD `initial` VARCHAR(1) NOT NULL");
}
if(!in_array('thumb',$fields_arr)) {
	$db->query("ALTER TABLE `wz_linkage_data` ADD `thumb` VARCHAR(150) NOT NULL");
}
if(!in_array('pictures',$fields_arr)) {
	$db->query("ALTER TABLE `wz_linkage_data` ADD `pictures` TEXT NOT NULL");
}
//site
$fields_arr = $db->get_fields('site');
if(!in_array('html_root',$fields_arr)) {
	$db->query("ALTER TABLE `wz_site` ADD `html_root` VARCHAR(200) NOT NULL");
}
if(!in_array('setting',$fields_arr)) {
	$db->query("ALTER TABLE `wz_site` ADD `setting` TEXT NOT NULL");
}

