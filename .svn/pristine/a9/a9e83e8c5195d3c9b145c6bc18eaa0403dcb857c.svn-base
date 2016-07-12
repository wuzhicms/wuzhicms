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
    private $api_url = 'http://update.wuzhicms.cn/api/';

    public function checkUpgradePackages($args)
    {
        return $this->callRemoteAppServer('POST', 'checkUpgradePackages', $args);
    }

    public function getUpdatePackage($packageId)
    {
        return $this->callRemoteAppServer('GET', 'getPackage', array('packageId' => $packageId));
    }

    public function downloadPackage($packageId)
    {
        list($url, $args) = $this->prepareHttpUrlAndParams('downloadPackage', array('packageId' => $packageId));
        $url              = $url.(strpos($url, '?') ? '&' : '?').http_build_query($args);
        $filePath         = $this->download($url);
        return $filePath;
    }

    public function callRemoteAppServer($httpMethod, $action, $args)
    {
        list($url, $args) = $this->prepareHttpUrlAndParams($action, $args);

        if ($httpMethod == 'POST') {
            $result = post_curl($url, $args);
        } else {
            $url    = $url.(strpos($url, '?') ? '&' : '?').http_build_query($args);
            $result = get_curl($url);
        }
        return json_decode($result, true);
    }

    private function prepareHttpUrlAndParams($action, $args)
    {
        $url           = $this->api_url.$action;
        $args['host']  = WEBURL;
        $args['debug'] = OPEN_DEBUG ? true : false;

        return array($url, $args);
    }

    private function download($url)
    {
        $fileName = md5($url).'_'.time();
        $filePath = CACHE_ROOT.'upgrade/'.$fileName;
        $fp       = fopen($filePath, 'w');

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_exec($curl);
        curl_close($curl);

        fclose($fp);

        return $filePath;
    }
}
