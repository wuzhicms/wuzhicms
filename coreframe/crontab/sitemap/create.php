<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * sitemap定时生成
 *
 * 建议每天更新一次，时时提交，可开启百度sitemap时时提交
 */
//Example: php /workspace/wwwroot/wuzhicms_v3/coreframe/crontab.php sitemap create

$db=load_class('db');

$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();

//---------
$weburl = rtrim(WEBURL,'/');
$sitemap = load_class('sitemap','core',$weburl);

$sitemap->setPath(WWW_ROOT);

$sitemap->setFilename('sitemap');

$models = get_cache('model_content','model');
foreach($models as $modelid=>$model) {
	ob_end_clean();
	echo $model['name'].":查询开始 \r\n";
	if($model['master_table']=='content_share') {
		$where = "`status`=9 AND `modelid`='$modelid'";
		$result = $db->get_list('content_share', $where, '*', 0, 10000, 0, 'id DESC');
		foreach ($result as $r) {
			$sitemap->addItem($r['url'], '1.0', 'daily', 'Today');
		}
	} else {
		$where = "`status`=9";
		$master_table = $model['master_table'];
		$result = $db->get_list($master_table, $where, '*', 0, 10000, 0, 'id DESC');
		foreach ($result as $r) {
			$sitemap->addItem($r['url'], '1.0', 'daily', 'Today');
		}
	}

	echo "查询完成\r\n\r\n";
	time_nanosleep(0, 100000000);

}


$sitemap->createSitemapIndex(WEBURL.'sitemap/', 'Today');


//---------

$e_time = time();
$r_time = $e_time-$c_time."s\r\r";

exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");