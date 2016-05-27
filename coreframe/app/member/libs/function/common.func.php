<?php

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------

/**
 * 
 * 判断是否是手机号码 仅验证格式是否准确， 不能验证是否真实存在
 * @param string $mobile   手机号码
 * @return boolean
 */
function is_mobile($mobile){
	return strlen($mobile) == 11 && preg_match('/^1\d{10}$/', $mobile) ? true : false;
}
/**
 * 检查用户名是否合规
 *
 * @param string $username 要检查的用户名
 * @return 	boolean
 */
function is_username($username) {
	$strlen = strlen($username);
	if($strlen < 2 || $strlen > 20){
		return false;
	} elseif (!preg_match("/^[a-z0-9\x7f-\xff][a-z0-9_\x7f-\xff]*[a-z0-9\x7f-\xff]$/i", $username)){
		return false;
	}
	return true;
}

if(!function_exists('exif_imagetype')){
	function exif_imagetype ($filename){
		if((list($width, $height, $type, $attr) = getimagesize($filename)) !== false){
			return $type;
		}
		return false;
	}
}
/**
 * 
 * post获取数据
 * @param string $url
 * @param array $data
 */
function post($url, $data = array()){
	if(function_exists('curl_init')){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}else{
		if(is_array($data) && $data){
			$content = http_build_query($data);
			$content_length = strlen($content);
		}else{
			$content = '';
			$content_length = strlen($content);
		}
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' =>
				"Content-type: application/x-www-form-urlencoded\r\n" .
					"Content-length: $content_length\r\n",
				'content' => $content
			)
		);
		return file_get_contents($url, false, stream_context_create($options));
	}
}
?>