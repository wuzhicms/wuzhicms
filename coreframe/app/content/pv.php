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
$redis = new Redis();
$expire = 60;//1分钟以内的重复访问不计
$redis->connect("127.0.0.1", 6379);

$formdata = array();
$formdata['referer'] = strip_tags(HTTP_REFERER);
//获取访问时间
$formdata['addtime'] = SYS_TIME;
$formdata['ip'] = get_ip();
$key ="ip". $formdata['ip'];

//验证cookie信息qkey，便于后续对uv和pv的统计
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

//redis优化数据库读取
if( $redis->exists($key)){
    $views = $redis->get($key);
} else {
    $views = $db->insert($table, $formdata);
    $redis->set($key,$views);
    $redis->expire($key, $expire);
}

echo 'document.getElementById("web_pv_num").innerText= '.$views.';';