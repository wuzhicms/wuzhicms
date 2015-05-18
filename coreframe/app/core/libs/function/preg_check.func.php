<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

/**
 * 表单校验函数库
 */

/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}
//判断http 地址是否合法
function check_url($url) {
    return preg_match ("/^[a-z0-9][a-z0-9\-]+[a-z0-9](\.[a-z]{2,4})+$/i", $url);
}
//判断http 地址是否有效
function url_exists($url) {
    $head = @get_headers($url);
    return is_array($head) ?  true : false;
}
function is_tel($tel) {
    return strlen($tel) == 11 && preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$tel);
}
