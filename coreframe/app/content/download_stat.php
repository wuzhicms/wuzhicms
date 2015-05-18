<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 内容模块访问统计
 */
defined('IN_WZ') or exit('No direct script access allowed');

$id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : exit('-1');
$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : exit('-2');
if(!$id || !$cid) exit('-3');
$categorys = get_cache('category','content');
$models = get_cache('model_content','model');
$modelid = $categorys[$cid]['modelid'];
if(!$modelid) exit('-4');
$db = load_class('db');
$master_table = $models[$modelid]['master_table'];
if(!$master_table) exit('-5');
$db->update($master_table, "`down_numbers`=(`down_numbers`+1)", array('id' => $id));
echo '100';
?>
