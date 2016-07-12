<?php
set_time_limit(0);
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 将微信的图片更新到嘉宾，通过pageid 标识符
 */
//Example: php /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin update_img
//nohup php -f /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin update_img > update_imglog.txt 2>&1 &

$db = load_class('db');
while(1) {
    ob_end_clean();
    $result = $db->get_list('jiabin', array('status' => 1), '*', 0, 5, 0, 'id ASC');
    foreach ($result as $rs) {
        $tmp_arr = array();
        $result2 = $db->get_list('weixin_uploadfile', array('status' => 1,'pageid'=>$rs['pageid']), '*', 0, 8, 0, 'fileid ASC');
        foreach($result2 as $r) {
            $fileurl =  '/uploadfile/weixin/'.date('Y/m/d', $r['addtime']).'/'.$r['localId'] . ".jpg";;
            $tmp_arr[] = array(
                'url' => $fileurl,
                'alt' => ''
            );
        }
        $formdata = array();
        $formdata['shenghuozhao'] = array2string($tmp_arr);
        $db->update('jiabin', array('status'=>2), array('id' => $rs['id']));
        $db->update('jiabin_data', $formdata, array('id' => $rs['id']));
        print_r($tmp_arr);
        echo "ok\r\n";
    }
    //镜像
    $result = $db->get_list('jiabin_mirror', array('status' => 1), '*', 0, 5, 0, 'id ASC');
    foreach ($result as $rs) {
        $tmp_arr = array();
        $result2 = $db->get_list('weixin_uploadfile', array('status' => 1,'pageid'=>$rs['pageid']), '*', 0, 8, 0, 'fileid ASC');
        foreach($result2 as $r) {
            $fileurl =  '/uploadfile/weixin/'.date('Y/m/d', $r['addtime']).'/'.$r['localId'] . ".jpg";;
            $tmp_arr[] = array(
                'url' => $fileurl,
                'alt' => ''
            );
        }
        $formdata = array();
        $formdata['shenghuozhao'] = array2string($tmp_arr);
        $db->update('jiabin_mirror', array('status'=>2), array('id' => $rs['id']));
        $db->update('jiabin_data_mirror', $formdata, array('id' => $rs['id']));
        print_r($tmp_arr);
        echo "ok\r\n";
    }
    echo "running...\r\n";
    sleep(2);
}
