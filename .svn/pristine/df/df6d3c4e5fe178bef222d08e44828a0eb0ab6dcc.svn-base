<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容模型，图片裁剪,裁剪为 宽固定（300px) ，高适配（最大为600px）。
 */
//Example: php /workspace/wwwroot/wuzhicms_v2/src/coreframe/crontab.php content imagecut --modelid=/5/

$models = get_cache('model_content','model');
if(!isset($_argv['commands']['modelid'])) exit("\r\n----------------------\r\nError:Need modelid\r\nExample: \r\nphp ".COREFRAME_ROOT."crontab.php content imagecut --modelid=/5/\r\n");
$modelid = intval(trim($_argv['commands']['modelid'],'/'));

if(!isset($models[$modelid])) exit("\r\nError:modelid not exists!\r\n");
$master_table = $models[$modelid]['master_table'];

if($master_table=='content_share') {
    $where = "`modelid`=$modelid";
} else {
    $where = '';
}

$db=load_class('db');
$start = 0;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
while(1) {
    ob_end_clean();

    $result = $db->get_list($master_table, $where, 'id,thumb,modelid', $start, 2,0,'id DESC');
    if(empty($result)) {
        $e_time = time();
        $r_time = $e_time-$c_time."s\r\r";

        exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
    }

    foreach($result as $rs) {
        if(empty($rs['thumb'])) continue;
        print_r($rs);
        $rs['thumb'] = str_replace('img_300_600_','',$rs['thumb']);
        http://dev.wuzhicms.com/uploadfile/2015/05/1247/img_300_600_201505121147282152.jpg
        $newimage = imagecut($rs['thumb'],300,600,2);
        $db->update($master_table, array('thumb'=>$newimage), array('id' => $rs['id']));
    }
    $start += 2;
    echo "running...\r\n";
    sleep(1);
}