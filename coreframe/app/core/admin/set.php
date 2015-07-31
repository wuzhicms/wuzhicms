<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 系统设置
 */
load_class('admin');

class set extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 基本设置
     */
    public function basic() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('strip_tags',$GLOBALS['form']);
            $formdata['copyright'] = $GLOBALS['form']['copyright'];
            $formdata['statcode'] = $GLOBALS['form']['statcode'];
            set_cache('siteconfigs',$formdata);
            $serialize_data = serialize($formdata);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $this->db->update('setting',array('data'=>$serialize_data,'updatetime'=>$updatetime),array('keyid'=>'configs','m'=>'core'));
            load_function('admin');
            set_web_config('CLOSE',intval($formdata['close']));
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'configs','m'=>'core'));
            $setting = unserialize($r['data']);
            load_class('form');
            include $this->template('set_basic');
        }
    }

    /**
     * 安全设置
     */
    public function safe() {
        $wr = $this->db->get_one('setting',array('keyid'=>'wuzhicms_token','m'=>'core'));
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            $formdata = serialize($formdata);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $this->db->update('setting',array('data'=>$formdata,'updatetime'=>$updatetime),array('keyid'=>'safe','m'=>'core'));
            $wuzhicms_token = strip_tags($GLOBALS['wuzhicms_token']);
            if(!$wr) {
                $formdata = array();
                $this->db->insert('setting', array('keyid'=>'wuzhicms_token','m'=>'core','data'=>$wuzhicms_token));
            } else {
                $this->db->update('setting', array('data'=>$wuzhicms_token,'updatetime'=>$updatetime),array('keyid'=>'wuzhicms_token','m'=>'core'));
            }
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $setting = array();
            include COREFRAME_ROOT.'configs/wz_config.php';
            $r = $this->db->get_one('setting',array('keyid'=>'safe','m'=>'core'));
            $setting = unserialize($r['data']);
            $wuzhicms_token = '';
            if($wr) {
                $wuzhicms_token = $wr['data'];
            }
            $setting['wuzhicms_token'] = $wuzhicms_token;
            include $this->template('set_safe');
        }
    }
    /**
     * 邮件服务器设置
     */
    public function sendmail() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            if($GLOBALS['password']=='**************************') {
                $r = $this->db->get_one('setting',array('keyid'=>'sendmail','m'=>'core'));

                if(is_array($r['data'])) {
                    $setting = unserialize($r['data']);
                    $formdata['password'] = $setting['password'];
                } else {
                    $data = unserialize($r['data']);
                    $formdata['password'] = $data['password'];
                }
            } else {
                $formdata['password'] = encode($GLOBALS['password']);
            }
            set_cache('sendmail',$formdata);
            $formdata = serialize($formdata);
            $this->db->update('setting',array('data'=>$formdata,'updatetime'=>$updatetime),array('keyid'=>'sendmail','m'=>'core'));
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'sendmail','m'=>'core'));
            $setting = unserialize($r['data']);
            $setting['password'] = '**************************';
            $support_ssl = 'disabled';
            if(function_exists('openssl_open')) $support_ssl = '';
            include $this->template('set_sendmail');
        }
    }
    /**
     * 邮件发送测试
     */
    public function sendmail_test() {
        $r = $this->db->get_one('setting',array('keyid'=>'sendmail','m'=>'core'));
        $setting = unserialize($r['data']);
        if(isset($GLOBALS['submit'])) {
            $receive = remove_xss($GLOBALS['receive']);

            load_function('preg_check');
            if(empty($receive) || !is_email($receive)) {
                MSG(L('email address error'));
            }
            $config = get_cache('sendmail');
            $password = decode($config['password']);
            //load_function('sendmail');
            $subject = '这里是一封来自 wuzhicms 的测试邮件';
            $message = "感谢您选择wuzhicms，看到该内容，说明您已经配置好邮件发送服务器！";
            $mail = load_class('sendmail');
            $mail->setServer($config['smtp_server'], $config['smtp_user'], $password); //设置smtp服务器，普通连接方式
            //$mail->setServer("smtp.gmail.com", "XXXXX@gmail.com", "XXXXX", 465, true); //设置smtp服务器，到服务器的SSL连接
            $mail->setFrom($config['send_email']); //设置发件人
            $mail->setReceiver($receive); //设置收件人，多个收件人，调用多次
            //$mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
            //$mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
            //$mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
            $mail->setMail($subject, $message); //设置邮件主题、内容
            $mail->sendMail(); //发送
            if($mail->_errorMessage) {
                MSG($mail->_errorMessage);
            }
            MSG(L('sendmail success'),HTTP_REFERER);
        } else {

            include $this->template('set_sendmail_test');
        }
    }
}