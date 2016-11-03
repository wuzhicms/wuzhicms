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

            $serialize_data = serialize($formdata);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $this->db->update('site',array('setting'=>$serialize_data),array('siteid'=>SITEID));
            load_function('admin');
            $cache_global = load_class('cache_global_vars');
            $cache_global->cache_all();
            set_web_config('CLOSE',intval($formdata['close']));
            MSG(L('edit success'),HTTP_REFERER);
        } else {

			$setting = array();
            $r = $this->db->get_one('site',array('siteid'=>SITEID));
            if(!$r || $r['setting']=='') {
				$r2 = $this->db->get_one('setting',array('keyid'=>'configs','m'=>'core'));
				$setting = unserialize($r2['data']);
			} else {
				$setting = unserialize($r['setting']);
			}
			if(!$r['url']) $r['url'] = '请在：系统设置 - 站点管理 - 配置域名';
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
            
            //load_function('sendmail');
            $subject = '这里是一封来自 wuzhicms 的测试邮件';
            $message = "感谢您选择wuzhicms，看到该内容，说明您已经配置好邮件发送服务器！";
            load_function('sendmail');

            if(send_mail($receive,$subject,$message)===false) {
                MSG(L('邮件发送失败,请检查配置.'));
            }
            MSG(L('sendmail success'),HTTP_REFERER);
        } else {

            include $this->template('set_sendmail_test');
        }
    }

    /**
     * 自定义全局变量
     */
    public function global_vars() {

        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('setting', array('m'=>'global_vars'), '*', 0, 20,$page);
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('global_vars');
    }

    /**
     * 自定义全局变量添加
     */
    public function add_global_vars() {
        if(isset($GLOBALS['submit'])) {
            $r = $this->db->get_one('setting', array('keyid' => $GLOBALS['var'],'m'=>'global_vars'));
            if($r) MSG('变量已存在');
            $formdata = array();
            $formdata['m'] = 'global_vars';
            $formdata['title'] = $GLOBALS['title'];
            $formdata['keyid'] = $GLOBALS['var'];
            $formdata['data'] = $GLOBALS['data'];
            $this->db->insert('setting', $formdata);
            $cache = load_class('cache_global_vars');
            $cache->cache_all();
            MSG('添加成功','?m=core&f=set&v=global_vars'.$this->su());
        } else {
            $show_formjs = 1;
            include $this->template('global_vars_add');
        }
    }
    /**
     * 自定义全局变量修改
     */
    public function edit_global_vars() {
        $id = intval($GLOBALS['id']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['title'] = $GLOBALS['title'];
            $formdata['keyid'] = $GLOBALS['var'];
            $formdata['data'] = $GLOBALS['data'];
            $this->db->update('setting', $formdata,array('id'=>$id));
            $cache = load_class('cache_global_vars');
            $cache->cache_all();
            MSG('更新成功','?m=core&f=set&v=global_vars'.$this->su());
        } else {
            $show_formjs = 1;
            $data = $this->db->get_one('setting', array('id' => $id));
            include $this->template('global_vars_edit');
        }
    }
    /**
     * 自定义全局变量删除
     */
    public function delete_global_vars() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('setting',array('id'=>$id,'m'=>'global_vars'));
        $cache = load_class('cache_global_vars');
        $cache->cache_all();
        MSG('删除成功','?m=core&f=set&v=global_vars'.$this->su());
    }

}