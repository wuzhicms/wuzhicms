<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('WWW_ROOT') or exit('No direct script access allowed');
/**
 * 核心文件
 */
define('VERSION','2.1.7');

$GLOBALS = array();
define('SYSTEM_NAME','wuzhicms');
define('IN_WZ',true);
if(ERROR_REPORT==1) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
} elseif(ERROR_REPORT==0) {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}
ini_set('display_errors', 1);
register_shutdown_function('running_fatal');
set_error_handler('log_error');
set_exception_handler('log_exception');

//开始运行时间
$GLOBALS['_startTime'] = microtime(true);


if(version_compare(PHP_VERSION,'5.4.0','<')) {
    ini_set('magic_quotes_runtime',0);
    define('MAGIC_QUOTES_GPC',get_magic_quotes_gpc() ? 1 : 0);
} else {
    define('MAGIC_QUOTES_GPC', 0);
}

define('IS_WIN',strstr(PHP_OS, 'WIN') ? 1 : 0);
define('IS_CLI',PHP_SAPI=='cli'? 1 : 0);
define('SYS_TIME', time());
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

//设置本地时差
date_default_timezone_set(TIME_ZONE);
//输出页面字符集
header('Content-type: text/html; charset='.CHARSET);
if(extension_loaded("zlib") && !ob_start("ob_gzhandler")) ob_start();

//将GET，POST 参数全部转给 GLOBALS ，然后注销 get／post

set_globals();
load_function('common');
autoload();

/**
 * 加载类函数
 * @param string $class 类名称
 * @param string $m 模块英文名
 * @param string $param 初始化参数
 * @return class
 */

function load_class($class, $m = 'core', $param = NULL) {
    static $static_class = array();

    //判断是否存在类，存在则直接返回
    if (isset($static_class[$class])) {
        return $static_class[$class];
    }
    $name = FALSE;
    if (file_exists(COREFRAME_ROOT.'app/'.$m.'/libs/class/'.$class.'.class.php')) {
        $name = 'WUZHI_'.$class;
        if (class_exists($name, FALSE) === FALSE) {
            require_once(COREFRAME_ROOT.'app/'.$m.'/libs/class/'.$class.'.class.php');
        }
    }
    //如果存在扩展类，则初始化扩展类
    if ($class!='application' && $class!='admin' && file_exists(COREFRAME_ROOT.'app/'.$m.'/libs/class/EXT_'.$class.'.class.php')) {
        $name = 'EXT_'.$class;
        if (class_exists($name, FALSE) === FALSE) {
            require_once(COREFRAME_ROOT.'app/'.$m.'/libs/class/EXT_'.$class.'.class.php');
        }
    }

    if ($name === FALSE) {
        $full_dir = '';
        if(OPEN_DEBUG) $full_dir = COREFRAME_ROOT.'app/'.$m.'/libs/class/';
        echo 'Unable to locate the specified class: '.$full_dir.$class.'.class.php';
        exit();
    }

    $static_class[$class] = isset($param) ? new $name($param) : new $name();
    return $static_class[$class];
}

/**
 * 加载类函数
 * @param string $filename 名称
 * @param string $m 模块英文名
 */

function load_function($filename, $m = 'core') {
    static $static_func = array();
    //判断是否加载过，存在则直接返回
    if (isset($static_func[$filename])) {
        return true;
    }
    require_once(COREFRAME_ROOT.'app/'.$m.'/libs/function/'.$filename.'.func.php');
}

/**
 * 加载类函数
 * @param string $filename 文件名称
 * @param string $param 参数名称
 * @return array|string
 */
function get_config($filename,$param = '') {
    static $config;
    if(isset($config[$filename])) return $param ? $config[$filename][$param] : $config[$filename];
    if(file_exists(WWW_ROOT.'configs/'.$filename.'.php')) {
        $config[$filename] = include WWW_ROOT.'configs/'.$filename.'.php';
    } else {
        $full_dir = '';
        if(OPEN_DEBUG) $full_dir = WWW_ROOT.'config/';
        echo 'Unable to locate the specified config: '.$full_dir.$filename.'.php';
        exit();
    }
    return $param ? $config[$filename][$param] : $config[$filename];
}

function autoload() {
    $path = COREFRAME_ROOT.'extend/function/*.func.php';
    $auto_funcs = glob($path);
    if(!empty($auto_funcs) && is_array($auto_funcs)) {
        foreach($auto_funcs as $func_path) {
            include $func_path;
        }
    }
}
/**
 * 检查GLOBALS中是否存在变量
 * @param $key
 * @param int $check_sql 是否sql_replace过滤
 * @return mixed|string
 */
function input($key,$check_sql = 1) {
    if(isset($GLOBALS[$key])) {
        return $check_sql ? sql_replace($GLOBALS[$key]) : $GLOBALS[$key];
    } else {
        return '';
    }
}

function set_globals() {
    if(isset($_GET)) {
        foreach ($_GET as $_key => $_value) {
            $GLOBALS[$_key] = gpc_stripslashes($_value);
        }
        $_GET = array();
    }
    if(isset($_POST)) {
        foreach ($_POST as $_key => $_value) {
            $GLOBALS[$_key] = gpc_stripslashes($_value);
        }
        $_POST = array();
    }
    if(isset($GLOBALS['page'])) {
        $GLOBALS['page'] = max(intval($GLOBALS['page']),1);
        $GLOBALS['page'] = min($GLOBALS['page'],100000000);
    } else {
        $GLOBALS['page'] = 0;
    }
    $_COOKIE = gpc_stripslashes($_COOKIE);
}

function p_addslashes($string) {
    if(is_array($string)) {
        $keys = array_keys($string);
        foreach($keys as $key) {
            $val = $string[$key];
            unset($string[$key]);
            $string[addslashes($key)] = p_addslashes($val);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}

function p_stripslashes($string) {
    if ( ! is_array($string)){
        return stripslashes($string);
    }
    foreach ($string as $key => $val){
        $string[$key] = p_stripslashes($val);
    }
    return $string;
}

function gpc_stripslashes($data) {
    if(MAGIC_QUOTES_GPC) {
        return p_stripslashes($data);
    } else {
        return $data;
    }
}

/**
 * 设置 cookie
 * @param string $string     变量名
 * @param string $value   变量值
 * @param int $time    过期时间
 * @param bool $encrypt = true    是否加密存储
 */
function set_cookie($string, $value = '', $time = 0, $encrypt = true) {
    $time = $time > 0 ? $time : ($value == '' ? SYS_TIME - 3600 : 0);
    $s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
    $string = COOKIE_PRE.$string;
    if($encrypt) $value = encode($value);
    setcookie($string, $value, $time, COOKIE_PATH, COOKIE_DOMAIN, $s);
}

/**
 * 获取通过 set_cookie 设置的 cookie 变量
 * @param string $string 变量名
 * @param string $default 默认值
 * @return mixed 成功则返回cookie 值，否则返回 false
 */

function get_cookie($string, $default = '', $encrypt = true) {
    $string = COOKIE_PRE.$string;
    return isset($_COOKIE[$string]) ? decode($_COOKIE[$string]) : $default;
}
/**
 *
 * @param string $string 变量名
 * @return array
 */
function p_unserialize($string) {
    if(($ret = unserialize($string)) === false) {
        $ret = unserialize(stripslashes($string));
    }
    return $ret;
}
/**
 * 加密字符串
 *
 * @param $string
 * @param string $key
 */
function encode($string,$key = '') {
    $encode = load_class('encrypt');
    return $encode->encode($string,$key);
}
/**
 * 解密字符串
 *
 * @param $string
 * @param string $key
 */
function decode($string,$key = '') {
    $encode = load_class('encrypt');
    return $encode->decode($string,$key);
}
/**
 * Error handler, passes flow over the exception logger with new ErrorException.
 */
function log_error( $num, $str, $file, $line, $context = null ) {
    if(ERROR_REPORT<2 && $num==8) return '';
    log_exception( new ErrorException( $str, 0, $num, $file, $line ));
}

/**
 * Uncaught exception handler.
 */
function log_exception( Exception $e) {
    $file = str_replace(rtrim(COREFRAME_ROOT,'/'),'coreframe->',$e->getFile());
    $file = str_replace(rtrim(WWW_ROOT,'/'),'www->',$file);
    $file = str_replace(rtrim(CACHE_ROOT,'/'),'caches->',$file);
    $data = array();
    $data['type'] = get_class($e);
    $data['msg'] = $e->getMessage();
    $data['file'] = $file;
    $data['line'] = $e->getLine();
    $data['version'] = VERSION;
    $data['php_version'] = PHP_VERSION;
    $data['referer'] = URL();

    if (ERROR_REPORT) {
        if(IS_CLI==0) {
            print "<div style='text-align: center;'>";
            print "<h5 style='color: rgb(190, 50, 50);'>WuzhiCMS Exception Occured:</h5>";
            print "<table style='width: 800px; display: inline-block;'>";
            print "<tr style='background-color:rgb(230,230,230);text-align:left;'><th style='width: 80px;'>Type</th><td>" . $data['type'] . "</td></tr>";
            print "<tr style='background-color:rgb(240,240,240);text-align:left;'><th>Message</th><td>{$data['msg']}</td></tr>";
            print "<tr style='background-color:rgb(230,230,230);text-align:left;'><th>File</th><td>{$file}</td></tr>";
            print "<tr style='background-color:rgb(240,240,240);text-align:left;'><th>Line</th><td>{$data['line']}</td></tr>";
            print "<tr style='background-color:rgb(230,230,230);'><th colspan='2'><a href='http://www.wuzhicms.com/index.php?m=help&f=logerror&msg={$data['msg']}&file={$data['file']}&line={$data['line']}' target='_blank'>Need Help?</a></th></tr>";
            print "</table></div>";
        } else {
            print "------------- WuzhiCMS Exception Occured:------------- \r\n";
            print "Type: {$data['type']} \r\n";
            print "Message: {$data['msg']} \r\n";
            print "File: {$data['file']} \r\n";
            print "Line: {$data['line']} \r\n";
            print date('Y-m-d H:i:s')."\r\n";
        }

        if(OPEN_DEBUG) exit();
    } else {
        $message = "Time: " . date('Y-m-d H:i:s') . "; Type: " . $data['type'] . "; Message: {$e->getMessage()}; File: {$data['file']}; Line: {$data['line']};";
        @file_put_contents(CACHE_ROOT. "logs/error-".CACHE_EXT.'-'.date("ym").".log", $message . PHP_EOL, FILE_APPEND );
    }
    if(function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://ms.wuzhicms.com/index.php?m=help&f=error');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_POST, true);//启用POST提交
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);//3s超时
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置POST提交的字符串
        curl_exec($ch);
        curl_close($ch);
    }
}

/**
 * Checks for a fatal error, work around for set_error_handler not working on fatal errors.
 */
function running_fatal() {
    $error = error_get_last();
    if($error["type"] == E_ERROR || $error["type"] == 4) log_error( $error["type"], $error["message"], $error["file"], $error["line"] );
}
