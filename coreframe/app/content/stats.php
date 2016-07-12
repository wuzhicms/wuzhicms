<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 内容模块访问数显示
 */
defined('IN_WZ') or exit('No direct script access allowed');
$db = load_class('db');

if(!empty($GLOBALS['keyid'])) {
    $rs = array();
    foreach($GLOBALS['keyid'] as $r) {
        $tmp = explode('_',$r);
        $cid = intval($tmp[0]);
        $id = intval($tmp[1]);
        $where = "`cid`='$cid' AND `id`='$id'";
        $rs[] = $db->get_one('content_rank', $where);
    }
    echo json_encode($rs,true);
}

?>