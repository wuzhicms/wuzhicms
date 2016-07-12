<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
//图片预览
defined('IN_WZ') or exit('No direct script access allowed');
$imgurl = isset($GLOBALS['imgurl']) ? $GLOBALS['imgurl'] : exit('img url error');
load_function('preg_check');
if (preg_match ("/^\/[a-z._\/0-9\-]+$/i", $imgurl) || preg_match ("/^http[s]{0,1}:\/\/[a-z._\/0-9\-]+$/i", $imgurl)) {
    echo "<!doctype html><html><body><div style='margin: 0 auto;text-align:center'><img src='$imgurl' style='max-width: 780px;'></div> </body></html>";
} else {
    exit('img url error');
}
?>