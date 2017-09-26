<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_qqAuth {
	private $appid, $appkey, $openid, $token, $extend;
	public $error;
	public function __construct($info = array()){
		if(!is_array($info) || empty($info))$info = get_cache('setting', 'member');
		$this->appid = $info['qq_appid'];
		$this->appkey = $info['qq_appkey'];
		$this->token = $info['token'];
		$this->code = $info['code'];
		$this->openid = '';
		$this->error = 0;
		$this->extend = array();
		if(empty($this->token))$this->get_token($this->code);
	}
	/**
	 * 得到openid
	 * @param unknown_type $code
	 */
	public function get_openid($token = ''){
		$token = $token ? $token : $this->token;
		if(empty($token))return '';

		$response =  get_curl('https://graph.qq.com/oauth2.0/me?access_token='.$token);


		$response = json_decode(substr($response, 9, -3));
		if(isset($response->error) && $response->error){
			$this->error = $response->error;
			return false;
		}
		$this->openid = $response->openid;
		return $response->openid;
	}
	/**
	 * 返回用户信息
	 *
	 */
	public function get_user_info($openid = ''){
		return json_decode(get_curl('https://graph.qq.com/user/get_user_info?oauth_consumer_key='.$this->appid.'&access_token='.$this->token.'&openid='.$this->openid.'&format=json'),true);
	}
	/**
	 * 得到token
	 */
	public function get_token($code){
		$code = $code ? $code : $this->code;
		$response = get_curl('https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id='.$this->appid.'&client_secret='.$this->appkey.'&code='.$code.'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v=auth&type=qq'));

		parse_str($response, $response);
		if(isset($response['error'])){
			MSG($this->error($response['error']));
		}else{
			$this->token = $response['access_token'];
			$this->expires_in = $response['expires_in'] + SYS_TIME;
			$this->refresh_token = $response['refresh_token'];
			$this->extend = $response;
			unset($response);
		}
	}
	/**
	 * 登录
	 */
	public function login(){
		$this->get_openid();
		if(empty($this->openid))MSG('OPENID ERROR');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="qq" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($r['uid']){
				return array('uid'=>$r['uid']);
			}
		} else {
			$user_info = $this->get_user_info($this->openid);
			/*
			print_r($user_info['nickname']);
			print_r($user_info['gender']);//男
			print_r($user_info['figureurl_qq_2']);//男
*/
			//直接注册
			$wz_member = load_class('member','member');
			$data = array();
			$data['username'] = str_replace(' ','',$user_info['nickname']);
			if($wz_member->check_user($data['username'])==false) {
				$data['username'] .= random_string('diy',6,'0123456789');
			}
			$data['password'] = $data['pwdconfirm'] = random_string('diy',10,'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
			$data['sex'] = $user_info['gender']=='男' ? 1 : 2;
			$data['avatar'] = 1;
			$data['modelid'] = 10;

			$r['uid'] = $wz_member->add($data);
			$r['authid'] = $db->insert('member_auth', array('type'=>'qq','uid'=>$r['uid'],'nickname'=>$user_info['nickname'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), true);
			$imgdata = get_curl($user_info['figureurl_qq_2']);

			$dir = substr(md5($r['uid']), 0, 2).'/'.$r['uid'].'/';
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, $imgdata);
			return array('uid'=>$r['uid']);
		}

		//return array('authid'=>$r['authid']);
	}
	public function bind_auth($uid) {
		$this->get_openid();
		if(empty($this->openid)) MSG('OPENID ERROR');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="qq" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($uid!=$r['uid']) MSG('帐号已经绑定过其他会员名,如需解绑,请退出后,使用第三方帐号登录,然后解绑.');
			return array('uid'=>$r['uid']);
		} else {
			$user_info = $this->get_user_info($this->openid);
			$imgdata = get_curl($user_info['figureurl_qq_2']);

			$dir = substr(md5($r['uid']), 0, 2).'/'.$uid.'/';
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, $imgdata);
			$authid = $db->insert('member_auth', array('type'=>'qq','uid'=>$uid,'nickname'=>$user_info['nickname'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), true);
			return true;
		}
	}
	/**
	 * 错误返回
	 */
	public function error($error){
		$Error = array(
				'100000'=>'缺少参数response_type或response_type非法。',
				'100001'=>'缺少参数client_id。',
				'100002'=>'缺少参数client_secret。',
				'100003'=>'http head中缺少Authorization。',
				'100004'=>'缺少参数grant_type或grant_type非法。',
				'100005'=>'缺少参数code。',
				'100006'=>'缺少refresh token。',
				'100007'=>'缺少access token。',
				'100008'=>'该appid不存在。',
				'100009'=>'client_secret（即appkey）非法。',
				'100010'=>'回调地址不合法，常见原因请见：回调地址常见问题及修改方法',
				'100011'=>'APP不处于上线状态。',
				'100012'=>'HTTP请求非post方式。',
				'100013'=>'access token非法。',
				'100014'=>'access token过期。 token过期时间为3个月。如果存储的access token过期，请重新走登录流程，根据使用Authorization_Code获取Access_Token或使用Implicit_Grant方式获取Access_Token获取新的access token值。',
				'100015'=>'access token废除。 token被回收，或者被用户删除。请重新走登录流程，根据使用Authorization_Code获取Access_Token或使用Implicit_Grant方式获取Access_Token获取新的access token值。',
				'100016'=>'access token验证失败。',
				'100017'=>'获取appid失败。',
				'100018'=>'获取code值失败。',
				'100019'=>'用code换取access token值失败。',
				'100020'=>'code被重复使用。',
				'100021'=>'获取access token值失败。',
				'100022'=>'获取refresh token值失败。',
				'100023'=>'获取app具有的权限列表失败。',
				'100024'=>'获取某OpenID对某appid的权限列表失败。',
				'100025'=>'获取全量api信息、全量分组信息。',
				'100026'=>'设置用户对某app授权api列表失败。',
				'100027'=>'设置用户对某app授权时间失败。',
				'100028'=>'缺少参数which。',
				'100029'=>'错误的http请求。',
				'100030'=>'用户没有对该api进行授权，或用户在腾讯侧删除了该api的权限。请用户重新走登录、授权流程，对该api进行授权。',
				'100031'=>'第三方应用没有对该api操作的权限。请发送邮件进行OpenAPI权限申请。',
		);
		return $Error[$error];
	}
}