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