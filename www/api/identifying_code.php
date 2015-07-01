<?php

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';

load_class('session');

$identifying = load_class('identifying_code');
$code = random_string('diy', 4, 'abcdefghkmnprsuvwxyzABCDEFGHKMNPRSUVWXYZ23456789');
$_SESSION['code'] = strtolower($code);
$w = isset($GLOBALS['w']) ? intval($GLOBALS['w']) : 120;
$h = isset($GLOBALS['h']) ? intval($GLOBALS['h']) : 27;
$identifying->image_one($code,$w,$h);
