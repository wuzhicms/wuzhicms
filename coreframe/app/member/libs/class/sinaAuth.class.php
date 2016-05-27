<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_sinaAuth {
	private $secret, $appkey, $openid, $token, $extend;
	public $error;
	public function __construct($info = array()){
		if(!is_array($info) || empty($info))$info = get_cache('setting', 'member');
		$this->secret = $info['sina_secret'];
		$this->appkey = $info['sina_key'];
		$this->token = $info['token'];
		$this->code = $info['code'];
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
		$response = post('https://api.weibo.com/oauth2/access_token?client_id='.$this->appkey.'&client_secret='.$this->secret.'&grant_type=authorization_code&code='.$code.'&redirect_uri='.rawurlencode(WEBURL.'index.php?m=member&v=auth&type=sina'));
		$response = json_decode($response);
		if(isset($response->error_code)){		
			MSG($this->error($response->error_code));
		}else{
			$this->token = $response->access_token;
			$this->openid = $response->uid;
			$this->expires_in = $response->expires_in + SYS_TIME;
			unset($response);
		}
	}
	/**
	 * 返回用户信息
	 *
	 */
	public function get_user_info($openid = ''){
		return json_decode(get_curl('https://api.weibo.com/2/users/show.json?access_token='.$this->token.'&openid='.$this->openid.'&uid='.$openid),true);
	}
	/**
	 * 登录
	 */
	public function login(){
		$db = load_class('db');
		if(empty($this->openid))MSG('Error');
		$r = $db->get_one('member_auth', 'type="sina" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($r['uid']){
				return array('uid'=>$r['uid']);
			}
		}else{
			$user_info = $this->get_user_info($this->openid);
			//print_r($user_info);exit;
			$wz_member = load_class('member','member');
			$data = array();
			$data['username'] = str_replace(' ','',$user_info['name']);
			if($wz_member->check_user($data['username'])==false) {
				$data['username'] .= random_string('diy',6,'0123456789');
			}
			$data['password'] = $data['pwdconfirm'] = random_string('diy',10,'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
			$data['sex'] = $user_info['gender']=='m' ? 1 : 2;
			$data['avatar'] = 1;
			$data['modelid'] = 10;

			$r['uid'] = $wz_member->add($data);
			$r['authid'] = $db->insert('member_auth', array('type'=>'sina','uid'=>$r['uid'],'nickname'=>$user_info['nickname'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in), true);
			//保存头像
			$imgdata = get_curl(str_replace('/50/','/180/',$user_info['profile_image_url']));

			$dir = substr(md5($r['uid']), 0, 2).'/'.$r['uid'].'/';
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, $imgdata);
			//file_put_contents()
			return array('uid'=>$r['uid']);
		}
		return array('authid'=>$r['authid']);
	}

	public function bind_auth($uid) {
		if(empty($this->openid)) MSG('OPENID ERROR');
		$db = load_class('db');
		$r = $db->get_one('member_auth', 'type="sina" AND openid="'.$this->openid.'"', 'uid,authid');
		//	判断数据库是否已经存在数据
		if($r){
			$db->update('member_auth', array('token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), 'authid='.$r['authid']);
			//	判断是否是否已经绑定了会员
			if($uid!=$r['uid']) MSG('帐号已经绑定过其他会员名,如需解绑,请退出后,使用第三方帐号登录,然后解绑.');
			return array('uid'=>$r['uid']);
		} else {
			$user_info = $this->get_user_info($this->openid);

			$imgdata = get_curl(str_replace('/50/','/180/',$user_info['profile_image_url']));

			$dir = substr(md5($uid), 0, 2).'/'.$uid.'/';
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, $imgdata);
			$authid = $db->insert('member_auth', array('type'=>'sina','uid'=>$uid,'nickname'=>$user_info['name'], 'openid'=>$this->openid, 'token'=>$this->token, 'expires_in'=>$this->expires_in, 'extend'=>array2string($this->extend)), true);
			return true;
		}
	}

	/**
	 * 错误返回
	 */
	public function error($error){
		$Error = array(
			'10001'=>'System error	系统错误',
			'10002'=>'Service unavailable	服务暂停',
			'10003'=>'Remote service error	远程服务错误',
			'10004'=>'IP limit	IP限制不能请求该资源',
			'10005'=>'Permission denied, need a high level appkey	该资源需要appkey拥有授权',
			'10006'=>'Source paramter (appkey) is missing	缺少source (appkey) 参数',
			'10007'=>'Unsupport mediatype (%s)	不支持的MediaType (%s)',
			'10008'=>'Param error, see doc for more info	参数错误，请参考API文档',
			'10009'=>'Too many pending tasks, system is busy	任务过多，系统繁忙',
			'10010'=>'Job expired	任务超时',
			'10011'=>'RPC error	RPC错误',
			'10012'=>'Illegal request	非法请求',
			'10013'=>'Invalid weibo user	不合法的微博用户',
			'10014'=>'Insufficient app permissions	应用的接口访问权限受限',
			'10016'=>'Miss required parameter (%s) , see doc for more info	缺失必选参数 (%s)，请参考API文档',
			'10017'=>'Parameter (%s)’s value invalid, expect (%s) , but get (%s) , see doc for more info	参数值非法，需为 (%s)，实际为 (%s)，请参考API文档',
			'10018'=>'Request body length over limit	请求长度超过限制',
			'10020'=>'Request api not found	接口不存在',
			'10021'=>'HTTP method is not suported for this request	请求的HTTP METHOD不支持，请检查是否选择了正确的POST/GET方式',
			'10022'=>'IP requests out of rate limit	IP请求频次超过上限',
			'10023'=>'User requests out of rate limit	用户请求频次超过上限',
			'10024'=>'User requests for (%s) out of rate limit	用户请求特殊接口 (%s) 频次超过上限',
			'20001'=>'IDs is null	IDs参数为空',
			'20002'=>'Uid parameter is null	Uid参数为空',
			'20003'=>'User does not exists	用户不存在',
			'20005'=>'Unsupported image type, only suport JPG, GIF, PNG	不支持的图片类型，仅仅支持JPG、GIF、PNG',
			'20006'=>'Image size too large	图片太大',
			'20007'=>'Does multipart has image	请确保使用multpart上传图片',
			'20008'=>'Content is null	内容为空',
			'20009'=>'IDs is too many	IDs参数太长了',
			'20012'=>'Text too long, please input text less than 140 characters	输入文字太长，请确认不超过140个字符',
			'20013'=>'Text too long, please input text less than 300 characters	输入文字太长，请确认不超过300个字符',
			'20014'=>'Param is error, please try again	安全检查参数有误，请再调用一次',
			'20015'=>'Account or ip or app is illgal, can not continue	账号、IP或应用非法，暂时无法完成此操作',
			'20016'=>'Out of limit	发布内容过于频繁',
			'20017'=>'Repeat content	提交相似的信息',
			'20018'=>'Contain illegal website	包含非法网址',
			'20019'=>'Repeat conetnt	提交相同的信息',
			'20020'=>'Contain advertising	包含广告信息',
			'20021'=>'Content is illegal	包含非法内容',
			'20022'=>'Your ip’s behave in a comic boisterous or unruly manner	此IP地址上的行为异常',
			'20031'=>'Test and verify	需要验证码',
			'20032'=>'Update success, while server slow now, please wait 1-2 minutes	发布成功，目前服务器可能会有延迟，请耐心等待1-2分钟',
			'20101'=>'Target weibo does not exist	不存在的微博',
			'20102'=>'Not your own weibo	不是你发布的微博',
			'20103'=>'Can’t repost yourself weibo	不能转发自己的微博',
			'20104'=>'Illegal weibo	不合法的微博',
			'20109'=>'Weibo id is null	微博ID为空',
			'20111'=>'Repeated weibo text	不能发布相同的微博',
			'20201'=>'Target weibo comment does not exist	不存在的微博评论',
			'20202'=>'Illegal comment	不合法的评论',
			'20203'=>'Not your own comment	不是你发布的评论',
			'20204'=>'Comment id is null	评论ID为空',
			'20301'=>'Can’t send direct message to user who is not your follower	不能给不是你粉丝的人发私信',
			'20302'=>'Illegal direct message	不合法的私信',
			'20303'=>'Not your own direct message	不是属于你的私信',
			'20305'=>'Direct message does not exist	不存在的私信',
			'20306'=>'Repeated direct message text	不能发布相同的私信',
			'20307'=>'Illegal direct message id	非法的私信ID',
			'20401'=>'Domain not exist	域名不存在',
			'20402'=>'Wrong verifier	Verifier错误',
			'20501'=>'Source_user or target_user does not exists	参数source_user或者target_user的用户不存在',
			'20502'=>'Please input right target user id or screen_name	必须输入目标用户id或者screen_name',
			'20503'=>'Need you follow user_id	参数user_id必须是你关注的用户',
			'20504'=>'Can not follow yourself	你不能关注自己',
			'20505'=>'Social graph updates out of rate limit	加关注请求超过上限',
			'20506'=>'Already followed	已经关注此用户',
			'20507'=>'Verification code is needed	需要输入验证码',
			'20508'=>'According to user privacy settings,you can not do this	根据对方的设置，你不能进行此操作',
			'20509'=>'Private friend count is out of limit	悄悄关注个数到达上限',
			'20510'=>'Not private friend	不是悄悄关注人',
			'20511'=>'Already followed privately	已经悄悄关注此用户',
			'20512'=>'Please delete the user from you blacklist before you follow the user	你已经把此用户加入黑名单，加关注前请先解除',
			'20513'=>'Friend count is out of limit!	你的关注人数已达上限',
			'20521'=>'Hi Superman, you have concerned a lot of people, have a think of how to make other people concern about you! ! If you have any questions, please contact Sina customer service: 400 690 0000	hi 超人，你今天已经关注很多喽，接下来的时间想想如何让大家都来关注你吧！如有问题，请联系新浪客服：400 690 0000',
			'20522'=>'Not followed	还未关注此用户',
			'20523'=>'Not followers	还不是粉丝',
			'20524'=>'Hi Superman, you have cancelled concerning a lot of people, have a think of how to make other people concern about you! ! If you have any questions, please contact Sina customer service: 400 690 0000	hi 超人，你今天已经取消关注很多喽，接下来的时间想想如何让大家都来关注你吧！如有问题，请联系新浪客服：400 690 0000',
			'20601'=>'List name too long, please input text less than 10 characters	列表名太长，请确保输入的文本不超过10个字符',
			'20602'=>'List description too long, please input text less than 70 characters	列表描叙太长，请确保输入的文本不超过70个字符',
			'20603'=>'List does not exists	列表不存在',
			'20604'=>'Only the owner has the authority	不是列表的所属者',
			'20605'=>'Illegal list name or list description	列表名或描叙不合法',
			'20606'=>'Object already exists	记录已存在',
			'20607'=>'DB error, please contact the administator	数据库错误，请联系系统管理员',
			'20608'=>'List name duplicate	列表名冲突',
			'20610'=>'Does not support private list	目前不支持私有分组',
			'20611'=>'Create list error	创建列表失败',
			'20612'=>'Only support private list	目前只支持私有分组',
			'20613'=>'You hava subscriber too many lists	订阅列表达到上限',
			'20614'=>'Too many lists, see doc for more info	创建列表达到上限，请参考API文档',
			'20615'=>'Too many members, see doc for more info	列表成员上限，请参考API文档',
			'20701'=>'Repeated tag text	不能提交相同的收藏标签',
			'20702'=>'Tags is too many	最多两个收藏标签',
			'20703'=>'Illegal tag name	收藏标签名不合法',
			'20801'=>'Trend_name is null	参数trend_name是空值',
			'20802'=>'Trend_id is null	参数trend_id是空值',
			'20901'=>'Error: in blacklist	错误:已经添加了黑名单',
			'20902'=>'Error: Blacklist limit has been reached.	错误:已达到黑名单上限',
			'20903'=>'Error: System administrators can not be added to the blacklist.	错误:不能添加系统管理员为黑名单',
			'20904'=>'Error: Can not add yourself to the blacklist.	错误:不能添加自己为黑名单',
			'20905'=>'Error: not in blacklist	错误:不在黑名单中',
			'21001'=>'Tags parameter is null	标签参数为空',
			'21002'=>'Tags name too long	标签名太长，请确保每个标签名不超过14个字符',
			'21101'=>'Domain parameter is error	参数domain错误',
			'21102'=>'The phone number has been used	该手机号已经被使用',
			'21103'=>'The account has bean bind phone	该用户已经绑定手机',
			'21104'=>'Wrong verifier	Verifier错误',
			'21301'=>'Auth faild	认证失败',
			'21302'=>'Username or password error	用户名或密码不正确',
			'21303'=>'Username and pwd auth out of rate limit	用户名密码认证超过请求限制',
			'21304'=>'Version rejected	版本号错误',
			'21305'=>'Parameter absent	缺少必要的参数',
			'21306'=>'Parameter rejected	OAuth参数被拒绝',
			'21307'=>'Timestamp refused	时间戳不正确',
			'21308'=>'Nonce used	参数nonce已经被使用',
			'21309'=>'Signature method rejected	签名算法不支持',
			'21310'=>'Signature invalid	签名值不合法',
			'21311'=>'Consumer key unknown	参数consumer_key不存在',
			'21312'=>'Consumer key refused	参数consumer_key不合法',
			'21313'=>'Miss consumer key	参数consumer_key缺失',
			'21314'=>'Token used	Token已经被使用',
			'21315'=>'Token expired	Token已经过期',
			'21316'=>'Token revoked	Token不合法',
			'21317'=>'Token rejected	Token不合法',
			'21318'=>'Verifier fail	Pin码认证失败',
			'21319'=>'Accessor was revoked	授权关系已经被解除',
			'21320'=>'OAuth2 must use https	使用OAuth2必须使用https',
			'21321'=>'Applications over the unaudited use restrictions	未审核的应用使用人数超过限制',
			'21327'=>'Expired token	token过期',
			'21501'=>'Urls is null	参数urls是空的',
			'21502'=>'Urls is too many	参数urls太多了',
			'21503'=>'IP is null	IP是空值',
			'21504'=>'Url is null	参数url是空值',
			'21601'=>'Manage notice error, need auth	需要系统管理员的权限',
			'21602'=>'Contains forbid world	含有敏感词',
			'21603'=>'Applications send notice over the restrictions	通知发送达到限制',
			'21701'=>'Manage remind error, need auth	提醒失败，需要权限',
			'21702'=>'Invalid category	无效分类',
			'21703'=>'Invalid status	无效状态码',
			'21901'=>'Geo code input error	地理信息输入错误',
		);
		return $Error[$error];
	}
}