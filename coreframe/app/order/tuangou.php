<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 团购报名
 */
load_class('foreground', 'member');
class tuangou extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 校准信息
     */
    public function checkinfo(){
        $memberinfo = $this->memberinfo;
        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('tuangou', array('id' => $id));
        //print_r($r);
        $title = $r['title'];
        if(isset($GLOBALS['submit'])) {
            load_class('session');
            if($_SESSION['_TS_'] && (SYS_TIME-$_SESSION['_TS_']<120)) {
                MSG('请勿重复提交！');
            } else {
                $_SESSION['_TS_'] = SYS_TIME;
            }
            $starttime = SYS_TIME-86400;
            $where = "`uid`=".$this->uid." AND `status`=6 AND `addtime`>$starttime";
            $count_result = $this->db->count_result('pay',$where);
            if($count_result>5) {
                MSG('您有5条未完成的订单，请先完成订单！','index.php?m=pay&f=payment&v=listing');
            }
            //MSG('支付保证金',WEBURL.'index.php?m=order&f=tuangou&v=pay&id='.$id);
            load_function('common','pay');
            load_function('preg_check');
            $memberinfo = $this->memberinfo;
            $r = $this->db->get_one('tuangou', array('id' => $id));
            $total_price = $r['price'];
            $pay_r = $this->db->get_one('payment',array('id'=>2,'status'=>1));
            if(!$pay_r) MSG('支付方式错误');
            $order_no = create_order_no();
            $mobile = strip_tags($GLOBALS['mobile']);
            $formdata = array();
            $formdata['email'] = $memberinfo['email'];
            $formdata['username'] = strip_tags($GLOBALS['truename']);
            $formdata['cartype'] = strip_tags($GLOBALS['pinpai'])."/".strip_tags($GLOBALS['chexing']);
            $formdata['uid'] = $memberinfo['uid'];
            $formdata['telephone'] = $mobile;
            $formdata['money'] = sprintf("%.2f",$total_price);
            $formdata['order_no'] = $order_no;
            $formdata['remark'] = '';

            $formdata['plus_minus'] = 1;
            $formdata['addtime'] = SYS_TIME;
            $formdata['quantity'] = 1;
            $formdata['status'] = 6;
            $formdata['payment'] = 2;
            $formdata['keytype'] = 4;
            $formdata['original_id'] = $id;

            $formdata['payname'] = $r['title'];
            $this->db->update('tuangou', "`apply_quantity`=(`apply_quantity`+1)", array('id' => $id));

            $id = $this->db->insert('pay',$formdata);
            $token = urlencode(encode($id));
            $formdata2 = array();
            $formdata2['id'] = $id;
            $formdata2['title'] = $r['title'];
            $formdata2['price'] = $r['price'];
            $formdata2['thumb'] = $r['thumb'];
            $formdata2['url'] = $r['url'];
            $formdata2['ip'] = get_ip();

            $formdata2['data1'] = isset($GLOBALS['attr_data1']) ? remove_xss($GLOBALS['attr_data1']) : '';
            $formdata2['data2'] = isset($GLOBALS['attr_data2']) ? remove_xss($GLOBALS['attr_data2']) : '';
            $formdata2['data3'] = isset($GLOBALS['attr_data3']) ? remove_xss($GLOBALS['attr_data3']) : '';

            $formdata2['title'] .= '—— '.$formdata2['data1'].' ～ '.$formdata2['data2'].' ～ '.$formdata2['data3'];
            $this->db->insert('pay_detail',$formdata2);


            $setting = unserialize($pay_r['setting']);
            $_pay = load_class($pay_r['classname'],'pay',$setting);

            $parameter = array(
                "service_type"	=> $setting['service_type'],
                "payment_type"	=> 1,//支付类型
                "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment=2&module=order&file=tuangou_callback',//同步通知地址
                "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment=2&module=order&file=tuangou_callback',//同步通知地址
                "email"	=> $formdata['email'],
                "order_no"	=> $formdata['order_no'],
                "payname"	=> $formdata['payname'],
                "total_fee"	=> $total_price,
                "remark"	=> $formdata['remark'],
                "url"	=> WEBURL,
                //-------
                "price"	=> $total_price,
                "quantity"	=> 1,
                "logistics_fee"	=> '0.00',
                "logistics_type"	=> 'EXPRESS',
                "logistics_payment"	=> 'SELLER_PAY',
                "receive_name"	=> '',
                "receive_address"	=> '',
                "receive_zip"	=> '',
                "receive_phone"	=> '',
                "receive_mobile"	=> $mobile,
            );

            $pay_link = $_pay->build_form($parameter,"get", "确认无误，前往支付页面",0,'target="_parent"');
//删除 购物车
            $pay_r2 = $this->db->get_one('payment',array('id'=>9,'status'=>1));
            if($pay_r2) $setting = unserialize($pay_r2['setting']);
            include T('order','pay');
        } else {
            $tuangouchexing = $r['tuangouchexing'];
            if($tuangouchexing) {
                $fields = array();
                $tuangouchexings = explode("\r\n",$tuangouchexing);
                foreach($tuangouchexings as $tgr) {
                    $tuangouchexing2 = explode("|",$tgr);
                    if($tuangouchexing2[0]!='') $fields[] = $tuangouchexing2[0];
                }

                $chexing_arr = array_unique($fields);
            } else {
                $chexing_arr = array();
            }
            if($memberinfo['mobile']==0) $memberinfo['mobile'] = '';
            include T('order','tuangou');
        }
    }
}
?>