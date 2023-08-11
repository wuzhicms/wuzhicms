<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 文章定时发布
 * 建议：每10分钟执行一次，频率不易过低或过高
 */
//Example: php /workspace/wwwroot/project/zgw/p1/coreframe/crontab.php content timing_publish

$db=load_class('db');

$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
$nowtime = SYS_TIME;
while(1) {
    ob_end_clean();
    $result = $db->get_list('content_share',"`status`=8 AND `addtime`<$nowtime", '*', $start, 100,0,'id ASC');
    if(empty($result)) {
        $e_time = time();
        $r_time = $e_time-$c_time."s\r\r";

        exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
    }
    foreach($result as $rs) {
        $db->update('content_share', array('status'=>9), array('id' => $rs['id']));
        echo $rs['title']."\r\n";
    }
    $start += 100;
    echo "running...\r\n";
	time_nanosleep(0, 100000000);
}