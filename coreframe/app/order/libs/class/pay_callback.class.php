<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');


class WUZHI_pay_callback {

    function __construct(){
        $this->db = load_class('db');
        $this->credit_api = load_class('credit_api','credit');
    }

    function update($order_no){
        //$this->db->update('order_goods',array('status'=>1),array('order_no'=>$order_no));
        //生成卡号和密码，发送给用户

        $formdata = array();
        $formdata['addtime'] = SYS_TIME;
        $formdata['endtime'] = SYS_TIME+86400*365;//1年有效期
        $formdata['status'] = 1;
        $result = $this->db->get_list('order_goods', array('order_no'=>$order_no,'status'=>2), '*', 0, 20, 0);

        $message = '';
        $sendsms = load_class('sms','sms');
        $address = '';
        $batchid = $order_no;
        foreach($result as $r) {
            if($r['status']==1) continue;//防止重复通知
            $message .= $r['remark']."<br>";
            if(!isset($mr)) $mr = $this->db->get_one('member', array('uid' => $r['uid']));
            $formdata['id'] = $r['id'];
            if($r['usepoint']) {//积分扣除
                $this->credit_api->handle($r['uid'], '-',$r['usepoint'], '购买套餐：'.$r['remark'],'order'.$r['orderid']);
            }
            //实物卡不发送。
            if($r['cardtype']==0) {
                $cardtype = 0;
                for($i=0;$i<$r['quantity'];$i++) {
                    $password = random_string('diy',8,'abcdefghjkmnpqrstuwxy23456789');
                    $formdata['password'] = encode($password,'Hx0si1');
                    $formdata['batchid'] = $batchid;
                    //如果用户是个人用户，那么则直接绑定卡给用户。
                    if($mr['modelid']==10) {
                        $formdata['uid'] = $r['uid'];
                    }
                    $cardid = $this->db->insert('order_card',$formdata);
                    $card_no = 'HY'.str_pad($cardid, 6, "0", STR_PAD_LEFT);
                    $this->db->update('order_card',array('card_no'=>$card_no),array('cardid'=>$cardid));
                    $message .= "您的预约卡信息如下：<br>卡号：{$card_no} <br> 密码：{$password}<br>";
                }
            } else {
                $cardtype = 1;
            }

            $this->db->update('tuangou',"`volume`=(`volume`+1)", array('id' => $r['id']));
            $this->db->update('tuangou_data',"`surplus`=(`surplus`-".$r['quantity'].")", array('id' => $r['id']));
            if(empty($address)) $address = $this->db->get_one('express_address', array('addressid' => $r['addressid']));


        }

        if(empty($result)) return true;

        $this->db->update('order_goods',array('status'=>1),array('order_no'=>$order_no));

        load_function('preg_check');
        $config = get_cache('sendmail');
        $password = decode($config['password']);
        $mail = load_class('sendmail');
        $mail->setServer($config['smtp_server'], $config['smtp_user'], $password);
        $mail->setFrom($config['send_email']); //设置发件人
        $mail->setReceiver($mr['email']); //设置收件人，多个收件人，调用多次

        if($message!='' && $mr['modelid']==11) {
            $mobile = empty($address['mobile']) ? $mr['mobile'] : $address['mobile'];
            if($cardtype==1) {
                $subject = '合一健康网－实体卡订单预定成功！';
                $message = "尊敬的用户，您在合一健康网购买了体检套餐实体卡，我们将通过快递的方式寄到您手中。如您需要立刻体检，可以联系客服获取卡号信息！";
                $mail->setMail($subject, $message); //设置邮件主题、内容
                //尊敬的用户，您在合一健康网购买了体检套餐实体卡，我们将通过快递的方式寄到您手中。如您需要立刻体检，可以联系客服获取卡号信息！
                $sendsms->send_sms($mobile, '', 265); //发送短信
            } else {
                //企业用户发送短信通知：尊敬的企业用户，您在【合一健康】购买的套餐已购买成功，预约卡号和密码已通过邮件方式发送到：，请查收。
                $subject = '合一健康网－预约卡';
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $sendsms->send_sms($mobile, '', 256); //发送短信
            }
            $mail->sendMail(); //发送

        } elseif($mr['modelid']==10) {
            if($cardtype==1) {
                $subject = '合一健康网－实体卡订单预定成功！';
                $message = "尊敬的用户，您在合一健康网购买了体检套餐实体卡，我们将通过快递的方式寄到您手中。如您需要立刻体检，可以联系客服获取卡号信息！";

                $mail->setMail($subject, $message); //设置邮件主题、内容

                //普通用户发送：尊敬的用户，您在【合一健康】购买的套餐已购买成功，您可以通过您的购买帐号在线预约了！！。
                $mobile = empty($address['mobile']) ? $mr['mobile'] : $address['mobile'];
                $sendsms->send_sms($mobile, '', 265); //发送短信

            } else {
                $subject = '合一健康网－虚拟卡订单预定成功！';
                $message = '尊敬的用户：您已成功购买体检套餐，您可以在线预约了！';

                $mail->setMail($subject, $message); //设置邮件主题、内容
                //普通用户发送：尊敬的用户，您在【合一健康】购买的套餐已购买成功，您可以通过您的购买帐号在线预约了！！。
                $mobile = empty($address['mobile']) ? $mr['mobile'] : $address['mobile'];
                $sendsms->send_sms($mobile, '', 255); //发送短信
            }
            $mail->sendMail(); //发送
        }
        return true;
    }
}
?>
