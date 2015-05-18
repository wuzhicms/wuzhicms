<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 异步加载
 */
load_class('foreground', 'member');
class json extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 获取可预约的时间
     */
    public function setmonth(){
        load_function('global','order');
        $d = $GLOBALS['d'];
        $dar = explode('-',$d);
        $month = $dar[1];
        $year = $dar[0];
        echo build_calendar($month,$year,'');
    }
    public function mini_car() {
        //统计购物车数量
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $order_api = load_class('order_api','content');
        $where = array('uid'=>$uid);
        $totals = $this->db->count_result('order_cart',$where);
        $result_rs = $this->db->get_list('order_cart', $where, '*', 0, 5, 0, 'updatetime DESC');
        $result = array();
        $total_price = 0;
        foreach($result_rs as $r) {
            $goods = $order_api->get($r['keyid']);
            $r['url'] = $goods['url'];
            $r['thumb'] = $goods['thumb'];
            $r['thumb'] = $goods['thumb'];
            $goods = $order_api->get($r['keyid']);
            $quantity = $r['quantity'];
            if($quantity<20) {
                $price = $goods['price'];
                $price_old = $goods['price_old'];
            } elseif($quantity>19 && $quantity<50) {
                $price = $goods['price2'];
                $price_old = $goods['price_old2'];
            } elseif($quantity>49 && $quantity<100) {
                $price = $goods['price3'];
                $price_old = $goods['price_old3'];
            } else {
                $price = $goods['price4'];
                $price_old = $goods['price_old4'];
            }

            $goods['price'] = $r['price'] = $price;
            $goods['price_old'] = $r['price_old'] = $price_old;
            $r['goods_detail'] = $goods;
            $r['jr_price'] = $goods['price_old']-$goods['price'];
            $r['min_quantity'] = $goods['type']=='2' ? 10 : 1;
            $total_price += $goods['price']*$r['quantity'];
            $result[] = $r;
        }
        include T('order','mini_car');
    }

    /**
     * 获取预约卡信息，邮件发送
     */
    function get_cardid() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $result = $this->db->get_list('order_card', array('batchid'=>$uid), '*', 0, 500, 0, 'cardid DESC');
        if(!empty($result)) {
            $message = '';
            foreach($result as $r) {
                $password = decode($r['password'],'Hx0si1');
                $st = $r['status']==1 ? '未使用' : '已使用';
                $message .= "您的预约卡信息如下：<br>卡号：".$r['card_no']." <br> 密码：".$password."<br>使用状态：".$st."<br>";
            }

            $config = get_cache('sendmail');
            $password = decode($config['password']);
            $subject = '合一健康网－预约卡';

            $mail = load_class('sendmail');
            $mail->setServer($config['smtp_server'], $config['smtp_user'], $password);
            $mail->setFrom($config['send_email']); //设置发件人
            $mail->setReceiver($memberinfo['email']); //设置收件人，多个收件人，调用多次
            $mail->setMail($subject, $message); //设置邮件主题、内容
            $mail->sendMail(); //发送
            echo '1';
        } else {
            exit('0');
        }
    }
    public function get_coupon_card_price() {
        echo 10;
    }
}
?>