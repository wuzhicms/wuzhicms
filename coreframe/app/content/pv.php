<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 总站访问次数统计
 */
defined('IN_WZ') or exit('No direct script access allowed');
$db = load_class('db');
$formdata = array();
$formdata['referer'] = strip_tags(HTTP_REFERER);
$formdata['addtime'] = SYS_TIME;
$formdata['ip'] = get_ip();

$qkey = get_cookie('qkey');
if($qkey=='') {
    $formdata['qkey'] = uniqid();//13位 唯一值，从cookie中获取和写入，用于记录uv和pv
    $lefttime = SYS_TIME+2592000;
    set_cookie('qkey',$formdata['qkey'],$lefttime);
} else {
    $formdata['qkey'] = $qkey;
}
$table = 'web_pv';
$siteid = intval($GLOBALS['siteid']);
if($siteid) $table.='_'.$siteid;
$views = $db->insert($table, $formdata);
echo '$("#web_pv_num").html("'.number_format($views).'");';
?>
