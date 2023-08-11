<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 在线统计
 */
defined('IN_WZ') or exit('No direct script access allowed');
$db = load_class('db');
$starttime = SYS_TIME - 300; //10分钟内登录过的用户
$redis = new Redis();
$key = "visitors";
$expire = 300;//second
$redis->connect("127.0.0.1", 6379);
if ($redis->exists($key)) {
// 存在redis缓存则从redis获取数据
    $result = $redis->get($key);
    echo '$("#web_online_num").html("' . $result . '");';
} else {
    // 从数据库读取并存入redis
    $query = $db->query("SELECT count(*) FROM (SELECT count(*) FROM `wz_web_pv` WHERE `addtime`>$starttime GROUP BY ip) as a");
    $result = $db->fetch_array($query);
    $value=$result["count(*)"];
    $redis->set($key, $value);
    $redis->expire($key, $expire);
    echo '$("#web_online_num").html("' . number_format($value) . '");';
}


