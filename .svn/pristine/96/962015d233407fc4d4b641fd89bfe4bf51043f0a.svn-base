<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 修复联动菜单层级数据
 */
//Example: php /workspace/wwwroot/wuzhicms_v2/src/coreframe/crontab.php content linkage --linkageid=/1/

if(!isset($_argv['commands']['linkageid'])) exit("\r\n----------------------\r\nError:Need linkageid\r\nExample: \r\nphp ".COREFRAME_ROOT."crontab.php content linkage --linkageid=/1/\r\n");
$linkageid = intval(trim($_argv['commands']['linkageid'],'/'));

$db=load_class('db');
$r = $db->get_one('linkage', array('linkageid' => $linkageid));
if(!$r) exit("\r\nError:linkageid not exists!\r\n");


$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
while(1) {
    ob_end_clean();

    $result = $db->get_list('linkage_data', '', '*', $start, 100,0,'lid ASC');
    if(empty($result)) {
        $e_time = time();
        $r_time = $e_time-$c_time."s\r\r";

        exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
    }
    foreach($result as $rs) {
        if($rs['pid']) {
            $pr = $db->get_one('linkage_data', array('lid' => $rs['pid']));
            if (!$pr) {
                $rs['pid'] = 0;
            }
        }
        $cr = $db->get_one('linkage_data', array('pid' => $rs['lid']));
        if($cr) {
            $rs['child'] = 1;
        } else {
            $rs['child'] = 0;
        }
        $db->update('linkage_data', $rs, array('lid' => $rs['lid']));
    }
    $start += 100;
    echo "running...\r\n";
    sleep(1);
}