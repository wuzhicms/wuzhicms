<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class payment extends WUZHI_foreground{
    private $payments;
    private $status_arr;
	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();

        $this->payments_res = $this->db->get_list('payment', "id>1 AND status=1");

        $this->payments = key_value($this->payments_res,'id','name');

        $this->status_arr = array('-1' => '回收站', 1 => '交易成功', 2 => '交易失败', 3 => '交易错误', 4 => '交易超时', 5 => '交易取消', 6 => '等待用户付款', 7 => '待商家发货', 8 => '待用户确认收货', 9 => '退款成功', 10 => '交易进行中');

    }
	public function listing(){
        $seo_title = '充值记录';
		$memberinfo = $this->memberinfo;
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : -1;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $pay_config = get_config('pay_config');
        $keytype = isset($GLOBALS['keytype']) ? intval($GLOBALS['keytype']) : 0;
        $key = isset($GLOBALS['key']) ? intval($GLOBALS['key']) : -1;
        switch($status) {
            case -1:
                $where = '`status`>0';
                break;
            case -2:
                $where = '`status` IN(2,3,4,5)';
                break;

            default:
                $where = '`status`='.$status;
                break;

        }
        if($keytype)
        switch ($key) {
            case '-1':
                $where .= " AND `keytype`='$keytype'";
                break;
            
            default:
                $where .= " AND (`keytype`= 7 || `keytype`= 4 )  AND `status`=1 AND `apply_point`=0";
                break;
        }
        /**
        $rewinner = $this->db->get_list('qiangpai_winner',1,'payid,draw_method', 0, 20,$page,'winnerid DESC');
        $rew = array();
        foreach ($rewinner as $k => $v) {
            
            $rew[]=$v['payid'];
            // echo $v;exit;
        }
        // print_r($rew);
        // exit;
        $result = $this->db->get_list('pay', "`uid`='".$memberinfo['uid']."' AND $where", '*', 0, 2000,$page,'id DESC');
        foreach ($result as $key => $value) {
            $rewinner = $this->db->get_list('qiangpai_winner',"`payid`=".$value['id'],'payid,draw_method', 0, 20,$page,'winnerid DESC');
            
            $result[$key]['draw_method'] =$rewinner[0]['draw_method'];

            $resqp = $this->db->get_list('qiangpai',"`id`=".$value['original_id'],'id,endtime,cron_status', 0, 20,$page,'id DESC');
            
            $result[$key]['rendtime'] = $resqp[0]['endtime'];
            $result[$key]['cron_status'] = $resqp[0]['cron_status'];
            // echo "<pre>";
            // print_r($result);

        }
         * **/
        // exit;
        $pages = $this->db->pages;
        $total = $this->db->number;
		include T('pay','listing');
	}
    public function pay(){
        $seo_title = '在线充值';
        $memberinfo = $this->memberinfo;
        $payments_res = $this->payments_res;

        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('pay', "`uid`='".$memberinfo['uid']."' AND status>0", '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $price = isset($GLOBALS['price']) ? sprintf("%.2f",substr(sprintf("%.3f", $GLOBALS['price']), 0, -2)) : 0;
        include T('pay','pay');
    }
    public function pay_recharge() {
        //checkcode($GLOBALS['checkcode']);
        $payment = isset($GLOBALS['payment']) ? intval($GLOBALS['payment']) : MSG('支付方式错误');
        if($payment==1) MSG('支付方式错误');
        $pay_r = $this->db->get_one('payment',array('id'=>$payment,'status'=>1));
        if(!$pay_r) MSG('支付方式错误');
        $price = isset($GLOBALS['form']['price']) ? sprintf("%.2f",$GLOBALS['form']['price']) : MSG('金额错误');
        if($price<=0) MSG('金额错误');
        load_function('common','pay');
        load_function('preg_check');
        $memberinfo = $this->memberinfo;

        $formdata = array();
        $formdata['email'] = is_email($GLOBALS['form']['email']) ? $GLOBALS['form']['email'] : MSG('邮箱错误');
        $formdata['username'] = $memberinfo['username'];
        $formdata['uid'] = $memberinfo['uid'];
        $formdata['money'] = $price;

        $formdata['order_no'] = create_order_no();
        $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);

        $formdata['plus_minus'] = -1;
        $formdata['addtime'] = SYS_TIME;
        $formdata['quantity'] = 1;
        $formdata['status'] = 6;
        $formdata['payment'] = $payment;
        $formdata['keytype'] = 1;

        $formdata['payname'] = $memberinfo['username'].'在线充值';


        $id = $this->db->insert('pay',$formdata);

        $setting = unserialize($pay_r['setting']);

        $_pay = load_class($pay_r['classname'],'pay',$setting);

        $parameter = array(
            "service_type"	=> $setting['service_type'],
            "payment_type"	=> 1,//支付类型
            "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment='.$payment,//同步通知地址
            "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment='.$payment,//同步通知地址
            "email"	=> $formdata['email'],
            "order_no"	=> $formdata['order_no'],
            "payname"	=> $formdata['payname'],
            "total_fee"	=> $formdata['money'],
            "remark"	=> $formdata['remark'],
            "url"	=> WEBURL
        );

        $html_text = $_pay->build_form($parameter,"get", "正在跳转至支付平台...");
        echo $html_text;

        //include T('pay','pay_recharge');
    }

    /**
     * 重新付款
     */
    public function repay() {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG('支付id错误');
        $memberinfo = $this->memberinfo;
        $r = $this->db->get_one('pay',array('id'=>$id,'uid'=>$memberinfo['uid']));
        if(!$r) MSG('支付id错误');
        if($r['status']!=6) MSG('订单状态为：'.$this->status_arr[$r['status']]);
        $payment = $r['payment'];
        if($payment==1) MSG('支付方式错误');
        $pay_r = $this->db->get_one('payment',array('id'=>$payment,'status'=>1));
        if(!$pay_r) MSG('支付方式错误');

        load_function('common','pay');
        load_function('preg_check');
        $setting = unserialize($pay_r['setting']);

        $_pay = load_class($pay_r['classname'],'pay',$setting);
        if($pay_r['type']==1) {
            if($r['keytype']==1) {
                $parameter = array(
                    "service_type"	=> $setting['service_type'],
                    "payment_type"	=> 1,//支付类型
                    "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment='.$payment,//同步通知地址
                    "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment='.$payment,//同步通知地址
                    "email"	=> $r['email'],
                    "order_no"	=> $r['order_no'],
                    "payname"	=> $r['payname'],
                    "total_fee"	=> $r['money'],
                    "remark"	=> $r['remark'],
                    "url"	=> WEBURL
                );
            } else {
                if($r['keytype']==4) {
                    $typename = 'tuangou';
                } elseif($r['keytype']==5) {
                    $typename = 'heighendtourism';
                } elseif($r['keytype']==6) {
                    $typename = 'tour';
                } elseif($r['keytype']==7) {
                    $typename = 'car';
                } elseif($r['keytype']==8) {
                    $typename = 'qiangpai';
                }
                $parameter = array(
                    "service_type"	=> $setting['service_type'],
                    "payment_type"	=> 1,//支付类型
                    "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment=2&module=order&file='.$typename.'_callback',//同步通知地址
                    "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment=2&module=order&file='.$typename.'_callback',//同步通知地址
                    "email"	=> $r['email'],
                    "order_no"	=> $r['order_no'],
                    "payname"	=> $r['payname'],
                    "total_fee"	=> $r['money'],
                    "remark"	=> $r['remark'],
                    "url"	=> WEBURL,
                    //-------
                    "price"	=> $r['money'],
                    "quantity"	=> 1,
                    "logistics_fee"	=> '0.00',
                    "logistics_type"	=> 'EXPRESS',
                    "logistics_payment"	=> 'SELLER_PAY',
                    "receive_name"	=> '',
                    "receive_address"	=> '',
                    "receive_zip"	=> '',
                    "receive_phone"	=> '',
                    "receive_mobile"	=> $r['telephone'],
                );
            }



            $html_text = $_pay->build_form($parameter,"get", "正在跳转至支付平台...");
            echo $html_text;
        } else {
            $_pay->execute($r,$pay_r,$memberinfo);
        }

    }
    /**
     * 余额付款
     */
    public function surplus() {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG('支付id错误');
        $token = $GLOBALS['token'];
        $token = decode($token);
        if($token!=$id) {
            MSG('支付id错误');
        }
        $memberinfo = $this->memberinfo;
        $r = $this->db->get_one('pay',array('id'=>$id,'uid'=>$memberinfo['uid']));
        if(!$r) MSG('支付id错误');
        if($r['status']!=6) MSG('订单状态为：'.$this->status_arr[$r['status']]);
        $payment = $r['payment'];
        if($payment==1) MSG('支付方式错误');
        $pay_r = $this->db->get_one('payment',array('id'=>$payment,'status'=>1));
        if(!$pay_r) MSG('支付方式错误');

        if($r['money']>$memberinfo['money']) {
            MSG('您的余额不足，请先充值或选择其他方式付款！');
        }
        $money = $r['money'];
        $this->db->update('member',"`money`=(`money`-$money)",array('uid'=>$memberinfo['uid']));
        $this->db->update('pay',array('status'=>1),array('id'=>$id,'uid'=>$memberinfo['uid']));
        MSG('支付成功！','index.php?m=pay&f=payment&v=listing');
    }
}