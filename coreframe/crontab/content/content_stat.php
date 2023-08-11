<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容统计
 * 建议：计划任务，每天定时更新
 */
//Example: php /workspace/wwwroot/project/zgw/p1/coreframe/crontab.php content content_stat

$db=load_class('db');

$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
$nowtime = SYS_TIME;

//昨天
$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
$yesterday = date('Ymd',$beginYesterday);
$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
//今天
$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
$today = date('Ymd',$beginToday);
$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

$categorys = get_cache('category','content');

foreach ($categorys as $cid=>$cat) {
	if($cat['type']!=0) continue;
    ob_end_clean();
    //今天
	$where = "`status`=9 AND `cid`=$cid AND `addtime`>$beginToday AND `addtime`<$endToday";
	$total = $db->count_result('content_share', $where);

	$y1 = $db->get_one('content_day_stat', array('dayid' => $today,'cid'=>$cid));
	if($y1) {
		$db->update('content_day_stat', array('num'=>$total), array('dayid' => $today,'cid'=>$cid));
	} else {
		$db->insert('content_day_stat', array('num'=>$total,'dayid' => $today,'cid'=>$cid));
	}
	echo "cid=$cid 今天：$total ";
	//昨天
	$where = "`status`=9 AND `cid`=$cid AND `addtime`>$beginYesterday AND `addtime`<$endYesterday";
	$total = $db->count_result('content_share', $where);

	$y1 = $db->get_one('content_day_stat', array('dayid' => $yesterday,'cid'=>$cid));
	if($y1) {
		$db->update('content_day_stat', array('num'=>$total), array('dayid' => $yesterday,'cid'=>$cid));
	} else {
		$db->insert('content_day_stat', array('num'=>$total,'dayid' => $yesterday,'cid'=>$cid));
	}
	echo "昨天：$total\r\n";
	time_nanosleep(0, 100000000);
}