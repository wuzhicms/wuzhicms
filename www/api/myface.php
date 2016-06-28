<?php
/**
 * 我的头像
 */

define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$_uid = get_cookie('_uid');
$url = avatar($_uid,180);
header("Location:".$url);
?>