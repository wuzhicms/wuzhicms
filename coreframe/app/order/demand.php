<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 订单收集
 */
class demand{
    function __construct() {
		$this->db = load_class('db');
    }

    /**
     * 用户提交
     */
    public function add(){
        if(isset($GLOBALS['username'])) {

            header("Access-Control-Allow-Origin: *");
            if(empty($GLOBALS['pinpai'])) {
                MSG('请选择品牌');
            }
            if(empty($GLOBALS['chexing'])) {
                MSG('请填写车型');
            }
            if(empty($GLOBALS['username'])) {
                MSG('请填写联系人');
            }
            if(empty($GLOBALS['mobile'])) {
                MSG('请填写电话');
            }
            $_uid = get_cookie('_uid');
            if(!$_uid) MSG('请先登录', 'index.php?m=member&v=login');
            if($GLOBALS['pinpai']=='-1') {//其它品牌
                $chexing = remove_xss($GLOBALS['chexing']);
                $username = remove_xss($GLOBALS['username']);
                $mobile = remove_xss($GLOBALS['mobile']);
                $yuding_config = get_cache('yuding_config','pay');
                $dingjin = $yuding_config['dingjin'];


                //MSG('支付保证金',WEBURL.'index.php?m=order&f=tuangou&v=pay&id='.$id);
                load_function('common','pay');
                load_function('preg_check');
                $memberinfo = $this->db->get_one('member',array('uid'=>$_uid));
                $total_price = $dingjin;
                $pay_r = $this->db->get_one('payment',array('id'=>2,'status'=>1));
                if(!$pay_r) MSG('支付方式错误');
                $order_no = date('YmdH').rand(100,999).date('is');
                $mobile = strip_tags($GLOBALS['mobile']);
                $formdata = array();
                $formdata['email'] = $memberinfo['email'];
                $formdata['username'] = $memberinfo['username'];
                $formdata['uid'] = $memberinfo['uid'];
                $formdata['linkman'] = strip_tags($GLOBALS['truename']);
                $formdata['telephone'] = strip_tags($GLOBALS['mobile']);
                $formdata['money'] = sprintf("%.2f",$total_price);
                $formdata['order_no'] = $order_no;
                $formdata['remark'] = '';

                $formdata['plus_minus'] = 1;
                $formdata['addtime'] = SYS_TIME;
                $formdata['quantity'] = 1;
                $formdata['status'] = 6;
                $formdata['payment'] = 2;
                $formdata['keytype'] = 7;
                $formdata['original_id'] = $id;

                $formdata['payname'] = '购车定金：'.'其它车型-'.$chexing;
                $formdata['linkman'] = $username;
                $id = $this->db->insert('pay',$formdata);
                $token = urlencode(encode($id));
                $formdata2 = array();
                $formdata2['id'] = $id;
                $formdata2['title'] = $r['title'];
                $formdata2['price'] = $r['price'];
                $formdata2['thumb'] = $r['thumb'];
                $formdata2['url'] = $r['url'];
                $formdata2['ip'] = get_ip();


                $formdata2['data1'] = $pinpai;//品牌
                $formdata2['data2'] = $chexi;//车系
                $formdata2['data3'] = $chexing;//车型
                $this->db->insert('pay_detail',$formdata2);
                $setting = unserialize($pay_r['setting']);
                $_pay = load_class($pay_r['classname'],'pay',$setting);

                $parameter = array(
                    "service_type"	=> $setting['service_type'],
                    "payment_type"	=> 1,//支付类型
                    "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment=2&module=order&file=car_callback',//同步通知地址
                    "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment=2&module=order&file=car_callback',//同步通知地址
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


                include T('order','buycar2');
            } else {
                $formdata = array();
                $formdata['title'] = remove_xss($GLOBALS['chexing']);
                $formdata['username'] = remove_xss($GLOBALS['username']);
                $formdata['pinpai'] = remove_xss($GLOBALS['pinpai']);
                $formdata['chexing'] = remove_xss($GLOBALS['chexing']);
                $formdata['mobile'] = $mobile = remove_xss($GLOBALS['mobile']);
                if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|1|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
                    if(isset($GLOBALS['ajax'])) {
                        echo '电话号码错误';exit;
                    } else {
                        MSG('电话号码错误');
                    }
                }
                //1小时，只允许提交一次
                $addtime = SYS_TIME-3600;
                $rd = $this->db->get_one('demand', "`mobile`='$mobile' AND `addtime` > $addtime");
                if($rd) {
                    if(isset($GLOBALS['ajax'])) {
                        echo '您已提交过需求，1小时只允许提交一次';exit;
                    } else {
                        MSG('您已提交过需求，1小时只允许提交一次');
                    }

                }

                $formdata['addtime'] = SYS_TIME;
                $formdata['status'] = 9;
                $username = get_cookie('_username');
                $formdata['publisher'] = $username;
                $formdata['ip'] = get_ip();
                $formdata['referer'] = remove_xss(HTTP_REFERER);

                $this->db->insert('demand', $formdata);
                $d1 = date('Y-m-d',SYS_TIME).' 8:59:59';
                $d2 = date('Y-m-d',SYS_TIME).' 19:00:00';
                $d3 = date('Y-m-d',SYS_TIME).' 23:59:59';
                $d1 = strtotime($d1);
                $d2 = strtotime($d2);
                $d3 = strtotime($d3);
                if(SYS_TIME<$d1) {
                    $msg_tips =  '感谢您选择车游买车帮，我们客服会第一时间与您联系确认订车完整信息，希望买车帮帮您成功购车';
                } elseif(SYS_TIME<$d2) {
                    $msg_tips = '感谢您选择车游买车帮，我们客服会第一时间与您联系确认订车完整信息，希望买车帮帮您成功购车';
                } else {
                    $msg_tips =  '感谢您选择车游买车帮，我们客服会第一时间与您联系确认订车完整信息，希望买车帮帮您成功购车';
                }

                /**
                //邮件发送
                $config = get_cache('sendmail');
                $siteconfigs = get_cache('siteconfigs');
                $password = decode($config['password']);
                //load_function('sendmail');
                $t = date('YmdHis');
                $subject = '有新的订单';
                $message = $formdata['title']."电话：".$formdata['mobile'].date('Y-m-d H:i:s',SYS_TIME);
                $message .= "请尽快审批！";
                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password); //设置smtp服务器，普通连接方式
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver('sss@ss.com'); //设置收件人，多个收件人，调用多次
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $mail->sendMail(); //发送
                 **/
                if(isset($GLOBALS['ajax'])) {
                    echo $msg_tips;
                } else {
                    include T('order','demand_success');
                }
            }

        }

    }
}
?>