<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_auth {
	private $setting;
	public $bind_auth = 0;
	public function __construct() {
		$this->setting = get_cache('setting', 'member');
		load_class('session');
	}
	/**
	 * 
	 * QQ互联统一登录方法
	 * @return array
	 */
	public function qq(){
		if(empty($this->setting['qq_appid']))MSG(L('auth_close'));
		$GLOBALS['code'] = isset($GLOBALS['code']) && preg_match('/^([a-z0-9]+)$/i', $GLOBALS['code']) ? $GLOBALS['code'] : '';
		if($GLOBALS['code']){
			$this->state('qq');
			$api = load_class('qqAuth', 'member', array('qq_appid'=>$this->setting['qq_appid'], 'qq_appkey'=>$this->setting['qq_appkey'], 'code'=>$GLOBALS['code']));
			if($this->bind_auth) {
				return $api->bind_auth($this->bind_auth);
			} else {
				return $api->login();
			}
		}else{
            header('Location:https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.$this->setting['qq_appid'].'&scope=&state='.$this->state().'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v='.V.'&type=qq'));
            exit;
		}
	}
	/**
	 * 
	 * SINA登录方法
	 * @return array
	 */
	public function sina(){
		if(empty($this->setting['sina_key']))MSG(L('auth_close'));
		$GLOBALS['code'] = isset($GLOBALS['code']) && preg_match('/^([a-z0-9]+)$/i', $GLOBALS['code']) ? $GLOBALS['code'] : '';
		if($GLOBALS['code']){
			$this->state('sina');
			$api = load_class('sinaAuth', 'member', array('sina_key'=>$this->setting['sina_key'], 'sina_secret'=>$this->setting['sina_secret'], 'code'=>$GLOBALS['code']));
			if($this->bind_auth) {
				return $api->bind_auth($this->bind_auth);
			} else {
				return $api->login();
			}
		}else{
            header('Location:https://api.weibo.com/oauth2/authorize?client_id='.$this->setting['sina_key'].'&response_type=code&state='.$this->state().'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v='.V.'&type=sina'));
            exit;
		}
	}
	/**
	 *
	 * weixin登录方法
	 * @return array
	 */
	public function weixin(){
		if(empty($this->setting['weixin_key'])) MSG(L('auth_close'));
		$GLOBALS['code'] = isset($GLOBALS['code']) && preg_match('/^([a-z0-9]+)$/i', $GLOBALS['code']) ? $GLOBALS['code'] : '';
		if($GLOBALS['code']){
			$this->state('weixin');
			$api = load_class('weixinAuth', 'member', array('weixin_key'=>$this->setting['weixin_key'], 'weixin_secret'=>$this->setting['weixin_secret'], 'code'=>$GLOBALS['code']));
			if($this->bind_auth) {
				return $api->bind_auth($this->bind_auth);
			} else {
				return $api->login();
			}
		}else{
			//https://open.weixin.qq.com/connect/qrconnect?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
			header('Location:https://open.weixin.qq.com/connect/qrconnect?appid='.$this->setting['weixin_key'].'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v='.V.'&type=weixin').'&response_type=code&scope=snsapi_login&state='.$this->state().'#wechat_redirect');
			exit;
		}
	}
	/**
	 * 
	 * BAIDU登录方法
	 * @return array
	 */
	public function baidu(){
		if(empty($this->setting['baidu_key']))MSG(L('auth_close'));
		$GLOBALS['code'] = isset($GLOBALS['code']) && preg_match('/^([a-z0-9]+)$/i', $GLOBALS['code']) ? $GLOBALS['code'] : '';
		if($GLOBALS['code']){
			$this->state('baidu');
			$api = load_class('baiduAuth', 'member', array('baidu_key'=>$this->setting['baidu_key'], 'baidu_secret'=>$this->setting['baidu_secret'], 'code'=>$GLOBALS['code']));
			if($this->bind_auth) {
				return $api->bind_auth($this->bind_auth);
			} else {
				return $api->login();
			}
		}else{
            header('Location:http://openapi.baidu.com/oauth/2.0/authorize?client_id='.$this->setting['baidu_key'].'&response_type=code&state='.$this->state().'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v='.V.'&type=baidu'));
            exit;
		}
	}
	/**
	 * 得到state字符串
	 * @param boolean $check 是否是效验
	 * @return	String
	 */
	protected function state($check = ''){
		if($check){
			if(!isset($_SESSION['state']) || empty($GLOBALS['state']) || $_SESSION['state'] != $GLOBALS['state']){
				$_SESSION['state'] = '';

				MSG(L('illegal_operation'), WEBURL.'index.php?m=member&v='.V.'&type='.$check, 2000);
			}else{
				$_SESSION['state'] = '';
			}
		}else{
			load_function('preg_check');
			$_SESSION['state'] = random_string('diy', 8, '23456789abcdefghjkmnpqrstuvwxyz');
			return $_SESSION['state'];
		}
	}
}