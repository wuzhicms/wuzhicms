<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 会员入口类
 */
class WUZHI_foreground {
	public $db, $memberinfo,$groups;
	public function __construct() {
		$this->db = load_class('db');
		$this->setting = get_cache('setting', 'member');
		//	判断是不是public 方法如果是则无需验证登录
		if(substr(V, 0, 7) != 'public_') {
			$this->check_login();
		}
        $this->groups = get_cache('group','member');
	}
	/**
	 * 判断是否是登录状态
	 */
	public function check_login(){
		//	如下方法无需验证登录状态
		if(M =='member' && F =='index' && in_array(V, array('login', 'logout', 'register', 'auth'))) {
		} else {
			$auth = get_cookie('auth');
			if ($auth) {
				$auth_key = substr(md5(_KEY), 8, 8);
				list($uid, $password, $cookietime) = explode("\t", decode($auth, $auth_key));
				$uid = (int)$uid;
				//	判断记录的时间是否过期
				if($cookietime && $cookietime < SYS_TIME){
					$this->clean_cookie();
					MSG(L('cookie_timeout'), 'index.php?m=member&v=login');
				}
				//	获取用户信息
				$this->memberinfo = $this->db->get_one('member', '`uid` = '.$uid, '*');
				//	判断用户是否被锁定
				if($this->memberinfo['lock'] && (empty($this->memberinfo['lock']) || $this->memberinfo['locktime'] > SYS_TIME))MSG(L('user_lock'), 'index.php');
				//	判断用户会员组
				if($this->memberinfo['groupid'] == 1) {
					$this->clean_cookie();
					MSG(L('user_banned'), 'index.php');
				} elseif($this->setting['checkemail'] && $this->memberinfo['groupid'] == 2) {
					$this->clean_cookie();
					$this->send_register_mail($this->memberinfo);
					MSG(L('need_email_authentication'));
				}
				//	判断用户密码是否和cookie一致
				if($this->memberinfo['password'] !== $password){
					$this->clean_cookie();
					MSG(L('login_again_please'), 'index.php?m=member&v=login');
				}
				//	如果用户还没选择模型 那么强制跳转到模型选择页面
				if(empty($this->memberinfo['modelid']) && V != 'model'){
					MSG(L('need_set_model'), 'index.php?m=member&v=model');
				}
				//	判断是否存在模型id
				if($this->memberinfo['modelid']){
					$model_table = $this->db->get_one('model', 'modelid='.$this->memberinfo['modelid'], 'attr_table');
					//获取用户模型信息
					$this->_member_modelinfo = $this->db->get_one($model_table['attr_table'], '`uid` = '.intval($uid), '*');
					if(is_array($this->_member_modelinfo)) {
						$this->memberinfo = array_merge($this->memberinfo, $this->_member_modelinfo);
					}
				}
				$this->uid = $uid;
			} else {
				MSG(L('login_please'), 'index.php?m=member&v=login');
			}
		}
	}
	/**
	 * 退出清除cookie
	 */
	protected function clean_cookie(){
		set_cookie('auth', '');
		set_cookie('_uid', '');
		set_cookie('_username', '');
		set_cookie('_groupid', '');
		set_cookie('modelid', '');
	}
	/**
	 * 登录设置cookie
	 */
	protected function create_cookie($info, $cookietime=0){
		set_cookie('auth', encode($info['uid']."\t".$info['password']."\t".$cookietime, substr(md5(_KEY), 8, 8)), $cookietime);
		set_cookie('_uid', $info['uid'], $cookietime);
		set_cookie('_username', $info['username'], $cookietime);
		set_cookie('_groupid', $info['groupid'], $cookietime);
        load_function('string');
        setcookie(COOKIE_PRE.'truename', urlencode($info['username']), $cookietime, COOKIE_PATH, COOKIE_DOMAIN, 0);
        setcookie(COOKIE_PRE.'modelid', $info['modelid'], $cookietime, COOKIE_PATH, COOKIE_DOMAIN, 0);
    }

	/**
	 * 注册验证 找回密码邮件发送
	 */
	protected function send_register_mail($info, $template = 'register'){
		$username = $info['username'];
		//	得到效验的url
		if($template == 'register'){
			$subject = L('activation');
			$url = WEBURL.'index.php?m=member&v=public_verify_email&uid='.$info['uid'].'&key='.md5($info['uid']._KEY);
		}else{
			$subject = L('forget_password');
			$url = WEBURL.'index.php?m=member&v=public_find_password_email&email='.$info['email'].'&key='.md5($info['email']._KEY);
		}
		//	获取模版
		ob_start();
		include T('member', 'mail_'.$template);
		$template = ob_get_contents();
		ob_clean();
		//	发送Email
		$mail = load_class('sendmail');
		$mail->setReceiver($info['email']);
		$mail->setMail($subject, $template);
		return $mail->sendMail();
	}
}