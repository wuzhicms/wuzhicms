<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

//  设置会员组权限：个人会员 需要升级 ，游客会员组需要判断是否有权限
//attachment
$fields_arr = $db->get_fields('attachment');
if(!in_array('userid',$fields_arr)) {
	$db->query("ALTER TABLE `wz_attachment` ADD `userid` INT(10) UNSIGNED NOT NULL DEFAULT '0'");
}
//content_share
$fields_arr = $db->get_fields('content_share');
if(!in_array('push',$fields_arr)) {
	$db->query("ALTER TABLE `wz_content_share` ADD `push` TINYINT(1) NOT NULL DEFAULT '0'");
}
if(!in_array('old_id',$fields_arr)) {
	$db->query("ALTER TABLE `wz_content_share` ADD `old_id` INT(10) UNSIGNED NOT NULL DEFAULT '0'");
}
//member
$fields_arr = $db->get_fields('member');
if(!in_array('sys_name',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member` ADD `sys_name` TINYINT(1) NOT NULL DEFAULT '0'");
}

//最后更新菜单缓存
load_class('cache_menu');