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

        $this->status_arr = array(0=>'回收站',1=>'交易成功',2=>'交易失败',3=>'交易错误',4=>'交易超时',5=>'交易取消',6=>'等待用户付款',7=>'待商家发货',8=>'待用户确认收货');
	}
	public function listing(){
        $seo_title = '充值记录';
		$memberinfo = $this->memberinfo;
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : -1;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
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
        $result = $this->db->get_list('pay', "`uid`='".$memberinfo['uid']."' AND $where", '*', 0, 20,$page,'id DESC');
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

        $formdata['plus_minus'] = 1;
        $formdata['addtime'] = SYS_TIME;
        $formdata['quantity'] = 1;
        $formdata['status'] = 6;
        $formdata['payment'] = $payment;

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

        $html_text = $_pay->build_form($parameter,"get", "正在跳转至支付平台...");
        echo $html_text;
    }
}