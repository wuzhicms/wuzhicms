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
$starttime = SYS_TIME-600;//10分钟内登录过的用户
$query = $db->query("SELECT * FROM `wz_web_pv` WHERE `addtime`>$starttime GROUP BY `qkey`");
$result = $db->fetch_array($query);
$online = count($result);
echo '$("#web_online_num").html("'.number_format($online).'");';
?>
