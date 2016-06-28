<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class callback {
   	function __construct() {
		$this->db = load_class('db');
	}

    /**
     * 异步通知
     */
    public function async_notify(){
        $payment = isset($GLOBALS['payment']) ? intval($GLOBALS['payment']) : exit('payment error');
        $pay_r = $this->db->get_one('payment',array('id'=>$payment,'status'=>1));
        if(!$pay_r) exit('payment error');
        $setting = unserialize($pay_r['setting']);
        $_pay = load_class($pay_r['classname'].'_callback','pay',$setting);
        $verify_result = $_pay->verify();
        $return_text = $_pay->response_status($verify_result);
        $status = $_pay->status;
        $order_no = $_pay->response_order_no;
        $buyer_email = strip_tags($GLOBALS['buyer_email']);

        $this->db->update('pay',array('status'=>$status,'email'=>$buyer_email),array('order_no'=>$order_no));
        if($status==1 || $status==7) {
            if(isset($GLOBALS['module']) && !empty($GLOBALS['module'])) {
                $callapi = load_class($GLOBALS['file'],$GLOBALS['module']);
                $callapi->update($order_no);
            } else {
                $pay_res = $this->db->get_one('pay',array('order_no'=>$order_no));
                if($pay_res['memberpay']==0) {
                    $this->db->update('pay', array('memberpay'=>1), array('id' => $pay_res['id']));
                    $this->db->update('member', "`money`=(`money`+".$pay_res['money'].")", array('uid' => $pay_res['uid']));

                }
            }
        }
        echo $return_text;
    }
    /**
     * 同步通知
     */
    public function sync_notify(){
        $payment = isset($GLOBALS['payment']) ? intval($GLOBALS['payment']) : exit('payment error');
        $pay_r = $this->db->get_one('payment',array('id'=>$payment,'status'=>1));
        if(!$pay_r) exit('payment error');
        $setting = unserialize($pay_r['setting']);
        $_pay = load_class($pay_r['classname'].'_callback','pay',$setting);
        $verify_result = $_pay->verify();

        if($verify_result==false) {
            MSG('认证失败!!!');
        }
        $return_text = $_pay->response_status($verify_result);

        $status = $_pay->status;

        $order_no = $_pay->response_order_no;
        $buyer_email = strip_tags($GLOBALS['buyer_email']);
        $this->db->update('pay',array('status'=>$status,'email'=>$buyer_email),array('order_no'=>$order_no));

        if($status==1 || $status==7) {
            $pay_res = $this->db->get_one('pay',array('order_no'=>$order_no));
            if(isset($GLOBALS['module']) && !empty($GLOBALS['module'])) {
                $callapi = load_class($GLOBALS['file'],$GLOBALS['module']);
                $callapi->update($order_no,$pay_res);
            } else {
                if($pay_res['memberpay']==0) {
                    $this->db->update('pay', array('memberpay'=>1), array('id' => $pay_res['id']));
                    $this->db->update('member', "`money`=(`money`+".$pay_res['money'].")", array('uid' => $pay_res['uid']));

                }
            }
            $pay_url = get_cookie('pay_url');
            if($pay_url) {
                MSG('支付成功！',$pay_url,3000);
            } else {
                MSG('支付成功！','index.php?m=pay&f=payment&v=listing',3000);
            }
        } else {
            MSG('支付失败！');
        }

    }
}