<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_weixinAuth {
	private $appid, $appkey, $openid, $token, $extend;
	public $error;
	public function __construct($info = array()){
		if(!is_array($info) || empty($info))$info = get_cache('setting', 'member');
		$this->appid = $info['weixin_key'];
		$this->appkey = $info['weixin_secret'];
		$this->token = $info['token'];
		$this->code = $info['code'];
		$this->openid = '';
		$this->error = 0;
		$this->extend = array();
		if(empty($this->token)) $this->get_token($this->code);
	}

	/**
	 * 返回用户信息
	 *
	 */
	public function get_user_info($openid = ''){
		return json_decode(get_curl('https://api.weixin.qq.com/sns/userinfo?access_token='.$this->token.'&openid='.$this->openid),true);
	}
	/**
	 * 得到token
	 */
	public function get_token($code){
		$code = $code ? $code : $this->code;
		//$response = get_curl('https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id='.$this->appid.'&client_secret='.$this->appkey.'&code='.$code.'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v=auth&type=qq'));
		//echo 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appkey.'&code='.$code.'&grant_type=authorization_code';exit;
		$response = get_curl('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appkey.'&code='.$code.'&grant_type=authorization_code');
		$response = json_decode($response,true);
		if(isset($response['errcode'])){
			MSG($this->error($response['errcode']));
		}else{
			$this->token = $response['access_token'];
			$this->expires_in = $response['expires_in'] + SYS_TIME;
			$this->refresh_token = $response['refresh_token'];
			$this->openid = $response['openid'];
		}
	}
	/**
	 * 登录
	 */
	public function login(){
		if(empty($this->openid)) MSG('OPENID ERROR');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="weixin" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($r['uid']){
				return array('uid'=>$r['uid']);
			}
		} else {

			//直接注册
			$user_info = $this->get_user_info($this->openid);
			/*
			print_r($user_info['nickname']);
			print_r($user_info['gender']);//男
			print_r($user_info['figureurl_qq_2']);//男
*/
			$wz_member = load_class('member','member');
			$data = array();
			$data['username'] = str_replace(' ','',$user_info['nickname']);
			if($wz_member->check_user($data['username'])==false) {
				$data['username'] .= random_string('diy',6,'0123456789');
			}
			$data['password'] = $data['pwdconfirm'] = random_string('diy',10,'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
			$data['sex'] = $user_info['sex'];
			$data['avatar'] = 1;
			$data['groupid'] = 3;
			$data['modelid'] = 10;
			$r['uid'] = $wz_member->add($data);

			$r['authid'] = $db->insert('member_auth', array('type'=>'weixin','uid'=>$r['uid'],'nickname'=>$user_info['nickname'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in), true);
			//保存头像
			$imgdata = get_curl($user_info['headimgurl']);

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
		if(empty($this->openid)) MSG('OPENID ERROR');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="weixin" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($uid!=$r['uid']) MSG('帐号已经绑定过其他会员名,如需解绑,请退出后,使用第三方帐号登录,然后解绑.');
			return array('uid'=>$r['uid']);
		} else {
			$user_info = $this->get_user_info($this->openid);

			$imgdata = get_curl($user_info['headimgurl']);
			$dir = substr(md5($r['uid']), 0, 2).'/'.$uid.'/';
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, $imgdata);
			$authid = $db->insert('member_auth', array('type'=>'weixin','uid'=>$uid,'nickname'=>$user_info['nickname'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), true);
			return true;
		}
	}
	/**
	 * 错误返回
	 */
	public function error($error){
		$Error = array(
				'40001'=>'不合法的调用凭证',
				'40002'=>'不合法的grant_type',
				'40003'=>'不合法的OpenID',
				'40004'=>'不合法的媒体文件类型',
				'40007'=>'不合法的media_id',
				'40008'=>'不合法的message_type',
				'40009'=>'不合法的图片大小',
				'40010'=>'不合法的语音大小',
				'40011'=>'不合法的视频大小',
				'40012'=>'不合法的缩略图大小',
				'40013'=>'不合法的AppID',
				'40014'=>'不合法的access_token',
				'40015'=>'不合法的菜单类型',
				'40016'=>'不合法的菜单按钮个数',
				'40017'=>'不合法的按钮类型',
				'40018'=>'不合法的按钮名称长度',
				'40019'=>'不合法的按钮KEY长度',
				'40020'=>'不合法的url长度',
				'40023'=>'不合法的子菜单按钮个数',
				'40029'=>'不合法或已过期的code',
				'40030'=>'不合法的refresh_token',
				'40036'=>'不合法的template_id长度',
				'40037'=>'不合法的template_id',
				'40039'=>'不合法的url长度',
				'40048'=>'不合法的url域名',
				'40066'=>'不合法的url',
				'41001'=>'缺失access_token参数',
				'41002'=>'缺失appid参数',
				'41003'=>'缺失refresh_token参数',
				'41004'=>'缺失secret参数',
				'41008'=>'缺失code参数',
				'41009'=>'缺失openid参数',
				'41010'=>'缺失url参数',
				'42001'=>'access_token超时',
				'42002'=>'refresh_token超时',
				'42003'=>'code超时',
				'43001'=>'需要使用GET方法请求',
				'43002'=>'需要使用POST方法请求',
				'43003'=>'需要使用HTTPS',
				'45011'=>'频率限制',
				'50001'=>'接口未授权',
		);
		return $Error[$error];
	}
}