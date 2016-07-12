<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 地图
 */
class map{
    private $siteconfigs;
    public function __construct() {

    }

    /**
     * 百度地图
     */
    public function baidumap() {
        $map_x = isset($GLOBALS['x']) && !empty($GLOBALS['x']) ? $GLOBALS['x'] : 116;
        $map_y = isset($GLOBALS['y']) && !empty($GLOBALS['y']) ? $GLOBALS['y'] : 39;
        $map_zoom = isset($GLOBALS['zoom']) && !empty($GLOBALS['zoom']) ? $GLOBALS['zoom'] : 12;
        if(($map_x=='116' || $map_x=='0.000000') && !empty($GLOBALS['address'])) {
            $address = $GLOBALS['address'];
        } else {
            $address = '';
        }
        include T('map','baidumap');
    }
}
?>