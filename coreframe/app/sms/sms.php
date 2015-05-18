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
     * 发送短信
     */
    public function sendsms() {
        //验证 页面验证码是否正确
        //插入相关信息
        $uid = get_cookie('_uid');
        $mobile = $GLOBALS['mobile'];
        if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
            exit('201');
        }
        $checkcode = $GLOBALS['checkcode'];
        if($checkcode=='') exit('\(^o^)/~');
        load_class('session');
        if(strtolower($_SESSION['code']) != strtolower($checkcode)) exit('202');
        $_SESSION['code'] = '';
        //验证通过
        $sendsms = load_class('sms','sms');
        $code = rand(1000,9999);
        $returnstr = $sendsms->send_sms($mobile, $code, 1); //发送短信
        if($sendsms->statuscode==0) {
            $formdata = array();
            $formdata['mobile'] = $mobile;
            $formdata['uid'] = $uid;
            $formdata['posttime'] = SYS_TIME;
            $formdata['code'] = $code;
            $formdata['ip'] = get_ip();
            $this->db->insert('sms_checkcode', $formdata);
            exit('0');
        } else {
            echo $returnstr;
        }

	}
}
?>