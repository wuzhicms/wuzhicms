<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 留言板管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;

	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 留言列表
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $status=array(1=>'未审核',7=>'办理中',8=>'已回复',9=>'未回复',10=>'已完结');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('guestbook', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $replys = array('<button type="button" class="btn btn-warning btn-xs">未回复</button>','已回复');
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }
        include $this->template('listing');
    }

    /**
     * 审核
     */
    public function audit() {
        $id = $GLOBALS['id'];
        $reply_user = get_cookie('wz_name');
        if(isset($GLOBALS['submit'])) {
            $status = 9;

            $this->db->update('guestbook',array('status'=>$status),array('id'=>$id));

            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $mr = $this->db->get_one('member', array('username' => $r['publisher']));
            //邮箱有验证状态时发送邮件通知
            if($mr['ischeck_email']) {
                load_function('preg_check');
                $config = get_cache('sendmail');
                $password = decode($config['password']);
                //load_function('sendmail');
                $subject = '有人回复了您的提问，请登录查询';
                $message = "提问内容：".$r['title']."<br>详细回复请登录：<br><a href='".WEBURL."index.php?m=guestbook&f=myissue&v=listing' target='_blank'>".WEBURL.'index.php?m=guestbook&f=myissue&v=listing</a> 查看';
                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password); //设置smtp服务器，普通连接方式
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver($mr['email']); //设置收件人，多个收件人，调用多次
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $mail->sendMail(); //发送
            }
            MSG(L('operation success'),$GLOBALS['forward']);
        } else {
            load_class('form');
            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
            require get_cache_path('guestbook_form','model');
            $form_build = new form_build($model_r['modelid']);

            $formdata = $form_build->execute($r);

            include $this->template('audit');
        }
    }

    /**
     * 回复
     */
    public function reply() {
        $id = $GLOBALS['id'];
        $reply_user = get_cookie('wz_name');
        if(isset($GLOBALS['submit'])) {
            $status = 8;
            if(!empty($GLOBALS['reply_user'])) $reply_user = remove_xss($GLOBALS['reply_user']);
            $this->db->update('guestbook',array('status'=>$status,'reply'=>$GLOBALS['reply'],'replytime'=>SYS_TIME,'reply_user'=>$reply_user),array('id'=>$id));

            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $mr = $this->db->get_one('member', array('username' => $r['publisher']));
            //邮箱有验证状态时发送邮件通知
            if($mr['ischeck_email']) {
                load_function('preg_check');
                $config = get_cache('sendmail');
                $password = decode($config['password']);
                //load_function('sendmail');
                $subject = '有人回复了您的提问，请登录查询';
                $message = "提问内容：".$r['title']."<br>详细回复请登录：<br><a href='".WEBURL."index.php?m=guestbook&f=myissue&v=listing' target='_blank'>".WEBURL.'index.php?m=guestbook&f=myissue&v=listing</a> 查看';
                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password); //设置smtp服务器，普通连接方式
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver($mr['email']); //设置收件人，多个收件人，调用多次
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $mail->sendMail(); //发送
            }
            MSG(L('operation success'),$GLOBALS['forward']);
        } else {
            load_class('form');
            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
            require get_cache_path('guestbook_form','model');
            $form_build = new form_build($model_r['modelid']);

            $formdata = $form_build->execute($r);

            include $this->template('reply');
        }
    }

    /**
     * 已完结
     */
    public function end() {
        $id = $GLOBALS['id'];
        $reply_user = get_cookie('wz_name');
        if(isset($GLOBALS['submit'])) {
            $status = 10;

            $this->db->update('guestbook',array('status'=>$status),array('id'=>$id));

            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $mr = $this->db->get_one('member', array('username' => $r['publisher']));
            //邮箱有验证状态时发送邮件通知
            if($mr['ischeck_email']) {
                load_function('preg_check');
                $config = get_cache('sendmail');
                $password = decode($config['password']);
                //load_function('sendmail');
                $subject = '有人回复了您的提问，请登录查询';
                $message = "提问内容：".$r['title']."<br>详细回复请登录：<br><a href='".WEBURL."index.php?m=guestbook&f=myissue&v=listing' target='_blank'>".WEBURL.'index.php?m=guestbook&f=myissue&v=listing</a> 查看';
                $mail = load_class('sendmail');
                $mail->setServer($config['smtp_server'], $config['smtp_user'], $password); //设置smtp服务器，普通连接方式
                $mail->setFrom($config['send_email']); //设置发件人
                $mail->setReceiver($mr['email']); //设置收件人，多个收件人，调用多次
                $mail->setMail($subject, $message); //设置邮件主题、内容
                $mail->sendMail(); //发送
            }
            MSG(L('operation success'),$GLOBALS['forward']);
        } else {
            load_class('form');
            $r = $this->db->get_one('guestbook',array('id'=>$id));
            $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
            require get_cache_path('guestbook_form','model');
            $form_build = new form_build($model_r['modelid']);

            $formdata = $form_build->execute($r);

            include $this->template('end');
        }
    }

    /**
     * 删除留言
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('guestbook',array('id'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}