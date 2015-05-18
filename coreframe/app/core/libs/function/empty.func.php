<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
exit('Not allow include!');
define('SYS_TIME','');
define('show_dialog','');
define('show_formjs','');
define('HTTP_REFERER','');

/**
 * 加载类函数
 * @param string $class 类名称
 * @param string $m 模块英文名
 * @param string $param 初始化参数
 * @return class
 */

function load_class($class, $m = 'core', $param = NULL) {}

/**
 * 加载类函数
 * @param string $filename 名称
 * @param string $m 模块英文名
 */

function load_function($filename, $m = 'core') {}

/**
 * 加载类函数
 * @param string $filename 文件名称
 * @param string $param 参数名称
 * @return array|string
 */
function get_config($filename,$param = '') {}

/**
 * 检查GLOBALS中是否存在变量
 * @param $key
 * @param int $check_sql 是否sql_replace过滤
 * @return mixed|string
 */
function input($key,$check_sql = 1) {}


/**
 * 设置 cookie
 * @param string $string     变量名
 * @param string $value   变量值
 * @param int $time    过期时间
 * @param bool $encrypt = true    是否加密存储
 */
function set_cookie($string, $value = '', $time = 0, $encrypt = true) {}

/**
 * 获取通过 set_cookie 设置的 cookie 变量
 * @param string $string 变量名
 * @param string $default 默认值
 * @return mixed 成功则返回cookie 值，否则返回 false
 */

function get_cookie($string, $default = '', $encrypt = true) {}

/**
 * 加密字符串
 *
 * @param $string
 * @param string $key
 */
function encode($string,$key = '') {}

/**
 * 解密字符串
 *
 * @param $string
 * @param string $key
 */
function decode($string,$key = '') {}
?>