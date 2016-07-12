<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 优惠券管理
 */
load_class('admin');
class card extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('coupon_card', '', '*', 0, 20,$page,'cardid DESC','groupname');
        $pages = $this->db->pages;
        $total = $this->db->number;

        $status_arr = array('<font color="red">待发送</font>','未使用','已激活','<font color="green">已使用</font>');
        include $this->template('card_listing');
    }
    /**
     * 优惠券列表
     */
    public function detail_listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $groupname = isset($GLOBALS['groupname']) ? strip_tags($GLOBALS['groupname']) : '';
        $where = $groupname ? "groupname='$groupname'" : '';
        $result = $this->db->get_list('coupon_card', $where, '*', 0, 20,$page,'cardid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        $status_arr = array('<font color="red">待发送</font>','未使用','已激活','<font color="green">已使用</font>');
        include $this->template('card_detail_listing');
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
            $tmpdata = iconv('gbk','utf-8','优惠券,面值,截至日期');
            $ip = get_ip();
            $formdata = array();
            $formdata['groupname'] = $GLOBALS['groupname'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['endtime'] = strtotime($GLOBALS['endtime']);
            $formdata['status'] = $download==1 ? 1 : 0;
            $formdata['adminname'] = get_cookie('username');
            $formdata['usetype'] = 0;
            $formdata['mount'] = $GLOBALS['form']['mount'];
            $formdata['title'] = remove_xss($GLOBALS['form']['title']);
            $formdata['batchid'] = $batchid;
            for($i=0;$i<$number;$i++) {
                $cardid = $this->db->insert('coupon_card',$formdata);

                $card_no = $GLOBALS['pre'].rand(100,1000).rand(100,999).str_pad(rand(1,99).$cardid, 6, "0", STR_PAD_LEFT);
                $password = rand(101010,999999);
                $this->db->update('coupon_card',array('card_no'=>$card_no,'password'=>$password),array('cardid'=>$cardid));
                $tmpdata .= "\r\n".$card_no.','.$password.','.$formdata['mount'].','.$GLOBALS['endtime'];
                if($download) {
                    $formdata2 = array();
                    $formdata2['cardid'] = $cardid;
                    $formdata2['type'] = 0;
                    $formdata2['senduser'] = $formdata['adminname'];
                    $formdata2['sendtime'] = SYS_TIME;
                    $formdata2['ip'] = $ip;
                    $this->db->insert('coupon_card_send',$formdata2);
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
                MSG('生成成功','?m=coupon&f=card&v=listing' . $this->su());
            }
        } else {
            $show_formjs = '';

            load_class('form');
            if(isset($GLOBALS['groupname'])) {
                $groupname = $GLOBALS['groupname'];
                $gr = $this->db->get_one('coupon_card', array('groupname' => $groupname));
                $title = $gr['title'];
                $endtime = date('Y-m-d',$gr['endtime']);
                $mount = $gr['mount'];
                include $this->template('card_add_group');
            } else {
                $groupname = '';
                $title = '';
                $endtime = mktime(0,0,0,date('m')+3,date('d'),date('Y'));
                $endtime = date('Y-m-d',$endtime);
                $mount = '';
                include $this->template('card_add');
            }


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
            $this->db->insert('coupon_card_send',$formdata2);
            $r = $this->db->get_one('coupon_card',array('cardid'=>$cardid));
            if($mobile) {
                $sendsms = load_class('sms','sms');
                //尊敬的用户，五指CMS优惠券为：sss，截止日期为：2016-12-1，请登录www.h1jk.cn及时使用！
                $sendsms->send_sms($mobile, $r['card_no'].'||'.date('Y-m-d',$r['endtime']), 269); //发送短信
            }
            if($email) {
                load_function('preg_check');
                if(empty($email) || !is_email($email)) {
                    MSG('邮箱地址错误');
                }
                $config = get_cache('sendmail');
                $password = decode($config['password']);
                //load_function('sendmail');
                $subject = $GLOBALS['email_title'] ? $GLOBALS['email_title'] : '五指CMS－优惠券';
                $email_content = $GLOBALS['email_content'];
                $email_content = format_textarea($email_content);
                $email_content = str_replace('##title##',$r['remark'],$email_content);
                $email_content = str_replace('##url##',substr(WEBURL,0,-1).$r['url'],$email_content);
                $email_content = str_replace('##money##',$r['money'],$email_content);
                $email_content = str_replace('##card_no##',$r['card_no'],$email_content);
                $email_content = str_replace('##endtime##',date('Y-m-d',$r['endtime']),$email_content);


                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password);
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver($email); //设置收件人，多个收件人，调用多次
                //$mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
                //$mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
                //$mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
                $mail->setMail($subject, $email_content); //设置邮件主题、内容
                $mail->sendMail(); //发送
            }
            $this->db->update('coupon_card',array('status'=>1),array('cardid'=>$cardid));
            MSG('发送成功',$GLOBALS['forward']);
        } else {
            $show_formjs = '';
            $r = $this->db->get_one('coupon_card',array('cardid'=>$cardid));
            $email_setting = get_cache('email_setting','coupon');
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
        $result = $this->db->get_list('coupon_card_send', array('cardid'=>$cardid), '*', 0, 20,$page,'sendtime DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('card_history');
    }

    /**
     * 邮件模板发送配置
     */
    public function email_setting() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['email_title'] = $GLOBALS['email_title'];
            $formdata['email_content'] = $GLOBALS['email_content'];
            set_cache('email_setting',$formdata,'coupon');
            $data = serialize($formdata);
            $this->db->update('setting', array('data'=>$data),array('keyid'=>'email_setting','m' => 'coupon'));
            MSG('更新成功',HTTP_REFERER);
        } else {
            $r = $this->db->get_one('setting', array('keyid'=>'email_setting','m' => 'coupon'));
            $setting = unserialize($r['data']);
            $email_title = $setting['email_title'];
            $email_content = $setting['email_content'];
            include $this->template('email_setting');
        }
    }
    /**
     * 绑定套餐
     */
    public function bind() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['open'] = $GLOBALS['open'];
            $formdata['needmoney'] = $GLOBALS['needmoney'];
            $formdata['deefmoney'] = $GLOBALS['deefmoney'];
            set_cache('coupon_setting',$formdata,'coupon');
            $data = serialize($formdata);
            $this->db->update('setting', array('data'=>$data),array('keyid'=>'coupon_setting','m' => 'coupon'));

            MSG('更新成功',HTTP_REFERER);
        } else {
            $r = $this->db->get_one('setting', array('keyid'=>'coupon_setting','m' => 'coupon'));
            if(!$r) {
                $formdata = array();
                $setting = array();
                $setting['open'] = 0;
                $setting['needmoney'] = 0;
                $setting['deefmoney'] = 0;
                $this->db->insert('setting', array('keyid'=>'coupon_setting','m' => 'coupon','data'=>serialize($setting)));
            } else {
                $setting = unserialize($r['data']);
            }
            $result = $this->db->get_list('coupon_ids', '', '*', 0, 2000, 0, 'updatetime DESC');
            $categorys = get_cache('category','content');
            include $this->template('bind');
        }
    }
    public function bind_select_content() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        if(isset($GLOBALS['submit']) && !empty($GLOBALS['ids'])) {
            foreach($GLOBALS['ids'] as $id) {
                $formdata = array();
                $formdata['cid'] = $cid;
                $formdata['id'] = $id;
                $formdata['updatetime'] = SYS_TIME;
                $r = $this->db->get_one('coupon_ids', array('cid'=>$cid,'id' => $id));
                if($r) {
                    $this->db->update('coupon_ids', $formdata,array('cid'=>$cid,'id' => $id));
                } else {
                    $this->db->insert('coupon_ids', $formdata);
                }
            }
            MSG('更新成功','?m=coupon&f=card&v=bind_select_content&cid='.$cid.$this->su());
        } else {
            $show_dialog = 1;
            $result = array();
            $stype = isset($GLOBALS['stype']) ? intval($GLOBALS['stype']) : 1;
            $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
            $keywords = isset($GLOBALS['keywords']) ? sql_replace($GLOBALS['keywords']) : '';
            $start = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
            $end = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';

            $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 52;

            $category = get_cache('category_'.$cid,'content');
            $modelid = $category['modelid'];

            $form = load_class('form');
            $where = array('modelid'=>$modelid);

            $options = array(1=>'标题',2=>'描述',3=>'发布人');
            $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
            $master_table = $model_r['master_table'];
            $where = "status=9";

            $model_r = $this->db->get_one('model',array('modelid'=>$modelid));

            $master_table = $model_r['master_table'];
            if($cid) {
                $where = "`cid`='$cid' AND `status`='$status'";
            } else {
                $where = "`status`='$status'";
            }

            switch($stype) {
                case 1:
                    if($keywords) $where .= " AND `title` LIKE '%$keywords%'";
                    break;
                case 2:
                    if($keywords) $where .= " AND `remark` LIKE '%$keywords%'";
                    break;
                case 3:
                    if($keywords) $where .= " AND `publisher`='$keywords'";
                    break;
            }
            if($start) {
                $where .= " AND `addtime`>'".strtotime($start)."'";
            }
            if($end) {
                $where .= " AND `addtime`<'".strtotime($end)."'";
            }
            $page = intval($GLOBALS['page']);
            $page = max($page,1);

            $result = $this->db->get_list($master_table,$where, '*', 0, 200,$page,'sort DESC');
            $pages = $this->db->pages;

            $form = load_class('form');

            include $this->template('bind_select_content');
        }

    }
    public function delete_content() {
        if(isset($GLOBALS['submit']) && !empty($GLOBALS['ids'])) {
            foreach ($GLOBALS['ids'] as $id) {
                $r = $this->db->delete('coupon_ids', array('id' => $id));
            }
            MSG('删除成功', '?m=coupon&f=card&v=set' . $this->su());
        } else {
            MSG('请选择要删除的内容', '?m=coupon&f=card&v=set' . $this->su());
        }

    }
}