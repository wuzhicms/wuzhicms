<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//search_index
$fields_arr = $db->get_fields('search_index');
if(!in_array('addtime',$fields_arr)) {
	$db->query("ALTER TABLE `wz_search_index` ADD `addtime` INT(10) UNSIGNED NOT NULL DEFAULT '0'");
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