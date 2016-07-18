<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//wz_member
$fields_arr = $db->get_fields('member');
if(!in_array('sys_name',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member` ADD `sys_name` TINYINT(1) NOT NULL DEFAULT '1'");
}
