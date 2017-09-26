<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 自动更新内容模块(app=content)内容
 * 计划任务
 * 第一次 请先手动执行一次，之后放入计划任务，每分钟执行一次
 * 需要修改对应的 tablename 和 modelid
 */
//Example: php /workspace/wwwroot/project/cnnlshop/coreframe/crontab.php search update_content_data --tablename=content_share --modelid=1
//Example 2: php /workspace/wwwroot/project/cnnlshop/coreframe/crontab.php search update_content_data --tablename=point2goods --modelid=8

if(!isset($_argv['commands']['tablename'])) exit("\r\n----------------------\r\nError:Need tablename\r\nExample: \r\nphp ".COREFRAME_ROOT."crontab.php search update_content_data --tablename=content_share --modelid=1\r\n");
if(!isset($_argv['commands']['modelid'])) exit("\r\n----------------------\r\nError:Need tablename\r\nExample: \r\nphp ".COREFRAME_ROOT."crontab.php search update_content_data --tablename=content_share --modelid=1\r\n");

$keyid = $_argv['commands']['modelid'];
$master_table = $_argv['commands']['tablename'];

$crond_end = SYS_TIME+3590;//1小时结束进程
$db = load_class('db');
$maxdata = $db->get_one('search_index', array('keyid' => $keyid),'*',0,'data_id DESC');
if($maxdata) {
	$maxid = $maxdata['data_id'];
} else {
	$maxid = 0;
}
while(1) {
	ob_end_clean();
	//业务逻辑
	$endtime = $e_time = time();//需要使用当前时间，不能使用SYS_TIME

	$where = "`status`=9 AND `id`>$maxid";
	$result = $db->get_list($master_table,$where, '*', $start, 20, 0, 'id ASC');
	if(empty($result)) {
		$r_time = $e_time-$c_time."s\r\r";
		exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
	}
	foreach($result as $rs) {
		$check_data = $db->get_one('search_index', array('keyid' => $keyid,'data_id'=>$rs['id']));
		if($check_data) continue;
		$formdata = array();
		$formdata['m'] = 'content';
		$formdata['keyid'] = $keyid;
		$formdata['data_id'] = $rs['id'];
		$formdata['full_title'] = $rs['title'];
		$formdata['data_key'] = $rs['title'].' '.$rs['keywords'].' '.$rs['remark'];
		$formdata['addtime'] = $rs['addtime'];
		$formdata['updatetime'] = date('Y-m-d H:i:s',$e_time);
		print_r($formdata);
		$id = $db->insert('search_index', $formdata);
		$formdata = array();
		$formdata['id'] = $id;
		$formdata['title'] = $rs['title'];
		$formdata['remark'] = $rs['remark'];
		$formdata['url'] = $rs['url'];
		$formdata['thumb'] = $rs['thumb'];
		$formdata['updatetime'] = $rs['updatetime'];
		$db->insert('search_result', $formdata);
	}
	$start += 100;

	//end业务逻辑
	echo "\r\n-----------".date('H:i:s')."--------------\r\n";

	sleep(2);
}