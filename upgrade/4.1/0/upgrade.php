<?php
//+----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
//+----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

//更新模版缓存
$c_template = load_class('template');
$dirs = COREFRAME_ROOT."templates";
$c_template->cache_dir_template($dirs);

//更新模型
$c_model = load_class('cache_model');
$c_model->cache_all();