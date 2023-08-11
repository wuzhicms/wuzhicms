<?php
define('WWW_ROOT', substr(__DIR__, 0, -3));
//200 OK
//201 Created
//401 Unauthorized
//403 Forbidden
//404 Not Found

//nginx配置，配置文件中加入以下内容
/* location /api {
	try_files $uri $uri/  /api/index.php?$query_string;
 } */

//apache配置，配置文件中加入以下内容
/* RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^api/(.*)$ api/index.php?$1 [NC,L,QSA]*/


require WWW_ROOT . 'configs/web_config.php';
require COREFRAME_ROOT . 'core.php';

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '*'; //当前请求的域名

header("Access-Control-Allow-Origin: $origin");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods:POST,GET,OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization,token');
header('Access-Control-Expose-Headers: Content-Length, Access-Control-Allow-Origin, Access-Control-Allow-Headers, Cache-Control, Content-Language, Content-Type');

// /api/member/verificationCode/identifyingCode
$URIS = $_SERVER['REQUEST_URI'];

if ($URIS == '') {
    json_error(404, 'system error');
}
$urlParse = parse_url($URIS);

$path_arr = explode('/', trim($urlParse['path'], '/'));

if (count($path_arr) < 3) {
    json_error(404, 'system error');
}

$m = $GLOBALS['m'] = $path_arr[1];
$f = $GLOBALS['f'] = $path_arr[2];
$v = $GLOBALS['v'] = $path_arr[3];

$GLOBALS['_su'] = 'api';

if (preg_match('/([^a-z0-9_]+)/i', $m)) {
    json_error(1002, 'module err');
}
if (preg_match('/([^a-z0-9_]+)/i', $f)) {
    json_error(1003, 'file err');
}
if (preg_match('/([^a-z0-9_]+)/i', $v)) {
    json_error(1004, 'action err');
}

$app = load_class('application');
$app->run();