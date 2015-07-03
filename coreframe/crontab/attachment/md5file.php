<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 附件md5 file
 * php /home/www/coreframe/crontab.php package pack
 */
//Example: php /workspace/wwwroot/project/coreframe/crontab.php attachment md5file

$db=load_class('db');
$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
while(1) {
    ob_end_clean();
    $result = $db->get_list('attachment', array('md5file'=>''), '*', $start, 100,0,'id DESC');
    if(empty($result)) {
        $e_time = time();
        $r_time = $e_time-$c_time."s\r\r";

        exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
    }

    foreach($result as $rs) {
        if(file_exists(ATTACHMENT_ROOT.$rs['path'])) {
            $md5file = md5_file(ATTACHMENT_ROOT.$rs['path']);
            $db->update('attachment', array('md5file'=>$md5file), array('id' => $rs['id']));
        } else {
            $db->delete('attachment',array('id' => $rs['id']));
        }
    }
    $start += 100;
    echo "running...\r\n";
    sleep(1);
}