<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_baiduAuth {
	private $secret, $appkey, $openid, $token, $extend;
	public $error;
	public function __construct($info = array()){
		if(!is_array($info) || empty($info))$info = get_cache('setting', 'member');
		$this->secret = $info['baidu_secret'];
		$this->appkey = $info['baidu_key'];
		$this->token = $info['token'];
		$this->code = $info['code'];
		$this->openid = '';
		$this->error = 0;
		$this->extend = array();
		load_function('common', 'member');
		if(empty($this->token))$this->get_token($this->code);
	}
	/**
	 * 得到token
	 */
	public function get_token($code){
		$code = $code ? $code : $this->code;
		$response = post('https://openapi.baidu.com/oauth/2.0/token?client_id='.$this->appkey.'&client_secret='.$this->secret.'&grant_type=authorization_code&code='.$code.'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v=auth&type=baidu'));
		$response = json_decode($response);
		if(isset($response->error)){
			MSG($this->error($response->error));
		}else{
			$this->token = $response->access_token;
			$this->expires_in = $response->expires_in + SYS_TIME;
			$this->extend = array(
				'refresh_token'=>$response->refresh_token,
				'scope'=>$response->scope,
				'session_key'=>$response->session_key,
				'session_secret'=>$response->session_secret,
			);
			unset($response);
			$this->get_openid();
		}
	}
	/**
	 * 得到userid
	 */
	
	public function get_openid(){
		$response = post('https://openapi.baidu.com/rest/2.0/passport/users/getLoggedInUser', array('access_token'=>$this->token));
		$response = json_decode($response);
		$this->openid = $response->uid;
		unset($response);
	}
	/**
	 * 登录
	 */
	public function login(){
		if(empty($this->openid))MSG('Error');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="baidu" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($r['uid']){
				return array('uid'=>$r['uid']);
			}
		}else{
			$r['authid'] = $db->insert('member_auth', array('type'=>'baidu', 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), true);
		}
		return array('authid'=>$r['authid']);
	}
	/**
	 * 错误返回
	 */
	public function error($error){
		$Error = array(
			'invalid_request'=>'invalid refresh token	请求缺少某个必需参数，包含一个不支持的参数或参数值，或者格式不正确。',
			'invalid_client'=>'unknown client id	client_id”、“client_secret”参数无效。',
			'invalid_grant'=>'The provided authorization grant is revoked	提供的Access Grant是无效的、过期的或已撤销的，例如，Authorization Code无效(一个授权码只能使用一次)、Refresh Token无效、redirect_uri与获取Authorization Code时提供的不一致、Devie Code无效(一个设备授权码只能使用一次)等。',
			'unauthorized_client'=>'The client is not authorized to use this authorization grant type	应用没有被授权，无法使用所指定的grant_type。',
			'unsupported_grant_type'=>'The authorization grant type is not supported	“grant_type”百度OAuth2.0服务不支持该参数。',
			'invalid_scope'=>'The requested scope is exceeds the scope granted by the resource owner	请求的“scope”参数是无效的、未知的、格式不正确的、或所请求的权限范围超过了数据拥有者所授予的权限范围。',
			'expired_token'=>'refresh token has been used	提供的Refresh Token已过期',
			'redirect_uri_mismatch'=>'Invalid redirect uri	“redirect_uri”所在的根域与开发者注册应用时所填写的根域名不匹配。',
			'unsupported_response_type'=>'The response type is not supported	“response_type”参数值不为百度OAuth2.0服务所支持，或者应用已经主动禁用了对应的授权模式',
			'slow_down'=>'The device is polling too frequently	Device Flow中，设备通过Device Code换取Access Token的接口过于频繁，两次尝试的间隔应大于5秒。',
			'authorization_pending'=>'User has not yet completed the authorization	Device Flow中，用户还没有对Device Code完成授权操作。',
			'authorization_declined'=>'User has declined the authorization	Device Flow中，用户拒绝了对Device Code的授权操作。',
			'invalid_referer'=>'Invalid Referer	Implicit Grant模式中，浏览器请求的Referer与根域名绑定不匹配',
		);
		return $Error[$error];
	}
}