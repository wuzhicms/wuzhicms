<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2016 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
//添加共享内容
//放到专题管理

defined('INTERFACE_CONTROL') or exit('Undefined INTERFACE_CONTROL');
$tid = intval($GLOBALS['tid']);
$keyid = 'topic'.$tid;
$db = load_class('db');
$where = array('keyid'=>$keyid);
$result = $db->get_list('kind', $where, '*', 0, 100,0);
$total = count($result);
exit_json(array('code' => 200,'total'=>$total, 'lists' => $result));