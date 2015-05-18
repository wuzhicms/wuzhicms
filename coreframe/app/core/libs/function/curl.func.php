<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * post 请求
 * @param $url
 * @param $data
 * @param string $headers
 * @param string $cookie
 * @return bool|mixed
 */
//$headers[] = 'Content-type: application/x-www-form-urlencoded; charset=utf-8';
function post_curl($url,$data,$headers = '',$cookie = ''){
	if(!$url) return false;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko');
	curl_setopt($ch, CURLOPT_POST, 1);//启用POST提交
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置POST提交的字符串
	if($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie); //设置cookie
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

/**
 * get 请求
 * @param $url
 * @param string $headers
 * @param string $cookie
 * @return array|mixed|string
 */
function get_curl($url,$headers = '',$cookie = '') {
	if(empty($url)) return '';
	if(is_string($url)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible, MSIE 11, Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko');
		if($headers) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		if($cookie) {
			curl_setopt($ch, CURLOPT_COOKIE, $cookie); //设置cookie
		}
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	} else {
		return get_multi_curl($url);
	}
}

function get_multi_curl($nodes) {
	if(empty($nodes)) return '';
	$mh = curl_multi_init();
	$curl_array = array();
	foreach($nodes as $i => $url) {
		$curl_array[$i] = curl_init($url);
		curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($mh, $curl_array[$i]);
	}
	$running = NULL;
	do {
		usleep(10000);
		curl_multi_exec($mh,$running);
	} while($running > 0);

	$res = array();
	foreach($nodes as $i => $url) {
		$res[$i] = curl_multi_getcontent($curl_array[$i]);
	}

	foreach($nodes as $i => $url) {
		curl_multi_remove_handle($mh, $curl_array[$i]);
	}
	curl_multi_close($mh);
	return $res;
}

function get_curl_https($url) {//get https的内容
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result =  curl_exec($ch);
    curl_close ($ch);
    return $result;
}