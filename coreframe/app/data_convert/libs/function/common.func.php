<?php

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: haochuan <haochuan6868@qq.com>
// +----------------------------------------------------------------------
/**
 * 字符串截取
 * 使用方法：strlength~255
 *
 * @param $str 字符串
 * @param $length 长度
 * @return string
 */
function strlength($str,$length) {
	$str = strip_tags($str);
	$str = str_replace('&nbsp;','',$str);
	return mb_strcut($str,0,$length);
}

/**
 * 使用新的返回id
 * 主表插入数据，返回id，插入到附属表（关系表）
 */
function get_index() {
	//该函数为空函数
}

/**
 * 转化为五指CMS用户密码，需要原加密方法为md5，没有截断和添加任何随机值
 * @param $password
 * @factor $factor 加密因子，字母数字组合
 */
function wuzhicms_password($password,$factor) {
	return md5($password.$factor);
}

/**
 * 汉子转化为拼音
 * @param $str
 * @return mixed
 */
function hz2pinyin($str) {
	$pinyin = load_class('pinyin');
	$py = $pinyin->return_py($str);
	return $py['pinyin'];
}
/**
 * 获取汉子首字母
 * @param $str
 * @return mixed
 */
function first_letter($str) {
	$pinyin = load_class('pinyin');
	$py = $pinyin->return_py($str);
	if($py['pinyin']) {
		$letter = substr($py['pinyin'],0,1);
	} else {
		$letter = '';
	}
	return $letter;
}