<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 核心函数库，该函数全站调用
 */

/**
 * 生成随机字符串
 *
 * Useful for generating passwords or hashes.
 *
 * @param    string    type of random string.  basic, md5, sha1, diy
 * @param    int       number of characters
 * @return    string
 */
function random_string($type = 'basic', $len = 8, $string = '0123456789'){
	if ($type == 'basic') {
		return mt_rand();
	} elseif ($type == 'md5') {
		return md5(uniqid(mt_rand()));
	} elseif ($type == 'sha1') {
		return sha1(uniqid(mt_rand(), TRUE));
	} elseif ($type == 'diy') {
		return substr(str_shuffle(str_repeat($string, ceil($len / strlen($string)))), 0, $len);
	}
}

/**
 * 语言文件处理
 *
 * @param    string $language 标示符
 * @param    array $pars      转义的数组,二维数组 ,'key1'=>'value1','key2'=>'value2',
 * @param    string $apps     多个模块之间用半角逗号隔开，如：member,guestbook
 * @return    string        语言字符
 */
function L($language = 'empty language', $pars = array(), $apps = ''){
	static $LANG = array();
	static $LANG_APPS = array();
	static $lang = '';
	$language = str_replace(' ', '_', $language);
	$lang = get_cookie('lang') ? get_cookie('lang') : LANG;
	if (!$LANG) {
		require_once COREFRAME_ROOT . 'languages' . '/' . $lang . '/system.lang.php';
		if (file_exists(COREFRAME_ROOT . 'languages' . '/' . $lang . '/' . M . '.lang.php')) require_once COREFRAME_ROOT . 'languages' . '/' . $lang . '/' . M . '.lang.php';
	}
	if (!empty($apps)) {
		$apps = explode(',', $apps);
		foreach ($apps AS $app) {
			if (!isset($LANG_APPS[$app])) require_once COREFRAME_ROOT . 'languages' . '/' . $lang . '/' . $app . '.lang.php';
		}
	}
	if (!array_key_exists($language, $LANG)) {
		return $language;
	} else {
		$language = $LANG[$language];
		if (!empty($pars) && is_array($pars)) {
			foreach ($pars AS $_k => $_v) {
				$language = str_replace('{' . $_k . '}', $_v, $language);
			}
		}
		return $language;
	}
}

/**
 * 模板调用
 *
 * @param $m        模块名称
 * @param $template 模版名称
 * @param $style    模版风格
 * @return string
 */
function T($m = 'content', $template = 'index', $style = 'default'){
	$mb = false;
	if ($_POST['SUPPORT_MOBILE'] && is_mobile_request()) {
		$tmp = $template;
		$template = 'mobile/' . $template;
		$mb = true;
	}
	if($style=='default' && TPLID!='default') $style = TPLID;
	$cache_file = CACHE_ROOT . 'templates/' . $style . '/' . $m . '/' . $template . '.php';
	if (!file_exists($cache_file)) {
		$tpl_file = 'templates/' . $style . '/' . $m . '/' . $template . '.html';
		if (file_exists(COREFRAME_ROOT . $tpl_file)) {
			exit('Please update template cache!');
		} elseif(file_exists(CACHE_ROOT . 'templates/default/' . $m . '/' . $template . '.php')) {
			$cache_file = CACHE_ROOT . 'templates/default/' . $m . '/' . $template . '.php';
			if (AUTO_CACHE_TPL) {
				$c_template = load_class('template');
				$c_template->cache_template($m, $template, 'default');
			}
		} elseif ($mb) {
			$cache_file = CACHE_ROOT . 'templates/' . $style . '/' . $m . '/' . $tmp . '.php';
			if (!file_exists($cache_file)) {
				$tpl_file = 'templates/' . $style . '/' . $m . '/' . $tmp . '.html';
				if (file_exists(COREFRAME_ROOT . $tpl_file)) {
					exit('Please update template cache!');
				} elseif(file_exists(CACHE_ROOT . 'templates/default/' . $m . '/' . $tmp . '.php')) {
					$cache_file = CACHE_ROOT . 'templates/default/' . $m . '/' . $tmp . '.php';
				} else {
					exit('Template does not exists:' . $tpl_file);
				}
			} elseif (AUTO_CACHE_TPL) {
				$c_template = load_class('template');
				$c_template->cache_template($m, $tmp, $style);
			}
		} else {
			exit('Template does not exists:' . $tpl_file);
		}
	} elseif (AUTO_CACHE_TPL) {
		$c_template = load_class('template');
		$c_template->cache_template($m, $template, $style);
	}

	return $cache_file;
}

/**
 * 提示信息
 *
 * @param $msg            提示内容
 * @param string $gotourl 跳转地址
 * @param int $time       等待跳转时间，毫秒 1000=1秒
 * @param string $msg2    扩展提示信息
 * @param string $msg3    扩展提示信息
 */
function MSG($msg, $gotourl = '', $time = 1000, $msg2 = '', $msg3 = ''){
	if (IS_CLI || defined('CLI_DISPLAY')) {
		echo date('H:i:s', SYS_TIME) . ' Msg:' . $msg . "\r\n";
	} else {
		if(OPEN_DEBUG) $time = 10000;
		if (defined('IN_ADMIN')) {
			include COREFRAME_ROOT . 'app/core/admin/template/msg.tpl.php';
		} else {
			include T('content', 'msg', 'default');
		}
	}
	exit;
}

/**
 * 将字符串转换为数组
 *
 * @param    string $data 字符串
 * @return    array    返回数组格式，如果，data为空，则返回空数组
 */
function string2array($data){
	if ($data == '') return array();
	@eval("\$array = $data;");
	return $array;
}

/**
 * 将数组转换为字符串
 *
 * @param    array $data      数组
 * @param    bool $isformdata 如果为0，则不使用new_stripslashes处理，可选参数，默认为1
 * @return    string    返回字符串，如果，data为空，则返回空
 */
function array2string($data, $isformdata = 1){
	if ($data == '') return '';
	if ($isformdata) $data = p_stripslashes($data);
	return var_export($data, TRUE);
}


/**
 * 分页函数
 *
 * @param $num          信息总数
 * @param $current_page 当前分页
 * @param $pagesize     每页显示数
 * @param $urlrule      URL规则
 * @param $variables    url规则替换变量
 * @param $limit        显示分页数列
 * @return 分页
 */
function pages($num, $current_page, $pagesize = 20, $urlrule = '', $variables = array(), $limit = 10){
	$output = '';
	$num = intval($num);
	$pagesize = intval($pagesize);
	$maxpage = ceil($num / $pagesize);
	if ($current_page > $maxpage) $current_page = $maxpage;
	if ($urlrule != '' && isset($_GET['_variables'])) {
		$urlrule = $_GET['_variables'];
	} elseif ($urlrule == '') {
		$par = 'page={$page}';
		$url = URL();
		$pos = strpos($url, '?');
		if ($pos === FALSE) {
			$url .= '?' . $par;
		} else {
			$querystring = substr(strstr($url, '?'), 1);
			parse_str($querystring, $pars);
			$query_array = array();
			foreach ($pars as $k => $v) {
				if ($k != 'page') $query_array[$k] = $v;
			}
			$querystring = http_build_query($query_array) . '&' . $par;
			$urlrule = substr($url, 0, $pos) . '?' . $querystring;
		}
	}

	//上一页
	$pageup = max(($current_page - 1), 1);
	$output .= '<li title="按住向左方向键 向前翻页"><a href="' . _pageurl($urlrule, 1, $variables) . '">首页</a></li>';
	$output .= '<li title="总数"><a href="javascript:;">'.$num.'</a></li>';
	$output .= '<li title="按住向左方向键 向前翻页"><a href="' . _pageurl($urlrule, $pageup, $variables) . '">&lt;</a></li>';
	//第一页
	$active = '';
	if ($current_page == 1) $active = 'class="active"';
	$output .= '<li><a ' . $active . ' href="' . _pageurl($urlrule, 1, $variables) . '">1</a></li>';

	$difference = $limit + 1;
	$difference2 = ceil($limit / 2 - 1);

	$startpage = $current_page - $difference2;
	$endpage = $current_page + $difference2;
	if ($difference >= $maxpage) {
		$startpage = 2;
		$endpage = $maxpage - 1;
	} else {
		if ($startpage <= 1) {
			$endpage = $difference - 1;
			$startpage = 2;
		} elseif ($endpage >= $maxpage) {
			$startpage = $maxpage - ($difference - 2);
			$endpage = $maxpage - 1;
		}
		if ($current_page <= $difference2 + 1) $endpage += 1;
		if ($maxpage - $current_page <= $difference2) $startpage -= 1;
	}
	for ($i = $startpage; $i <= $endpage; $i++) {
		$active = '';
		if ($current_page == $i) $active = 'class="active"';
		$output .= '<li><a href="' . _pageurl($urlrule, $i, $variables) . '" ' . $active . '>' . $i . '</a></li>';
	}
	//最后一页
	if ($maxpage > 1) {
		$active = '';
		if ($current_page == $maxpage) $active = 'class="active"';
		$output .= '<li><a ' . $active . ' href="' . _pageurl($urlrule, $maxpage, $variables) . '">' . $maxpage . '</a></li>';
	}
	if(defined('IN_ADMIN')) {
		$pagelink = _pageurl($urlrule, $pageup, $variables);
		$output .= '<li> 跳转到：<input style="width: 40px;height: 29px;margin-top: 5px;" onkeydown="if(event.keyCode==13) {gotourl(\''.$pagelink.'&page=\'+this.value);return false;};"></li>';
	}
	//下一页
	$pagedown = $current_page + 1;
	if ($pagedown >= $maxpage) $pagedown = $maxpage;
	//热键
	$output .= '<input type="hidden" id="page-up" value="' . _pageurl($urlrule, $pageup, $variables) . '">';
	$output .= '<input type="hidden" id="page-next" value="' . _pageurl($urlrule, $pagedown, $variables) . '">';
	$output .= '<script>$(this).focus();</script>';

	$output .= '<li title="按住向右方向键 向后翻页"><a href="' . _pageurl($urlrule, $pagedown, $variables) . '">&gt;</a></li>';
	$output .= '<li title="按住向右方向键 向后翻页"><a href="' . _pageurl($urlrule, $maxpage, $variables) . '">末页</a></li>';
	return $output;
}

/**
 * 仅pages函数使用
 *
 * @param $urlrule 分页规则
 * @param $page    当前页
 * @param $variables
 * @return 完整的URL路径
 */
function _pageurl($urlrule, $page, $variables = array()){
	if (strpos($urlrule, '|')) {
		$urlrules = explode('|', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	$findme = array('{$page}');
	$replaceme = array($page);
	if (is_array($variables)) foreach ($variables as $k => $v) {
		$findme[] = '{$' . $k . '}';
		$replaceme[] = $v;
	}
	$url = str_replace($findme, $replaceme, $urlrule);
	return $url;
}

/**
 * 完整url链接
 *
 * @return string
 */
function URL(){
	$http_url = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	if (isset($_SERVER['HTTP_HOST'])) {
		$http_url .= $_SERVER['HTTP_HOST'];
	} else {
		$http_url .= $_SERVER["SERVER_NAME"];
	}
	if (isset($_SERVER['REQUEST_URI'])) {
		$http_url .= $_SERVER['REQUEST_URI'];
	} else {
		if (isset($_SERVER['PHP_SELF'])) {
			$http_url .= $_SERVER['PHP_SELF'];
		} else {
			$http_url .= $_SERVER['SCRIPT_NAME'];
		}
		if (isset($_SERVER['QUERY_STRING'])) {
			$http_url .= $_SERVER['QUERY_STRING'];
		} else {
			$http_url .= isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		}
	}
	return $http_url;
}

/**
 * url query string 参数去重
 *
 * @param $url url
 * @return 仅返回querystring 去重后的结果
 */
function url_unique($url){
	$string = parse_url($url, PHP_URL_QUERY);
	$string = explode('&', $string);
	$new_array = array();
	foreach ($string as $str) {
		$str2 = explode('=', $str);
		if (isset($str2[1])) {
			$new_array[$str2[0]] = $str2[1];
		} else {
			$new_array[$str2[0]] = '';
		}
	}
	return http_build_query($new_array);
}

/**
 * 分配权重
 *
 * @param array $weight 权重 例如 array('a'=>200,'b'=>300,'c'=>500)
 * @return string key 键名
 */
function weight_rand($weight = array()){
	$roll = rand(1, array_sum($weight));
	$_tmp = 0;
	$rollnum = 0;
	foreach ($weight as $k => $v) {
		$min = $_tmp;
		$_tmp += $v;
		$max = $_tmp;
		if ($roll > $min && $roll <= $max) {
			$rollnum = $k;
			break;
		}
	}
	return $rollnum;
}

/**
 * 获取客户端ip
 *
 * @return string
 */
function get_ip(){
	static $ip = null;
	if (!$ip) {
		if (isset ($_SERVER ['HTTP_X_FORWARDED_FOR']) && $_SERVER ['HTTP_X_FORWARDED_FOR'] && $_SERVER ['REMOTE_ADDR']) {
			if (strstr($_SERVER ['HTTP_X_FORWARDED_FOR'], ',')) {
				$x = explode(',', $_SERVER ['HTTP_X_FORWARDED_FOR']);
				$_SERVER ['HTTP_X_FORWARDED_FOR'] = trim(end($x));
			}
			if (preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
			}
		} elseif (isset ($_SERVER ['HTTP_CLIENT_IP']) && $_SERVER ['HTTP_CLIENT_IP'] && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER ['HTTP_CLIENT_IP'];
		}
		if (!$ip && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['REMOTE_ADDR'])) {
			$ip = $_SERVER ['REMOTE_ADDR'];
		}
		!$ip && $ip = 'Unknown';
	}
	return $ip;
}

/**
 * 写入缓存
 * @param $filename 文件名
 * @param $data 数组或者字符串
 * @param string $dir 写入目录名，文件缓存写入：/caches/$dir
 * @return bool
 */
function set_cache($filename, $data, $dir = '_cache_'){
	static $_dirs;
	if ($dir == '') return FALSE;
	if (!preg_match('/([a-z0-9_]+)/i', $filename)) return FALSE;
	$cache_path = CACHE_ROOT . $dir . '/';
	if (!isset($_dirs[$filename . $dir])) {
		if (!is_dir($cache_path)) {
			mkdir($cache_path, 0777, true);
		}
		$_dirs[$filename . $dir] = 1;
	}

	$filename = $cache_path . $filename . '.' . CACHE_EXT . '.php';
	if (is_array($data)) {
		$data = '<?php' . "\r\n return " . array2string($data) . '?>';
	}
	file_put_contents($filename, $data);
}

/**
 * 获取缓存内容
 * @param $filename 文件名
 * @param string $dir 读取目录名，文件缓存路径：/caches/$dir
 * @return mixed|string
 */
function get_cache($filename, $dir = '_cache_'){
	$file = get_cache_path($filename, $dir);
	if (!file_exists($file)) return '';
	$data = include $file;
	return $data;
}

/**
 * 获取缓存路径
 * @param $filename 文件名
 * @param string $dir 读取目录名，文件缓存路径：/caches/$dir
 * @return string
 */
function get_cache_path($filename, $dir = '_cache_'){
	$cache_path = CACHE_ROOT . $dir . '/' . $filename . '.' . CACHE_EXT . '.php';
	return $cache_path;
}

/**
 * 循环删除目录下的所有文件
 * @param string $dir
 */
function delete_dirfile($dir)
{
	if ( $handle = opendir($dir) ) {
		while ( false !== ( $item = readdir( $handle ) ) ) {
			if ( $item != "." && $item != ".." ) {
				if ( is_dir( "$dir/$item" ) ) {
					delete_dirfile( "$dir/$item" );
				} else {
					unlink( "$dir/$item" );
				}
			}
		}
		closedir( $handle );
	}
}
/**
 * 检查str是否存在于strs
 *
 * @param $str
 * @param $strs
 * @param $pars
 */
function value_exists($str, $strs = '', $pars = ','){
	if (empty($strs)) return FALSE;
	$strs = explode($pars, $strs);
	return is_array($str) ? array_intersect($str, $strs) : in_array($str, $strs);
}

/**
 * 检查数组中的变量是否被定义
 * @param $array    数组
 * @param $variable 变量
 */
function output($array = '', $variable = ''){
	if (empty($array) || empty($variable)) return '';
	return isset($array[$variable]) ? $array[$variable] : '';
}

/**
 * 移除xss代码
 * @param $val 要过滤的字符
 */
function remove_xss($val){
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
	$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

	// straight replacements, the user should never need these since they're normal characters
	// this prevents like <IMG SRC=@avascript:alert('XSS')>
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for ($i = 0; $i < strlen($search); $i++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

		// @ @ search for the hex values
		$val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
		// @ @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
	}

	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);

	$found = true; // keep replacing as long as the previous round replaced something
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
}

/**
 * 将多维数组转化为 key＝>value格式
 * @param $array 多维数组，一般为$db->get_list 结果集
 * @param $key 主键
 * @param $value 值
 * @return array|string
 */
function key_value($array, $key, $value){
	if (empty($array)) return '';
	$arr = array();
	foreach ($array AS $_value) {
		$arr[$_value[$key]] = $_value[$value];
	}
	return $arr;
}

/**
 * 过滤SQL关键字，mysql入库字段过滤
 * @param $val 要过滤的字符串
 * @return mixed
 */
function sql_replace($val){
	$val = str_replace("\t", '', $val);
	$val = str_replace("%20", '', $val);
	$val = str_replace("%27", '', $val);
	$val = str_replace("*", '', $val);
	$val = str_replace("'", '', $val);
	$val = str_replace("\"", '', $val);
	$val = str_replace("/", '', $val);
	$val = str_replace(";", '', $val);
	$val = str_replace("#", '', $val);
	$val = str_replace("--", '', $val);
	$val = addslashes($val);
	return $val;
}

/**
 * 字符串截取
 * @param $string 字符串
 * @param $length 长度
 * @param string $dot 截断后，后面追加的字符，例如：...
 * @param int $rephtml
 * @return mixed|string
 */

function strcut($str, $width = 0, $end = '...', $rephtml = 0) {
	if ($width <= 0 || $width >= strlen($str)) {
		return $str;
	}
	$arr = str_split($str);
	$len = count($arr);
	$w = 0;
	$width *= 10;

	// 不同字节编码字符宽度系数
	$x1 = 11;   // ASCII
	$x2 = 16;
	$x3 = 21;
	$x4 = $x3;
	$e = '';
	for ($i = 0; $i < $len; $i++) {
		if ($w >= $width) {
			$e = $end;
			break;
		}
		$c = ord($arr[$i]);
		if ($c <= 127) {
			$w += $x1;
		}
		elseif ($c >= 192 && $c <= 223) { // 2字节头
			$w += $x2;
			$i += 1;
		}
		elseif ($c >= 224 && $c <= 239) { // 3字节头
			$w += $x3;
			$i += 2;
		}
		elseif ($c >= 240 && $c <= 247) { // 4字节头
			$w += $x4;
			$i += 3;
		}
	}

	return implode('', array_slice($arr, 0, $i) ). $e;
}

/**
 * 获取模块配置或相关根据keyid组合的配置信息
 * @param $m 模块
 * @param string $keyid 主键名称
 * @return string
 */
function module_setting($m, $keyid = ''){
	static $_MODULES = array();
	if (!isset($_MODULES[$m])) {
		$db = load_class('db');
		$_MODULES[$m] = $db->get_list('setting', array('m' => $m));
	}
	if ($keyid) {
		return isset($_MODULES[$m][$keyid]) ? $_MODULES[$m][$keyid] : '';
	} else {
		return $_MODULES[$m];
	}
}

/**
 * 格式化时间
 * @param $timestamp 时间戳
 * @param int $type 输出类型，0 Y-m-d H:i:s ；1 Y-m-d H:i ；2 Y-m-d
 * @return bool|string
 */
function time_format($timestamp, $type = 0){
	if ($timestamp == 0) return '';
	$types = array('Y-m-d H:i:s', 'Y-m-d H:i', 'Y-m-d');
	$difftime = SYS_TIME - $timestamp;
	if ($difftime < 5400) {
		$difftime = ceil($difftime / 60);
		return $difftime . '分钟前';
	} else {
		return date($types[$type], $timestamp);
	}
}

/**
 * 后台url构造
 *
 * @param $array
 * @return string
 */
function link_url($array){
	$array['m'] = isset($array['m']) ? $array['m'] : M;
	$array['f'] = isset($array['f']) ? $array['f'] : F;
	$array['v'] = isset($array['v']) ? $array['v'] : V;
	$array['_su'] = isset($array['_su']) ? $array['_su'] : _SU;
	$array['_menuid'] = isset($GLOBALS['_menuid']) ? intval($GLOBALS['_menuid']) : '';
	$array['_submenuid'] = isset($GLOBALS['_submenuid']) ? intval($GLOBALS['_submenuid']) : '';
	$array = array_filter($array);
	return '?' . http_build_query($array);
}

/**
 * 联动菜单输出
 * @param $linkageid
 * @param $id
 */
function linkage($linkageid, $name, $returnid = 1, $extjs = '',$values = array(),$level = ''){
	$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
	$config = @get_cache('config_' . $linkageid, 'linkage');
	if (!$config) {
		$db = load_class('db');
		$config = $db->get_one('linkage', array('linkageid' => $linkageid));
		set_cache('config_' . $linkageid, $config, 'linkage');
	}

	if ($config['display_type'] == 1) {
		//select 选项框
		if($values[1]=='') $values[1] = 0;
		$level = $level=='' ? $config['level'] : $level;
		$str = '';
		$str .= '<div id="wz_' . $id . '">';
		$str .= '<input type="hidden" id="' . $id . '" name="' . $name . '" value="0">';
		for ($i = 1; $i <= $level; $i++) {
			if($i>1 && $i==$level) $extjs = '';
			$str .= '<div class="col-sm-4"><select class="LK' . $linkageid . '_' . $i . ' form-control" name="LK' . $linkageid . '_' . $i . '" id="LK' . $linkageid . '_' . $i . '" onchange="linkage(\'' . $id . '\',this.value,this)" ' . $extjs . ' data-value="'.$values[$i].'"></select></div>';
		}
		$str .= '</div>';
		$str .= '<script src="' . R . 'js/jquery.wuzhicms-select.js"></script>';
		$str .= "\r\n" . '<script>';
		$str .= "\r\n" . '$.wuzhicmsSelect.defaults.url = "' . WEBURL . 'index.php?m=linkage&f=json&returnid=' . $returnid . '&linkageid=' . $linkageid . '/wz.json";';
		//$str .= "\r\n" . '$.wuzhicmsSelect.defaults.url = "/res/js/linkage/' . $linkageid . '.json";';
		$str .= "\r\n" . '$("#wz_' . $id . '").wuzhicmsSelect({';
		$str .= "\r\n" . 'selects : [';
		for ($i = 1; $i <= $level; $i++) {
			$di = $i == $level ? '' : ',';
			$str .= '"LK' . $linkageid . '_' . $i . '"' . $di;
		}
		$str .= ']';
		$str .= "\r\n" . '});';
		$str .= "\r\n" . '</script>';
		return $str;
	} elseif ($config['display_type'] == 3) {
		//列表下拉
	}
}

/**
 * 获取文件扩展
 * @param $filename
 * @return string
 */
function get_ext($filename){
	return strtolower(substr(strrchr($filename, "."), 1));
}

/**
 * html字符串格式化（用于打印显示，替换掉html中的特殊字符）
 * @param string & $sHtml 需要处理的html
 * @return string
 * */
function safe_htm($sHtml){
	if (empty($sHtml)) return '';
	static $maEntities = array('&' => '&amp;', '<' => '&lt;', '>' => '&gt;', '\'' => '&apos;', '"' => '&quot;', "\n" => '<br />', ' ' => '&nbsp;');
	return strtr($sHtml, $maEntities);
}

/**
 * @param $code 检查验证码是否正确
 */
function checkcode($code){
	load_class('session');
	if (strtolower($_SESSION['code']) != strtolower($code)) MSG('验证码不正确');
	$_SESSION['code'] = '';
}

/**
 * 自定义路由
 *
 * @param $id
 * @return string
 */
function at($id){
	$url = WEBURL . 'web.php?at=' . $id;
	return $url;
}

/**
 * 判断字符串编码是否为utf8
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param string
 * @return bool true表示为utf8
 */
function is_utf8($word){
	if (preg_match("/^([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}$/", $word) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){2,}/", $word) == true) {
		return true;
	} else {
		return false;
	}
}

/**
 * 编码转换
 * @param array          /string $data       数组
 * @param string $input  需要转换的编码
 * @param string $output 转换后的编码
 */
function array_iconv($input = 'gbk', $output = 'utf-8', $data = ''){
	if (!is_array($data)) {
		return (is_utf8($data) && $output == 'utf-8') || (!is_utf8($data) && $output == 'gbk') ? $data : iconv($input, $output, $data);
	} else {
		foreach ($data as $key => $val) {
			if (is_array($val)) {
				$data[$key] = array_iconv($input, $output, $val);
			} else {
				$data[$key] = (is_utf8($val) && $output == 'utf-8') || (!is_utf8($val) && $output == 'gbk') ? $val : iconv($input, $output, $val);
			}
		}
		return $data;
	}
}

/**
 * 转换字节数为其他单位
 *
 * @param    string $filesize 字节大小
 * @return    string    返回大小
 */
function sizecount($filesize){
	if ($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif ($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif ($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

/**
 * 是否为移动设备
 * @return bool|int|string
 */
function is_mobile_request(){
	static $mobile_status;
	if (isset($mobile_status)) {
		return $mobile_status;
	}
	$_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
	$mobile_browser = '0';
	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) $mobile_browser++;
	if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) $mobile_browser++;
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) $mobile_browser++;
	if (isset($_SERVER['HTTP_PROFILE'])) $mobile_browser++;
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents = array('w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno', 'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-', 'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar', 'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp', 'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-');
	if (in_array($mobile_ua, $mobile_agents)) $mobile_browser++;
	if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) $mobile_browser++;
	// Pre-final check to reset everything if the user is on Windows
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false) $mobile_browser = 0;
	// But WP7 is also Windows, with a slightly different characteristic
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) $mobile_browser++;
	$mobile_status = $mobile_browser;
	if ($mobile_browser > 0) return true; else
		return false;
}

/**
 * 模块设置保存进数据库的逻辑处理
 *
 * @author tuzwu
 * @param array $data 一维数组
 * @return array $data
 */
function cache_in_db($data, $keyid, $m){
	if (empty($keyid) || empty($m)) return false;
	$where = array('keyid' => $keyid, 'm' => $m);
	$db = load_class('db');
	$r = $db->get_one('setting', $where);

	if (empty($data)) return unserialize($r['data']);
	$insert_data = array('data' => serialize($data), 'updatetime' => SYS_TIME);
	if (empty($r)) {
		$db->insert('setting', array_merge($insert_data, $where));
	} else {
		$db->update('setting', $insert_data, $where);
	}
	return $data ? $data : unserialize($r['data']);
}

/**
 * 查找数组中是否存在某项，并返回指定的字符串，可用于检查复选，单选等
 *
 * @param $id
 * @param $ids
 * @param string $returnstr
 * @return string
 */
function check_in($id, $ids, $returnstr = 'checked'){
	if (in_array($id, $ids)) return $returnstr;
}

/**
 * 获取子栏目
 *
 * @param $cid
 * @param string $categorys
 * @return string
 */
function sub_categorys($cid, $categorys = ''){
	if (empty($categorys)) {
		$categorys = get_cache('category', 'content');
	}
	$tmp = '';
	foreach ($categorys as $id => $cat) {
		if ($cat['pid'] == $cid) $tmp[$id] = $cat;
	}
	return $tmp;
}

/**
 * 自定义SQL组装
 *
 * @param $table
 * @param string $where
 * @param int $type
 * @param string $order
 * @param int $limit
 * @param int $start
 * @return mixed
 */
function wzsql($table, $where = '', $type = 1, $order = '', $limit = 10, $start = 0){
	$db = load_class('db');
	if ($type == 1) {//返回统计
		return $db->count_result($table, $where);
	} elseif ($type == 2) {//返回单条结果
		return $db->get_one($table, $where);
	} elseif ($type == 3) {//返回多条结果
		return $db->get_list($table, $where, '*', $start, $limit, 0, $order);
	}
}

/**
 * 自定义SQL查询
 *
 * @param $sql
 * @return array
 */
function sql($sql){
	$pre = substr($sql, 0, 6);
	if (strtolower($pre) != 'select') return array();
	$db = load_class('db');
	$query = $db->query($sql);
	while ($r = $db->fetch_array($query)) {
		$result[] = $r;
	}
	return $result;
}

/**
 * 将字符串通过explode分割后，返回指定值
 * 例如：explode2array('154-30',0); 返回  154
 * @param $string
 * @param $key
 * @param string $delimiter
 * @return string
 */
function explode2array($string, $key, $delimiter = '-'){
	if (empty($string)) return '';
	$arr = explode($delimiter, $string);
	return $arr[$key];
}

/**
 * 格式化文本域内容
 *
 * @param $string 文本域内容
 * @return string
 */
function format_textarea($string){
	$string = nl2br(str_replace(' ', '&nbsp;', $string));
	return $string;
}

/**
 * 图片裁剪
 *
 * @param $imageurl 图片路径
 * @param $width 宽度
 * @param $height 高度
 * @param int $flag 裁剪规则,一般而言,允许截图则用4,不允许截图则用1;  假设要求一个为4:3比例的图像,则:4=如果太长则自动刪除一部分 0=长宽转换成参数指定的 1=按比例缩放,自动判断太长还是太宽,长宽约束在参数指定内 2=以宽为约束缩放 3=以高为约束缩放
 * @param string $bgcolor 如果不为null,则用这个参数指定的颜色作为背景色,并且图像扩充到指定高宽,该参数应该是一个数组;
 * @return string 新图片路径
 */
function imagecut($imageurl, $width, $height, $flag = 0, $bgcolor = ''){

	if ($imageurl == '') return '';
	if (strpos($imageurl, ATTACHMENT_URL) === false) return $imageurl;
	$attach_long = strlen(ATTACHMENT_URL);
	$tmpimageurl = substr($imageurl, $attach_long);
	$newimage = dirname($tmpimageurl) . '/img_' . $width . '_' . $height . '_' . basename($tmpimageurl);

	if (file_exists(ATTACHMENT_ROOT . $newimage)) return ATTACHMENT_URL . $newimage;
	if (!file_exists(str_replace(ATTACHMENT_URL, ATTACHMENT_ROOT, $imageurl))) return $imageurl;
	$image = load_class('image');
	if ($image->set_image(ATTACHMENT_ROOT . $tmpimageurl) === false) return R . 'images/nopic.jpg';
	$image->createImageFromFile();
	if ($bgcolor) {
		$bgcolor = explode(',', $bgcolor);
	}
	$image->resizeImage($width, $height, $flag, $bgcolor);
	$image->save(1, ATTACHMENT_ROOT, $newimage);
	return ATTACHMENT_URL . $newimage;
}

/**
 * 二维码
 *
 * @param $str 二维码内容
 * @return string 显示地址
 */
function qrcode($str){
	$str = urlencode($str);
	return WEBURL . 'api/qrcode.php?str=' . $str;
}

/**
 * 广告调用
 *
 * @param $pid
 * @param int $id
 * @return string
 */
function promote($pid, $id = 0, $siteid = 1){
	$place = get_cache('place', 'promote');
	$ads = get_cache('place_' . $pid, 'promote');
	$data = array();
	if ($id) {
		foreach ($ads as $ad) {
			if ($ad['id'] == $id) {
				$data = $ad;
				break;
			}
		}
	} elseif (!empty($ads)) {
		foreach ($ads as $ad) {
			if ($siteid == $ad['siteid']) {
				$data = $ad;
				break;
			}
		}
	}
	if (empty($data)) return '';
	$width = $place[$pid]['width'] ? $place[$pid]['width'] . 'px' : 'auto';
	$height = $place[$pid]['height'] ? $place[$pid]['height'] . 'px' : 'auto';
	@extract($data, EXTR_SKIP);
	include T('promote', $data['template']);
}

/**
 * url转义
 * @param $url
 * @return mixed
 */
function p_urlencode($url){
	static $search = array('%21', '%2A', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
	static $replace = array('!', '*', ';', ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
	return str_replace($search, $replace, urlencode($url));
}

/**
 * 转义特殊字符串
 * @param $string
 * @param null $flags
 * @return array|mixed|string
 */
function p_htmlspecialchars($string, $flags = null){
	if (is_array($string)) {
		foreach ($string as $key => $val) {
			$string[$key] = p_htmlspecialchars($val, $flags);
		}
	} else {
		if ($flags === null) {
			$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
			if (strpos($string, '&amp;#') !== false) {
				$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
			}
		} else {
			if (version_compare(PHP_VERSION, '5.4.0', '<')) {
				$string = htmlspecialchars($string, $flags);
			} else {
				if (strtolower(CHARSET) == 'utf-8') {
					$charset = 'UTF-8';
				} else {
					$charset = 'ISO-8859-1';
				}
				$string = htmlspecialchars($string, $flags, $charset);
			}
		}
	}
	return $string;
}

/**
 * Convert special HTML entities back to characters
 *
 * @param $string
 * @return string
 */
function p_html_entity_decode($string){
	$encoding = 'utf-8';
	if (strtolower(CHARSET) == 'gbk') $encoding = 'ISO-8859-1';
	return html_entity_decode($string, ENT_QUOTES, $encoding);
}

/**
 * Convert all HTML entities to their applicable characters
 *
 * @param $string
 * @return string
 */
function p_htmlentities($string){
	$encoding = 'utf-8';
	if (strtolower(CHARSET) == 'gbk') {
		return safe_htm($string);
	} else {
		return htmlentities($string, ENT_QUOTES, $encoding);
	}
}

/**
 * 计算字符串长度
 *
 * @param $str
 * @return int
 */
function p_strlen($str){
	if (strtolower(CHARSET) != 'utf-8') {
		return strlen($str);
	}
	$count = 0;
	for ($i = 0; $i < strlen($str); $i++) {
		$value = ord($str[$i]);
		if ($value > 127) {
			$count++;
			if ($value >= 192 && $value <= 223) $i++; elseif ($value >= 224 && $value <= 239) $i = $i + 2;
			elseif ($value >= 240 && $value <= 247) $i = $i + 3;
		}
		$count++;
	}
	return $count;
}
/**
 * 获取头像
 * @param int $uid 用户id
 * @param $size 30|45|90|180 default 30
 */
function avatar($uid, $size=30,$sex = 0){
	$uid = (int)$uid;
	if($uid){
		$size = intval($size);
		$file = 'uploadfile/member/'.substr(md5($uid), 0, 2).'/'.$uid.'/'.$size.'x'.$size.'.jpg';
		if(file_exists(WWW_ROOT.$file)){
			return WEBURL.$file;
		}
	}
	if($sex==1) {
		return R.'images/icon/man.png';
	} elseif($sex==2) {
		return R.'images/icon/girl.png';
	} else {
		return R.'images/userface.png';
	}
}

/**
 * 获取栏目链接
 * @param $cid 栏目ID
 * @param $m 模块名称
 */
function caturl($cid,$m = 'content') {
	static $categorys;
    if(empty($categorys[$m])) {
        $categorys[$m] = get_cache('category',$m);
    }
	return $categorys[$m][$cid]['url'];
}
/**
 * 后台快捷管理
 * @param $url
 */
function adminurl($url,$str = '',$extstr = '') {
	static $_PRI;
	$uid = get_cookie('_uid');
	if(!$uid) return '';
	$url .= '&_lang='.LANGUAGE;
	$token = md5($url.$uid);
	$newurl = WEBURL.'index.php?m=member&f=adminurl&token='.$token.'&forward='.urlencode($url);
	if($str) {
		parse_str(trim($url,'?'));
		$keyid = substr(md5($m.$f.$v.$cid.$actionid),0,16);
		if(!isset($_PRI[$keyid])) {
			$db = load_class('db');
			$r = $db->get_one('category_private', array('cid' => $cid,'actionid'=>$actionid));
			if(!$r) return '';
		}

		$newurl = str_replace('=""','="'.$newurl.'"',$str);
		$_PRI[$keyid] = 1;
		return $newurl;
	} else {
		return $newurl;
	}
}
/**
 * url 组装
 */
function filterurl($_type,$_field,$_value) {
	$filterurl_config = get_config('filterurl_config');
	$field_array = $filterurl_config[$_type]['field'];
	$urlrule = $filterurl_config[$_type]['urlrule'];
	$page = $GLOBALS['page'];
	$variables = array();
	foreach($field_array as $field) {
		if($field=='city') {
			$variables['city'] = $GLOBALS['city'];
		} else {
			$variables[$field] = isset($GLOBALS[$field]) ? intval($GLOBALS[$field]) : 0;
		}
	}
	$variables[$_field] = $_value;
	//$_GET['variables'] = $variables;
	return _pageurl($urlrule, $page, $variables);
}

/**
 *  中文分词
 * @param $data
 * @return array
 */
function segment($data) {
	if(!get_extension_funcs('scws')) return '';
	if($data=='') return array();
	$cws = scws_new();
	$cws->set_charset('utf8');
	$cws->set_duality(1);
	$cws->set_ignore(1);
	$cws->set_multi(1);
	$cws->send_text($data);
	$showa = 0;
	while ($res = $cws->get_result()) {
		$words = array();
		foreach ($res as $tmp) {
			if ($tmp['len'] == 1 && $tmp['word'] == "\r") {
				continue;
			}
			if ($tmp['len'] == 1 && $tmp['word'] == "\n") {
				$words[] = $tmp['word'];
			} else if ($showa) {
				// printf("%s/%s ", $tmp['word'], $tmp['attr']);
			} else {
				$words[] = $tmp['word'];
			}
		}
		flush();
	}
	return $words;
}

/**
 * 提交链接到百度
 * @param $urls 链接地址，数组 array('url1','url2')
 * @param $siteid 站点id
 * @param $action 操作方法，推送数据：urls，更新数据：update，删除数据：del
 */
function baidu_linkpost($urls,$siteid = 1,$action = 'urls') {
	static $baidu_api;
	if(empty($baidu_api)) {
		$baidu_api['sitelist'] = get_cache('sitelist');
		foreach ($baidu_api['sitelist'] as $sid=>$r) {
			$baidu_api['urls'][$sid] = 'http://data.zz.baidu.com/urls?site='.$r['baidu_site'].'&token='.$r['baidu_token'];
			$baidu_api['update'][$sid] = 'http://data.zz.baidu.com/update?site='.$r['baidu_site'].'&token='.$r['baidu_token'];
			$baidu_api['del'][$sid] = 'http://data.zz.baidu.com/del?site='.$r['baidu_site'].'&token='.$r['baidu_token'];
		}
	}
	if($baidu_api['sitelist'][$siteid]['baidu_site']=='') {
		return true;
	}

	$baidu_urls = array();
	foreach($urls as $url) {
		if(strpos($url,'://')===false) {
			$url = $baidu_api['sitelist'][$siteid]['url'].ltrim($url,'/');
		}
		$baidu_urls[] = $url;
	}
	$baidu_urls = implode("\n", $baidu_urls);

	$ch = curl_init();
	$options =  array(
		CURLOPT_URL => $baidu_api[$action][$siteid],
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POSTFIELDS => $baidu_urls,
		CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	curl_exec($ch);
	curl_close($ch);
}

?>