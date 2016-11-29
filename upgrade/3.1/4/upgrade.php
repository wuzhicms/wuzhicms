<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//linkage_data
$fields_arr = $db->get_fields('member');
if(!in_array('companyname',$fields_arr)) {
	$db->query("ALTER TABLE `wz_member` ADD `companyname` CHAR(80) NOT NULL");
}
