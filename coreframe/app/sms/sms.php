<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 发送短信验证码
 */
class sms{
	public function __construct() {
		$this->db = load_class('db');
	}

	/**
	 * 发送短信(手机短信验证码、图片验证码)
	 */
	public function sendsms() {
		//验证 页面验证码是否正确
		//插入相关信息
		/**
		1、使用安全图片验证码（网站）
		2、单IP的请求次数限定 （网站）（APP）
		3、单用户动态短信请求间隔时长限制（网站）（APP）
		4、  同一手机号次数限定 （网站）（APP）
		 */
		$config = get_cache('sms_config','sms');
		$uid = get_cookie('_uid');
		$mobile = $GLOBALS['mobile'];
		if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|1|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
			exit('201');
		}
		$checkcode = $GLOBALS['checkcode'];
		if($checkcode=='') exit('202');
		load_class('session');
		if(strtolower($_SESSION['code']) != strtolower($checkcode)) exit('202');
		$_SESSION['code'] = '';

		$endtime = SYS_TIME-120;

		if($_SESSION['et'] && $_SESSION['et']>$endtime) {
			if($config['sms_uid']!='test') {
				exit('204');
			}
		} else {
			$_SESSION['et'] = SYS_TIME;
		}
		if(isset($GLOBALS['isreg']) && $GLOBALS['isreg']) {//是否为注册，验证手机是否已注册
			$reg_data = $this->db->get_one('member', array('mobile' => $mobile),'uid');
			if($reg_data) {
				exit('206');
			}
		}
		$posttime = SYS_TIME-86400;
		$ip = get_ip();
		$where = "`ip`='$ip' AND `posttime`>$posttime";
		$num = $this->db->count_result('sms_checkcode',$where);
		if($num>200 && $config['sms_uid']!='test') {//单IP 24小时内最大请求次数限定
			exit('203');
		}

		//单用户动态短信请求间隔时长限制 ,根据手机号码判断是否为一个用户
		$where = "`mobile`='$mobile'";
		$r = $this->db->get_one('sms_checkcode',$where, '*', 0,'id DESC' );

		if($r['posttime']>$endtime && $config['sms_uid']!='test') {//120 秒之内连续请求
			exit('204');
		}


		//同一手机号次数限定
		$where = "`mobile`='$mobile' AND `posttime`>=$posttime";
		$num = $this->db->count_result('sms_checkcode',$where);
		if($num>200 && $config['sms_uid']!='test') {//同一手机号次数限定 24小时内最大请求次数限定
			exit('205');
		}
//验证通过

		$sendsms = load_class('sms','sms');
		if($config['sms_uid']!='test') {
			$code = rand(1000,9999);
		} else {
			$code = 1111;
		}

		$formdata = array();
		$formdata['mobile'] = $mobile;
		$formdata['uid'] = $uid;
		$formdata['posttime'] = SYS_TIME;
		$formdata['code'] = $code;
		$formdata['ip'] = $ip;
		$this->db->insert('sms_checkcode', $formdata);
		if($config['sms_uid']!='test') {
			$returnstr = $sendsms->send_sms($mobile, $code, 1); //发送短信
			if($sendsms->statuscode==0) {
				exit('0');
			} else {
				echo $returnstr;
			}
		} else {
			exit('0');
		}
	}
}
?>