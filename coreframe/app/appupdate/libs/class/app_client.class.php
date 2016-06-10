<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');

/**
 * 系统升级
 */

load_function('curl');

class WUZHI_app_client
{
    private $api_url = 'http://127.0.0.1:8000/api/';

    public function checkUpgradePackages($args)
    {
        return $this->callRemoteAppServer('POST', 'checkUpgradePackages', $args);
    }

    public function callRemoteAppServer($httpMethod, $action, $args)
    {
        $url = $this->api_url.$action;
        if ($httpMethod == 'POST') {
            $result = post_curl($url, $args);
        } else {
            $url    = $url.(strpos($url, '?') ? '&' : '?').http_build_query($params);
            $result = get_curl($url);
        }
        return json_decode($result, true);
    }
}
