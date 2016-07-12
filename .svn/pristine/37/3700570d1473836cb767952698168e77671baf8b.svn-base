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
 * 下载微信上传的文件
 */
//Example: php /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin downloadfile
//nohup php -f /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin downloadfile > downlog.txt 2>&1 &
function downloadWeixinFile($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $package = curl_exec($ch);
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    $imageAll = array_merge(array('header' => $httpinfo), array('body' => $package));
    return $imageAll;
}

function saveWeixinFile($filename, $filecontent)
{
    $local_file = fopen($filename, 'w');
    if (false !== $local_file){
        if (false !== fwrite($local_file, $filecontent)) {
            fclose($local_file);
        }
    }
}
load_function('weixin','weixin');
$db = load_class('db');

while(1) {
    ob_end_clean();
    $token = get_cache('token','weixin');
    $access_token = $token['access_token'];

    $result = $db->get_list('weixin_uploadfile', array('status' => 0), '*', 0, 5, 0, 'fileid ASC');
    foreach ($result as $rs) {
        $mediaid = $rs['serverId'];
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=$access_token&media_id=$mediaid";
        $fileInfo = downloadWeixinFile($url);

        $dir = ATTACHMENT_ROOT . 'weixin/' . date('Y/m/d', $rs['addtime']) . '/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, 1);
        }
        $filename = $dir . $rs['localId'] . ".jpg";
        saveWeixinFile($filename, $fileInfo["body"]);
        $db->update('weixin_uploadfile', array('status' => 1), array('fileid' => $rs['fileid']));
        echo $filename."\r\n";

    }
    echo "running...\r\n";
    sleep(5);
}
