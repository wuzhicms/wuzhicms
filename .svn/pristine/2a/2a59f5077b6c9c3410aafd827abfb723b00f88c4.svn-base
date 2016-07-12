<?php
define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
load_class('qrcode');
$str = $GLOBALS['str'];
WUZHI_qrcode::png($str, false, 'L', 4, 0);