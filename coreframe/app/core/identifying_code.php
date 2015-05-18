<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 网站首页
 */
load_class('session');
class identifying_code{
    public function __construct() {

    }
    public function init() {
        $identifying = load_class('identifying_code');
        $code = random_string('diy', 4, 'abcdefghkmnprsuvwxyzABCDEFGHKMNPRSUVWXYZ23456789');
        $_SESSION['code'] = strtolower($code);
        $w = isset($GLOBALS['w']) ? intval($GLOBALS['w']) : 120;
        $h = isset($GLOBALS['h']) ? intval($GLOBALS['h']) : 27;
        $identifying->image_one($code,$w,$h);
    }
}
?>
