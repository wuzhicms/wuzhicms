<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//promote
$fields_arr = $db->get_fields('promote');
if(!in_array('stat_table',$fields_arr)) {
	$db->query("ALTER TABLE `wz_promote` ADD `stat_table` MEDIUMINT(6) UNSIGNED NOT NULL DEFAULT '0'");
}
