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
$db = load_class('db');
$formdata = array();
$formdata['id'] = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : exit('-1');
$formdata['cid'] = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : exit('-2');
if (!$formdata['id'] || !$formdata['cid']) exit('-3');
$formdata['addtime'] = SYS_TIME;
$formdata['ip'] = get_ip();

$qkey = get_cookie('qkey');
if ($qkey == '') {
    $formdata['qkey'] = uniqid(); //13位 唯一值，从cookie中获取和写入，用于记录uv和pv
    $lefttime = SYS_TIME + 2592000;
    set_cookie('qkey', $formdata['qkey'], $lefttime);
} else {
    $formdata['qkey'] = $qkey;
}

$db->insert('content_stat', $formdata);

// 是否有条目 没有就插入
$r = $db->get_one('content_rank', array('cid' => $formdata['cid'], 'id' => $formdata['id']));
if (!$r) {
    $db->insert('content_rank', array('cid' => $formdata['cid'], 'id' => $formdata['id']));
    $r['views'] = 0;
}
session_start();
$setting = $db->get_one('setting', array('keyid' => 'view_time'));
$view_time = $setting['data']; //防刷新时间

$id = 'id'.strval($r['id']);//ssesion name can't be a num
if (isset($_SESSION[$id])) {
    if (time() - $_SESSION[$id] < $view_time) {
        // 如果时间小于防刷新时间且是同一篇则不运行
        $views = $r['views'];
        echo '$("#hits").html(' . $views . ');';
    } else {
        addview($r, $db, $formdata);
        $_SESSION[$id] = time();
    }
} else {
    addview($r, $db, $formdata);
    $_SESSION[$id] = time();

}

function addview($r, $db, $formdata)
{
    // 访问数据增加
    $views = $r['views'] + 1;
    $yesterdayviews = (date('Ymd', $r['updatetime']) == date('Ymd', strtotime('-1 day'))) ? $r['dayviews'] : $r['yesterdayviews'];
    $dayviews = (date('Ymd', $r['updatetime']) == date('Ymd', SYS_TIME)) ? ($r['dayviews'] + 1) : 1;
    $weekviews = (date('YW', $r['updatetime']) == date('YW', SYS_TIME)) ? ($r['weekviews'] + 1) : 1;
    $monthviews = (date('Ym', $r['updatetime']) == date('Ym', SYS_TIME)) ? ($r['monthviews'] + 1) : 1;
    $db_array = array('views' => $views, 'yesterdayviews' => $yesterdayviews, 'dayviews' => $dayviews, 'weekviews' => $weekviews, 'monthviews' => $monthviews, 'updatetime' => SYS_TIME);
    $db->update('content_rank', $db_array, array('cid' => $formdata['cid'], 'id' => $formdata['id']));
    echo '$("#hits").html(' . $views . ');';
}
