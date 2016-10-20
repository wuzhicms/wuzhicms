<?php
define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
error_reporting(0);
define('IN_DISCUZ', TRUE);

define('UC_CLIENT_VERSION', '1.5.0');	//note UCenter 版本标识
define('UC_CLIENT_RELEASE', '20081031');

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');


defined('MAGIC_QUOTES_GPC') || define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
$setting = get_cache('setting', 'member');

if(is_numeric($setting['uc_key'])) {
	exit('uc_key is too easy!');
}
//通信相关
define('UC_KEY', $setting['uc_key']);				// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
define('UC_API', $setting['uc_api']);	// UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET', 'gbk');				// UCenter 的字符集
define('UC_IP', $setting['uc_ip']);					// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID', $setting['uc_appid']);					// 当前应用的 ID

$_DCACHE = $get = $post = array();
$code = isset($GLOBALS['code']) ? $GLOBALS['code'] : '';
$get = $GLOBALS;
parse_str(_authcode($code, 'DECODE', UC_KEY), $get);
if(MAGIC_QUOTES_GPC) $get = _stripslashes($get);

if(empty($get))exit('Invalid Request');
if(SYS_TIME - $get['time'] > 3600) exit('Authracation has expiried');
if($get['time']>SYS_TIME+3600) exit('Authracation time error');

require_once WWW_ROOT.'./api/uc_client/lib/xml.class.php';
$post = file_get_contents('php://input');
$post = xml_unserialize($post);

if(in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcreditsettings', 'updatecreditsettings'))) {
	$uc_note = new uc_note();
	header('Content-type: text/html; charset='.CHARSET);
	$action = $get['action'];
	echo $uc_note->$action($get, $post);
	exit();
} else {
	exit(API_RETURN_FAILED);
}

class uc_note {

	private $member, $uc_db, $applist;
	function __construct() {
		//$this->uc_db = load_class('db', 'core', 'uc_mysql_config');
		define('M', 'member');
		$this->member = load_class('member', 'member');
	}

	// 测试通信
	public function test() {
		return API_RETURN_SUCCEED;
	}
	//	更改用户名
	public function renameuser($get, $post) {
		return $this->member->renameuser($get['uid'], $get['oldusername'], $get['newusername']) ? API_RETURN_SUCCEED : API_RETURN_FAILED;
	}
	//	更改用户密码
	public function updatepw($get, $post) {
		//	如果没有传递新的密码直接返回成功
		if(empty($get['password']))return  API_RETURN_SUCCEED;
		load_function('preg_check');
		$factor = random_string('diy', 6);
		if($this->member->db->update('member', array('factor'=>$factor, 'password'=>md5(md5($get['password']).$factor)), 'username="'.$get['username'].'"')){
			return API_RETURN_SUCCEED;
		}else{
			return API_RETURN_FAILED;
		}
	}
	//	删除用户
	public function deleteuser($get, $post) {
		$uids = $get['ids'];
		!API_DELETEUSER && exit(API_RETURN_FORBIDDEN);

		return API_RETURN_SUCCEED;
	}
	//	同步登录
	function synlogin($get, $post) {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$username = $get['username'];
		$r = $this->member->db->get_one('member', 'username="'.$username.'"');
		print_r($r);
		if($r){
			$cookietime = COOKIE_TTL ? SYS_TIME.COOKIE_TTL : 0;
			set_cookie('auth', encode($r['uid']."\t".$r['password']."\t".$cookietime, substr(md5(_KEY), 8, 8)), $cookietime);
			set_cookie('_uid', $r['uid'], $cookietime);
			set_cookie('_username', $r['username'], $cookietime);
			set_cookie('_groupid', $r['groupid'], $cookietime);
		}
		return API_RETURN_SUCCEED;
	}
	//	同步退出
	function synlogout($get, $post) {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		set_cookie('auth', '', -1);
		set_cookie('_uid', '', -1);
		set_cookie('_username', '', -1);
		set_cookie('_groupid', '', -1);
		return API_RETURN_SUCCEED;
	}
	//	更新应用列表
	function updateapps($get, $post) {
		if(!API_UPDATEAPPS) {
			return API_RETURN_FORBIDDEN;
		}
		set_cache('uc_apps', $post, 'member');
		return API_RETURN_SUCCEED;
	}

	function _serialize($arr, $htmlon = 0) {
		if(!function_exists('xml_serialize')) {
			include_once DISCUZ_ROOT.'./uc_client/lib/xml.class.php';
		}
		return xml_serialize($arr, $htmlon);
	}

	public function gettag($get, $post) {
		$name = $get['id'];
		if(!API_GETTAG) {
			return API_RETURN_FORBIDDEN;
		}
		
		$return = array();
		return $this->_serialize($return, 1);
	}

	function updatebadwords($get, $post) {
		if(!API_UPDATEBADWORDS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updatehosts($get, $post) {
		if(!API_UPDATEHOSTS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updateclient($get, $post) {
		if(!API_UPDATECLIENT) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}

	function updatecredit($get, $post) {
		if(!API_UPDATECREDIT) {
			return API_RETURN_FORBIDDEN;
		}
		$credit = $get['credit'];
		$amount = $get['amount'];
		$uid = $get['uid'];
		return API_RETURN_SUCCEED;
	}

	function getcredit($get, $post) {
		if(!API_GETCREDIT) {
			return API_RETURN_FORBIDDEN;
		}
	}

	function getcreditsettings($get, $post) {
		if(!API_GETCREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		$credits = array();
		return $this->_serialize($credits);
	}

	function updatecreditsettings($get, $post) {
		if(!API_UPDATECREDITSETTINGS) {
			return API_RETURN_FORBIDDEN;
		}
		return API_RETURN_SUCCEED;
	}
}

function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
				return '';
			}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function _stripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = _stripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}