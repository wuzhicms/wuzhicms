<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 预约卡管理
 */
load_class('admin');
class card extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 预约卡列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $batchid = isset($GLOBALS['batchid']) ? $GLOBALS['batchid'] : 0;
        $keytype = isset($GLOBALS['keytype']) ? $GLOBALS['keytype'] : 0;
        $keywords = isset($GLOBALS['keywords']) ? trim($GLOBALS['keywords']) : '';

        $where = $batchid ? "`batchid`='$batchid'" : '';
        if($keytype==0 && $keywords) {
            $where = "card_no LIKE '$keywords%'";
        } elseif($keytype==1 && $keywords) {
            $r = $this->db->get_one('member', array('username' => $keywords));
            if($r) {
                $uid = $r['uid'];
                $where = "uid = '$uid'";
            } else {
                MSG('用户不存在',HTTP_REFERER);
            }
        }
        $result = $this->db->get_list('order_card', $where, '*', 0, 20,$page,'cardid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $status_arr = array('<b>待发送</b>','未预约','已预约');
        include $this->template('card_listing');
    }

    /**
     * 生成卡
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $download = intval($GLOBALS['download']);
            $number = intval($GLOBALS['number']);
            $number = max($number,1);
            $batchid = uniqid();
            $tmpdata = iconv('gbk','utf-8','卡号,密码,截至日期');
            $ip = get_ip();
            for($i=0;$i<$number;$i++) {
                $formdata = array();
                $formdata['addtime'] = SYS_TIME;
                $formdata['endtime'] = strtotime($GLOBALS['endtime']);
                $formdata['status'] = $download==1 ? 1 : 0;
                $formdata['adminname'] = get_cookie('username');
                $formdata['id'] = $GLOBALS['form']['id'];
                $password = random_string('diy',8,'abcdefghjkmnpqrstuwxy23456789');
                $formdata['password'] = encode($password,'Hx0si1');
                $formdata['batchid'] = $batchid;
                $cardid = $this->db->insert('order_card',$formdata);
                $card_no = $GLOBALS['pre'].str_pad($cardid, 6, "0", STR_PAD_LEFT);
                $this->db->update('order_card',array('card_no'=>$card_no),array('cardid'=>$cardid));
                $tmpdata .= "\r\n".$card_no.','.$password.','.$GLOBALS['endtime'];
                if($download) {
                    $formdata2 = array();
                    $formdata2['cardid'] = $cardid;
                    $formdata2['type'] = 0;
                    $formdata2['senduser'] = $formdata['adminname'];
                    $formdata2['sendtime'] = SYS_TIME;
                    $formdata2['ip'] = $ip;
                    $this->db->insert('order_card_send',$formdata2);
                }
            }
            if($download) {


                $filename = $batchid . '.txt';

                //$content = ob_get_contents();
                header('Content-Description: File Transfer');
                header('Content-Type: application/txt');
                header('Content-Disposition: attachment; filename=' . $filename);
                // header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Pragma: public');
                header('Content-Transfer-Encoding: binary');
                header('Content-Encoding: none');
                echo $tmpdata;
            } else {
                MSG('生成成功','?m=order&f=card&v=listing' . $this->su());
            }
        } else {
            $show_formjs = '';
            $endtime = mktime(0,0,0,date('m')+3,date('d'),date('Y'));
            $endtime = date('Y-m-d',$endtime);
            load_class('form');
            include $this->template('card_add');
        }
    }
    public function send() {
        $cardid = intval($GLOBALS['cardid']);
        if(isset($GLOBALS['submit'])) {
            $mobile = $GLOBALS['mobile'];
            $email = $GLOBALS['email'];
            if(empty($mobile) && empty($email)) {
                MSG('手机，邮箱必须填写一项');
            }
            $formdata2 = array();
            $formdata2['cardid'] = $cardid;
            $formdata2['type'] = 0;
            $formdata2['senduser'] = get_cookie('username');
            $formdata2['mobile'] = $mobile;
            $formdata2['email'] = $email;
            $formdata2['note'] = $GLOBALS['note'];
            $formdata2['sendtime'] = SYS_TIME;
            $formdata2['ip'] = get_ip();
            $this->db->insert('order_card_send',$formdata2);
            $r = $this->db->get_one('order_card',array('cardid'=>$cardid));
            $card_password = decode($r['password'],'Hx0si1');
            if($mobile) {
                $sendsms = load_class('sms','sms');
                $sendsms->send_sms($mobile, $r['card_no'].'||'.$card_password, 222); //发送短信
            }
            if($email) {
                load_function('preg_check');
                if(empty($email) || !is_email($email)) {
                    MSG('邮箱地址错误');
                }
                $config = get_cache('sendmail');
                $password = decode($config['password']);
                //load_function('sendmail');
                $subject = '合一健康网－预约卡';
                $message = "您的预约卡信息如下：<br>卡号：{$r['card_no']} <br> 密码：{$card_password}<br>";
                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password);
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver($email); //设置收件人，多个收件人，调用多次
                //$mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
                //$mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
                //$mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $mail->sendMail(); //发送
            }
            $this->db->update('order_card',array('status'=>1),array('cardid'=>$cardid));
            MSG('发送成功',$GLOBALS['forward']);
        } else {
            $show_formjs = '';
            $r = $this->db->get_one('order_card',array('cardid'=>$cardid));
            include $this->template('card_send');
        }

    }
    /**
     * 发送记录
     */
    public function history() {
        $cardid = intval($GLOBALS['cardid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('order_card_send', array('cardid'=>$cardid), '*', 0, 20,$page,'sendtime DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('card_history');
    }
}