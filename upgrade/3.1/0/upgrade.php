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
//wz_message
$fields_arr = $db->get_fields('message');
if(!in_array('title',$fields_arr)) {
	$db->query("ALTER TABLE `wz_message` ADD `title` VARCHAR(80) NOT NULL AFTER `status`");
}
$db->query("TRUNCATE TABLE wz_member_group_priv");
$categorys = get_cache('category','content');
$gids = get_cache('group','member');
foreach($categorys as $_cid=>$tmp) {
	if($tp['type']==2) continue;
	$formdata = array();
	$formdata['value'] = $_cid;

	foreach($gids as $_gid=>$tmp2) {
		if($_gid==1) continue;
		$formdata['priv'] = 'view';
		$formdata['groupid'] = $_gid;
		$db->insert('member_group_priv', $formdata);
		$formdata['priv'] = 'listview';
		$db->insert('member_group_priv', $formdata);
	}
}
$cache_global = load_class('cache_global_vars');
$cache_global->cache_all();