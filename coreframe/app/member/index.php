<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', M);
load_class('session');

$_POST['SUPPORT_MOBILE'] = 1;

class index extends WUZHI_foreground{
	function __construct() {
		$this->member = load_class('member', M);
		load_function('common', M);
		parent::__construct();
	}
	public function init(){
        $seo_title = '会员中心';
		$memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $groups = $this->groups;

        $GLOBALS['acbar'] = 1;
        //登录日志
        $log_results = $this->db->get_list('logintime', '`uid`='.$uid.' AND status > 1', '*', 0, 10, 0, 'id DESC');
        $ip_location = load_class('ip_location');
        foreach($log_results as $key=>$rs) {
            $log_results[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }
		$groupid = $memberinfo['groupid'];

		$safe_level = 1;//低
		if($memberinfo['ischeck_mobile'] && $groupid>2) {
			$safe_level = 3;//高
		} elseif($memberinfo['ischeck_mobile'] || $groupid>2) {
			$safe_level = 2;//中
		}
		//待处理的订单
		$order_goods_count = $this->db->count_result('order_goods', "`uid`='$uid' AND `status`=2");
		$order_goods_comment = $this->db->count_result('order_subscribe', "`uid`='$uid' AND `status` IN(2)");
		$coupon_card_count = $this->db->count_result('coupon_card_active', "`uid`='$uid' AND `status`=0");
		$status = intval($GLOBALS['status']);
		$status_arr = array();
		$status_arr[1] = '已付款（待预约）';
		$status_arr[2] = '待付款';
		$status_arr[3] = '交易取消';
		$status_arr[5] = '已付款（已预约）';
        $status_arr[6] = '已发货';

		$orderid = intval($GLOBALS['orderid']);
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
        $result_r = $this->db->get_list('order_goods',array('uid'=>$uid), '*', 0, 2,0,'orderid DESC','order_no');
        foreach($result_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']-$rs['coupon_card']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result[] = $r;
        }
		load_function('global','order');
		$categorys = get_cache('category','content');
		$postinfo_category = array();
		foreach($categorys as $_key =>$r) {
			if($_key==48) continue;
			$postinfo_category[$_key] = $r;
		}
		$admin_rs = $this->db->get_one('admin',array('uid'=>$uid),'role');
		//是否为IE8或者使用非框架,如果是跳转到 main
		$is_ie8 = 0;
		if(strpos($_SERVER[HTTP_USER_AGENT], "MSIE 8.0")) {
			$is_ie8 = 1;
		}
		$is_iframe = 1;//框架打开
		if($is_iframe==0 || $is_ie8) {
			header("Location: index.php?m=member&f=index&v=main");
		} else {
			include T('member','index');
		}
	}
	/**
	 * 登录
	 */
	public function login(){
		if(get_cookie('auth')) MSG(L('logined'), 'index.php?m=member');
		if(isset($GLOBALS['submit'])) {
            checkcode($GLOBALS['checkcode']);

			$username = isset($GLOBALS['username']) ? p_htmlspecialchars($GLOBALS['username']) : '';
			$password = isset($GLOBALS['password']) ? $GLOBALS['password'] : '';
			if(empty($username)) MSG(L('username_empty'));
			if(empty($password)) MSG(L('password_empty'));
			$cookietime = isset($GLOBALS['savecookie']) ? SYS_TIME+604800 : 0;
			if(is_email($username)){
				$userfield = 'email';
			}elseif(strlen($username) == 11 && preg_match('/^1\d{10}$/', $username)){
				$userfield = 'mobile';
			}else{
				$userfield = 'username';
			}
			$r = $this->db->get_one('member', '`'.$userfield.'` = "'.$username.'"', '*');
            $synlogin = '';
			if($this->setting['ucenter']){
				$ucenter = load_class('ucenter', M);
				//	如果用户不是通过用户名登录  则要转换一下
				if($userfield != 'username' && $r)$username = $r['username'];
				$synlogin = $ucenter->login($username, $password, $r);
			}
			if(empty($r))MSG(L('user_not_exist'));
			//	判断用户是否被锁定
			if($r['lock']){
				//	判断是否在锁定的时间内
				if($r['locktime'] > SYS_TIME){
					MSG(L('user_lock'), WEBURL);
				}else{
					//	将锁定标记改为0
					$this->db->update('member', 'lock=0', 'uid='.$r['uid']);
				}
			}
				
			//	判断会员组是否禁止登录
			if($r['groupid'] == 1) MSG(L('user_banned'), WEBURL);
			//	登录记录
			$loginLog = array('uid'=>$r['uid'], 'logintime'=>SYS_TIME, 'ip'=>get_ip());
			//	判断是否是第三方登录
			if(isset($_SESSION['authid']) && $_SESSION['authid']){
				$this->db->update('member_auth', array('uid'=>$r['uid']), 'authid='.$_SESSION['authid']);
				$_SESSION['authid'] = '';
			}
			if(md5(md5($password).$r['factor']) != $r['password']){
				$loginLog['status'] = 2;
				$this->db->insert('logintime', $loginLog);
				MSG(L('password_error'));
			}else{
				$loginLog['status'] = 3;
				$this->db->insert('logintime', $loginLog);
			}
			//	判断是否需要验证Email
			if($this->setting['checkemail'] && $r['groupid'] == 2){
				if($this->send_register_mail($r)){
					MSG(L('need_email_authentication'));
				}else{
					MSG(L('email_authentication_error'));
				}
			}
			$this->db->query('UPDATE `wz_member` SET `lasttime`='.SYS_TIME.', `lastip`="'.get_ip().'", `loginnum`=`loginnum`+1 WHERE `uid`='.$r['uid'], false);
			$this->create_cookie($r, $cookietime);

            $forward = empty($GLOBALS['forward']) ? 'index.php?m=member' : $GLOBALS['forward'];
			if(isset($GLOBALS['minilogin'])) {
				MSG(L('login_success').'<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>',HTTP_REFERER,3000);
			} else {
				MSG(L('login_success').$synlogin, $forward);
			}
		} else {
            $sina_akey = '';
            $seo_title = $seo_keywords = $seo_description = '会员登录';
            $forward = empty($GLOBALS['forward']) ? remove_xss(HTTP_REFERER) : remove_xss(urldecode($GLOBALS['forward']));
			$forward = safe_htm($forward);
			include T('member','login');
		}
	}
	public function public_mini_login() {
		include T('member','mini_login');
	}
	/**
	 * 注册
	 */
	public function register(){
		if(get_cookie('auth'))MSG(L('logined'), 'index.php?m=member', 2000);
		if(empty($this->setting['register']))MSG(L('close_register'), WEBURL, 2000);
		$setting = $this->setting;

		if(isset($GLOBALS['submit'])) {

			$mobile = $GLOBALS['mobile'];
			if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|1|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
				MSG('手机号码错误');
			}
			//检查短信验证码是否正确
			if($setting['checkmobile']) {
				$posttime = SYS_TIME-300;//5分钟内有效
				$r = $this->db->get_one('sms_checkcode',"`mobile`='$mobile' AND `posttime`>$posttime",'*',0,'id DESC');
				if(!$r || $r['code']!=$GLOBALS['smscode']) MSG("手机号验证失败！");
			} else {
				checkcode($GLOBALS['checkcode']);
			}

			//$GLOBALS['username'] = $mobile;
			$info = array();
			//	判断是否第三方登录
			if(isset($_SESSION['authid']) && $_SESSION['authid']){
				load_function('preg_check');
				$GLOBALS['password'] = $GLOBALS['pwdconfirm'] = random_string('diy', 6);
			}else{
				if($this->setting['invite']){
					if(empty($GLOBALS['invite']))MSG(L('invite_empty'));
					$info['invite'] = $GLOBALS['invite'];
				}
				if($this->setting['checkmobile']){
					if(empty($GLOBALS['mobile']))MSG(L('mobile_empty'));
					$info['mobile'] = $GLOBALS['mobile'];
				}
			}
			if(!isset($GLOBALS['email'])) $GLOBALS['email'] = '';
			if($this->setting['ucenter']){
				$ucenter = load_class('ucenter', M);
				$info['ucuid'] = $ucenter->register(array($GLOBALS['username'], $GLOBALS['password'], $GLOBALS['email'],$GLOBALS['mobile']));
			}
			//	注册赠送积分，  如果需要记录到财务的话  得搬到下面去
			$info['points'] = (int)$this->setting['points'];
            $info['modelid'] = intval($GLOBALS['modelid']);

            if($this->setting['checkuser']) {
				$groupid = 5;//待审会员组
			}elseif($this->setting['checkemail']) {
				$groupid = 2;// 邮件验证
			} else {
				$groupid = 3;
			}

            $info['groupid'] = $groupid;
			$info['username'] = $GLOBALS['username'];
			$info['email'] = $GLOBALS['email'];
			$info['password'] = $GLOBALS['password'];
			$info['pwdconfirm'] = $GLOBALS['pwdconfirm'];
			$info['companyname'] = remove_xss($GLOBALS['companyname']);
			$info['mobile'] = remove_xss($GLOBALS['mobile']);


			$uid = $this->member->add($info);
			if($uid){
				//	判断是否是第三方登录
				if(isset($_SESSION['authid']) && $_SESSION['authid']){
					$this->db->update('member_auth', array('uid'=>$uid), 'authid='.$_SESSION['authid']);
					$_SESSION['authid'] = '';
				}
				//	判断是否需要验证邮箱 
				if($this->setting['checkemail']){
					$info['uid'] = $uid;
					if($this->send_register_mail($info)){
						MSG(L('need_email_authentication'));
					}else{
						MSG(L('email_authentication_error'));
					}
				} else {
					//设置登录
					$r = $this->db->get_one('member', array('uid' => $uid));
					$this->create_cookie($r, SYS_TIME+604800);
					$synlogin = '';
					if($this->setting['ucenter']) {
						//同步登陆
						$synlogin = $ucenter->login($r['username'], $info['password'], $r);
					}
					MSG('注册成功'.$synlogin,'?m=member');
				}
			}else{
				MSG(L('register_error'));
			}
		} else {

            $seo_title = '会员注册';
            $categorys = get_cache('category','content');
			include T('member', 'register');
		}
	}
	public function model(){
		if($this->memberinfo['modelid'])MSG(L('set_model_again'));
		$model = $this->db->get_list('model', 'm="member"', 'modelid,name', 0, 200, 0, '', '', 'modelid');
		if(isset($GLOBALS['submit'])){
			$modelid = isset($GLOBALS['modelid']) ? $GLOBALS['modelid'] : 0;
			if(!isset($model[$modelid]))MSG(L('model').L('not_exists'));
			require get_cache_path('member_add', 'model');
			$form = new form_add($modelid);
			$formdata = $form->execute($GLOBALS['form']);
			$formdata['attr_data']['uid'] = $this->memberinfo['uid'];
            if($this->db->insert($formdata['attr_table'], $formdata['attr_data']) !== false){
            	$this->db->update('member', 'modelid='.$modelid, 'uid='.$this->memberinfo['uid']);
            	MSG(L('operation_success'), WEBURL.'index.php?m=member');
            }else{
            	MSG(L('operation_failure'));
            }
		}else{
			//	如果默认只有一个模型 或者  已经传递了模型的话那么就自动加载模型字段
			if(isset($GLOBALS['modelid']) && $model[$GLOBALS['modelid']]){
				$modelid = $GLOBALS['modelid'];
			}else if(count($model) == 1){
				list($modelid, $name) = each($model);
			} else {
                $modelid = 10;
            }
			//	如果存在modelid 加载模型类
			if($modelid){
				require get_cache_path('member_form','model');
				$form_build = new form_build($modelid);
            	$formdata = $form_build->execute();
			}
			include T('member', 'register_model');
		}
	}
	public function logout(){
		$this->clean_cookie();
        $ucsynlogout = '';
		if($this->setting['ucenter']){
			$ucenter = load_class('ucenter', M);
			$ucsynlogout = $ucenter->logout();
		}
		MSG(L('logout_success').$ucsynlogout, 'index.php');
	}
	/**
	 * 第三方通用登录
	 */
	public function auth(){
		load_function('curl');
		$type = in_array($GLOBALS['type'], array('qq', 'sina', 'baidu','weixin')) ? $GLOBALS['type'] : MSG(L('auth_not_exist'));
		$auth = load_class('auth', M);
		$info = $auth->$type();
		if($info['uid']){
			$r = $this->db->get_one('member', 'uid='.$info['uid'], '*');
			//	判断用户是否被锁定
			if($r['lock']){
				//	判断是否在锁定的时间内
				if($r['locktime'] > SYS_TIME){
					MSG(L('user_lock'), 'index.php');
				}else{
					//	将锁定标记改为0
					$this->db->update('member', 'lock=0', 'uid='.$info['uid']);
				}
			}
				
			//	判断会员组是否禁止登录
			if($r['groupid'] == 1)MSG(L('user_banned'), WEBURL);
			//	登录记录
			$this->db->insert('logintime',  array('uid'=>$info['uid'], 'logintime'=>SYS_TIME, 'ip'=>get_ip(), 'status'=>3));
			//	判断是否需要验证Email
			if($this->setting['checkemail'] && $r['groupid'] == 2){
				if($this->send_register_mail($r)){
					MSG(L('need_email_authentication'));
				}else{
					MSG(L('email_authentication_error'));
				}
			}
			$this->db->query('UPDATE `wz_member` SET `lasttime`='.SYS_TIME.', `lastip`="'.get_ip().'", `loginnum`=`loginnum`+1 WHERE `uid`='.$info['uid'], false);
			$this->create_cookie($r);
			MSG(L('login_success'),'index.php?m=member');
		}else{

			$_SESSION['authid'] = $info['authid'];
			$this->create_cookie($info);
			include T('member', 'auth');
		}
	}
	/**
	 * 设置头像
	 */
	public function avatar(){
		//	设定图片目录
		$dir = substr(md5($this->uid), 0, 2).'/'.$this->uid.'/';
		if(isset($GLOBALS['uid']) && $GLOBALS['uid'] == $this->uid){
			$dir = ATTACHMENT_ROOT.'member/'.$dir;
			if(!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			$filename = $dir.'180x180.jpg';
			file_put_contents($filename, file_get_contents("php://input"));
			$isimg = exif_imagetype($filename);
			if($isimg > 3 || $isimg < 1){
				unlink($filename);
				exit();
			}
			$avatararr = array('30x30.jpg', '45x45.jpg', '90x90.jpg', '180x180.jpg');
			$this->db->update('member', array('avatar'=>1), array('uid'=>$this->uid));
			exit('1');
		}else{
			$memberinfo = $this->memberinfo;
			$upurl = base64_encode(WEBURL.'/index.php?m=member&v=avatar&uid='.$this->uid);
			include T('member', 'avatar');
		}
	}
	/**
	 * 验证Email
	 */
	public function public_verify_email(){
		$uid = isset($GLOBALS['uid']) ? (int)$GLOBALS['uid'] : 0;
		$key = isset($GLOBALS['key']) ? $GLOBALS['key'] : '';
		if($key != md5($uid._KEY))MSG(L('illegal_operation'));
		if($uid)$user = $this->db->get_one('member', 'uid='.$uid, 'uid,username,password,groupid,email,modelid');
		if(empty($user))MSG(L('user_not_exist'));
		if($user['groupid'] != 2)MSG(L('operation_again'));
		if(isset($GLOBALS['submit'])){
			checkcode($GLOBALS['checkcode']);
			if($GLOBALS['email'] == $user['email']){
                if($user['modelid']==23) {
                    $groupid = 5;// 机构
                } else if($user['modelid']==11) {
                    $groupid = 4;//企业
                } else {
                    $groupid = 3;
                }
				$this->db->update('member',array('groupid'=>$groupid), 'uid='.$uid);
				$this->create_cookie($user);
				//	判断是否选了模型
				if($user['modelid']){
					MSG(L('operation_success'), WEBURL.'index.php?m=member');
				}else{
					MSG(L('operation_success').','.L('need_set_model'), WEBURL.'index.php?m=member&v=model');
				}
			}else{
				MSG(L('illegal_operation'));
			}
		}else{
			include T('member', 'verify_email');
		}
	}
	public function public_find_password_email(){
		$email = isset($GLOBALS['email']) && is_email($GLOBALS['email']) ? $GLOBALS['email'] : '';
		if(isset($GLOBALS['key'])){
			if($GLOBALS['key'] != md5($email._KEY))MSG(L('illegal_operation'));
			$key_verify = $this->db->get_one('key_verify', array('keyid'=>$GLOBALS['key']));
			if(!$key_verify || $key_verify['addtime']<SYS_TIME-3600) {
				MSG('链接已失效');
			}
			if(isset($GLOBALS['submit'])){
				if($GLOBALS['password'] == '' || $GLOBALS['password'] != $GLOBALS['pwdconfirm'])MSG(L('password_not_identical'));
				checkcode($GLOBALS['checkcode']);

				if($this->db->query('UPDATE `wz_member` SET `password` = md5(CONCAT("'.md5($GLOBALS['password']).'", `factor`)) WHERE `email`="'.$email.'"')){
					$this->db->delete('key_verify', array('keyid'=>$GLOBALS['key']));
					$forward = urlencode(WEBURL.'index.php?m=member');
					MSG(L('operation_success'), WEBURL.'index.php?m=member&v=login&forward='.$forward);
				}else{
					MSG(L('operation_failure'));
				}
			}else{
				include T('member', 'find_password_email');
			}
		}else{
			if(isset($GLOBALS['submit'])){
				checkcode($GLOBALS['checkcode']);
				if($email)$user = $this->db->get_one('member', "email='$email'", 'uid,username,password,groupid,email,modelid');
				if($user){
					$this->send_register_mail($user, 'password');
					MSG(L('need_email_authentication'));
				}else{
					MSG(L('user_not_exist'));
				}
			}else{
				include T('member', 'find_password_email');
			}
		}
	}

	public function public_find_password_mobile(){
		if(isset($GLOBALS['submit'])){
			$mobile = $GLOBALS['mobile'];

			//检查验证码是否匹配
			$password = random_string('diy',6,'23456789abcdefghjkmnpqrstuwxy');
			if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|1|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
				MSG('手机号码错误');
			}
			$posttime = SYS_TIME-300;//5分钟内有效
			$r = $this->db->get_one('sms_checkcode',"`mobile`='$mobile' AND `posttime`>$posttime",'*',0,'id DESC');
			if(!$r || $r['code']!=$GLOBALS['smscode']) MSG("手机号验证失败！");

			if($this->db->query('UPDATE `wz_member` SET `ischeck_mobile`=1,`pw_reset`=0,`password` = md5(CONCAT("'.md5($password).'", `factor`)) WHERE `mobile`="'.$mobile.'"')) {
				$this->db->delete('sms_checkcode',array('mobile'=>$mobile));
				$sendsms = load_class('sms','sms');
				$returnstr = $sendsms->send_sms($mobile, $password, 5); //发送短信
				if($sendsms->statuscode==0) {
					$forward = urlencode(WEBURL.'index.php?m=member');
					MSG('新密码已发送到您的手机，请查收！', WEBURL.'index.php?m=member&v=login&forward='.$forward);
				} else {
					MSG($returnstr) ;
				}
			}else{
				MSG(L('operation_failure'));
			}
		} else {
			include T('member', 'find_password_mobile');
		}
	}
	/**
	 * 判断邀请码是否有效
	 */
	public function public_check_invite(){
		$invite = isset($GLOBALS['invite']) && $GLOBALS['invite'] ? $GLOBALS['invite'] : (isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : false);
		if(empty($invite) || strlen($invite) != 8 || !preg_match('/^[0-9a-z]{8}$/i', $invite))exit('{"info":"'.L('illegal_parameters').'","status":"n"}');
		echo $this->member->check_invite($invite, 1);
	}
	/**
	 * 判断用户名是否合规
	 */
	public function public_check_user(){
		$username = isset($GLOBALS['username']) && $GLOBALS['username'] ? $GLOBALS['username'] : (isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : false);
		if(empty($username))exit('{"info":"'.L('illegal_parameters').'","status":"n"}');
		if(strtolower(CHARSET) != 'utf-8')$username = iconv('UTF-8', 'gb2312//IGNORE', $username);
		echo $this->member->check_user($username, 1);
	}
	/**
	 * 判断email是否已被使用
	 */
	public function public_check_email(){
		$email = isset($GLOBALS['email']) && $GLOBALS['email'] ? $GLOBALS['email'] : (isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : false);
		if(empty($email))exit('{"info":"'.L('illegal_parameters').'","status":"n"}');
		$uid = isset($GLOBALS['uid']) ? (int)$GLOBALS['uid'] : 0;
		echo $this->member->check_email($email, $uid, 1);
	}
	/**
	 * 判断手机号码是否可用
	 */
	public function public_check_mobile(){
		$mobile = isset($GLOBALS['mobile']) && $GLOBALS['mobile'] ? $GLOBALS['mobile'] : (isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : false);
		if(empty($mobile))exit('{"info":"'.L('illegal_parameters').'","status":"n"}');
		$uid = isset($GLOBALS['uid']) ? (int)$GLOBALS['uid'] : 0;
		echo $this->member->check_mobile($mobile, $uid, 1);
	}

    /**
     * 个人资料修改
     */
    public function profile() {
		$uid = $this->uid;
		if($uid)$member = $this->db->get_one('member', '`uid`='.$uid, '*');
		if(empty($member))MSG(L('user not_exists'));
		$models = get_cache('model_member','model');
		if(isset($GLOBALS['submit'])) {

			$GLOBALS['info']['factor'] = $member['factor'];
			$GLOBALS['info']['username'] = $member['username'];
			$GLOBALS['info']['modelid'] = $member['modelid'];

			$GLOBALS['info']['email'] = $member['email'];
			if(!$this->member->edit($GLOBALS['info'], $uid)) MSG(L('operation_failure'));

			$formdata = $GLOBALS['form'];

			$data = $data_en = array();
			foreach($formdata as $field=>$value) {
				$fields = explode('_',$field);
				$field = $fields[0];
				$modelid = $fields[1];
				if(is_array($value)) {
					$value = ','.implode(',',$value).',';
				}
				if($fields[2]) {
					$data_en[$modelid][$field] = $value;
				} else {

					$data[$modelid][$field] = $value;
				}
			}

			foreach($data as $modelid=>$rs) {
				$table = $models[$modelid]['attr_table'];
				$rd = $this->db->get_one($table, array('uid' => $uid));
				if($rd) {
					$this->db->update($table, $rs, array('uid' => $uid));
				} else {
					$rs['uid'] = $uid;
					$this->db->insert($table, $rs);
				}
			}
			foreach($data_en as $modelid=>$rs) {
				$table = $models[$modelid]['attr_table'].'_en';
				$rd = $this->db->get_one($table, array('uid' => $uid));
				if($rd) {
					$this->db->update($table, $rs, array('uid' => $uid));
				} else {
					$rs['uid'] = $uid;
					$this->db->insert($table, $rs);
				}
			}
			MSG('信息修改成功!','?m=member&f=index&v=main');
		} else {
			$memberinfo = $this->memberinfo;
			$groups = $this->groups;
			$auth_result = $this->db->get_list('member_auth', array('uid'=>$memberinfo['uid']), '*', 0, 20, 0,'','','type');

			$modelid = $member['modelid'];
			//	判断是否有模型id参数

//print_r($models);
			$modelids = explode(',',$modelid);
			asort($modelids);
			$is_load = false;
			foreach($modelids as $modelid) {
				if($is_load==false) {
					require get_cache_path('member_form','model');
					$form_build = new form_build($modelid);
					$is_load = true;
				}

				$form_build->fields = get_cache('field_'.$modelid,'model');
				$tmp = $this->db->get_one($models[$modelid]['attr_table'], array('uid' => $uid));
				//$tmp_en = $this->db->get_one($models[$modelid]['attr_table'].'_en', array('uid' => $uid));
				$formdata = 'formdata_'.$modelid;
				$formdata2 = 'formdata2_'.$modelid;
				$$formdata = $form_build->execute($tmp,$modelid);
				//$$formdata2 = $form_build->execute($tmp_en,$modelid,'en');
			}
			include T('member', 'profile');
        }
    }

    /**
     * 修改密码
     */
    public function edit_password() {
        $memberinfo = $this->memberinfo;
        if(isset($GLOBALS['submit'])) {
            //checkcode($GLOBALS['checkcode']);
            $password = $GLOBALS['password'];
            $password2 = $GLOBALS['password2'];
            if($password!=$password2) MSG(L('password_not_identical'));
            $oldpassword = $GLOBALS['oldpassword'];
            if(md5(md5($oldpassword).$memberinfo['factor']) != $memberinfo['password']) MSG('原密码错误!');

            $factor = random_string('diy', 6);
            $this->db->update('member', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)), '`uid`='.$memberinfo['uid']);
            MSG(L('operation_success'),'index.php?m=member');
        } else {
            $seo_title = '修改密码';
            include T('member', 'edit_password');
        }
    }
	/**
     * 强制修改新密码
     */
    public function pw_reset() {
        $memberinfo = $this->memberinfo;
        if(isset($GLOBALS['submit'])) {
            //checkcode($GLOBALS['checkcode']);
			if($GLOBALS['password']=='') {
				MSG('密码不能为空',HTTP_REFERER);
			}
            $password = $GLOBALS['password'];
            $password2 = $GLOBALS['password2'];
            if($password!=$password2) MSG(L('password_not_identical'));

            $factor = random_string('diy', 6);
            $this->db->update('member', array('factor'=>$factor, 'password'=>md5(md5($password).$factor)
,'pw_reset'=>0), '`uid`='.$memberinfo['uid']);
            MSG(L('operation_success'),'index.php?m=member');
        } else {
            $seo_title = '设定新密码';
            include T('member', 'pw_reset');
        }
    }
	/**
	 * 账户安全检查
	 */
	public function account_safe() {
		$memberinfo = $this->memberinfo;
		$uid = $memberinfo['uid'];

		$groupid = $memberinfo['groupid'];
		$safe_level = 1;//低
		if($memberinfo['ischeck_mobile'] && $groupid>2) {
			$safe_level = 3;//高
		} elseif($memberinfo['ischeck_mobile'] || $groupid>2) {
			$safe_level = 2;//中
		}
		include T('member', 'account_safe');
	}

	/**
 * 修改手机
 */
	public function edit_mobile() {
		if(isset($GLOBALS['submit'])) {
			$mobile = $GLOBALS['mobile'];
			if(!preg_match('/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|17[0|1|2|3|5|6|7|8|9]\d{8}|18[0|1|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/',$mobile)) {
				MSG('手机号码错误');
			}
			$uid = $this->memberinfo['uid'];
			$posttime = SYS_TIME-300;//5分钟内有效
			$r = $this->db->get_one('sms_checkcode',"`mobile`='$mobile' AND `uid`='$uid' AND `posttime`>$posttime",'*',0,'id DESC');
			if(!$r || $r['code']!=$GLOBALS['smscode']) MSG("手机号验证失败！");
			$this->db->update('member', array('mobile'=>$mobile,'ischeck_mobile'=>1), array('uid' => $uid));
            if($this->memberinfo['ischeck_mobile']==0) {
                $point_config = get_cache('point_config');
                $credit_api = load_class('credit_api','credit');
                $credit_api->handle($uid, '+',$point_config['mobile_check'], '验证手机号：'.$mobile);
            }
            if(isset($GLOBALS['buyer']) && $this->memberinfo['ischeck_email']==0) {
                MSG('还差一步：完成邮件验证后，就可以购物了！','index.php?m=member&f=index&v=edit_email&buyer=1',3000);
            } else {
                MSG('手机号更新成功！','?m=member&f=index&v=account_safe');
            }

		} else {
			$memberinfo = $this->memberinfo;
			include T('member', 'edit_mobile');
		}
	}
	/**
	 * 修改邮箱
	 */
	public function edit_email() {
		if(isset($GLOBALS['submit'])) {
			load_function('preg_check');
			$email = $GLOBALS['email'];
			if(!is_email($email)) {
				MSG('邮箱错误');
			}
			$uid = $this->memberinfo['uid'];
			$r = $this->db->get_one('member', array('email' => $email));
			if($r && $r['uid']!=$uid) {
				MSG('邮箱地址已经被占用！');
			}

			$this->db->update('member', array('email'=>$email,'ischeck_email'=>0), array('uid' => $uid));
			$r = $this->db->get_one('setting',array('keyid'=>'sendmail','m'=>'core'));
			$setting = unserialize($r['data']);
			$config = get_cache('sendmail');
			$siteconfigs = get_cache('siteconfigs');
			$password = decode($config['password']);
			//load_function('sendmail');
			$t = date('YmdHis');
			$jhurl = WEBURL.'index.php?m=member&f=json&v=active_email&uid='.$uid.'&email='.$email.'&t='.$t.'&auth='.urlencode(encode($t.$uid.$email));
			$subject = '邮件验证';
			$message = "尊敬的用户，您正在使用【".$siteconfigs['sitename']."】进行邮箱验证<br>";
			$message .= "点击链接地址：<a href='$jhurl' target='_blank'>{$jhurl}</a>";

			load_function('sendmail');
			if(send_mail($email,$subject,$message)===false) {
				MSG(L('邮件发送失败!'));
			}


			MSG('验证邮件已发送成功，请登录邮箱验证！',HTTP_REFERER);
		} else {
			$memberinfo = $this->memberinfo;
			include T('member', 'edit_email');
		}
	}
	/**
	 * 设置用户名
	 */
	public function set_username() {
		$memberinfo = $this->memberinfo;
		if(!$memberinfo['sys_name']) MSG('用户名已经设置成功！无需重复设置！');
		if(isset($GLOBALS['submit'])) {
			$username = strip_tags($GLOBALS['username']);
			$r = $this->db->get_one('member', array('username' => $username));
			if($r) {
				MSG('用户名已经被占用，请换其它用户名');
			}
			$this->db->update('member', array('username'=>$username,'sys_name'=>0), array('uid' => $this->uid));
			$r['username'] = $username;
			$this->create_cookie($r);
			MSG('用户名设置成功！','index.php?m=member');
		} else {

			include T('member', 'set_username');
		}
	}
	/**
	 * 会员首页框架
	 */
	public function main() {
		$memberinfo = $this->memberinfo;
		$groups = $this->groups;
		$auth_result = $this->db->get_list('member_auth', array('uid'=>$memberinfo['uid']), '*', 0, 20, 0,'','','type');
		include T('member', 'main');
	}

	/**
	 * 删除授权
	 */
	public function remove_auth() {
		$type = in_array($GLOBALS['type'], array('qq', 'sina', 'baidu','weixin')) ? $GLOBALS['type'] : MSG(L('auth_not_exist'));
		$r = $this->db->get_one('member_auth', array('uid' => $this->uid,'type'=>$type));
		if($r) {
			$this->db->delete('member_auth', array('authid' =>$r['authid']));
		}
		MSG('授权删除成功',HTTP_REFERER);
	}

	/**
	 * 绑定第三方授权
	 */
	public function bind_auth() {
		$type = in_array($GLOBALS['type'], array('qq', 'sina', 'baidu','weixin')) ? $GLOBALS['type'] : MSG(L('auth_not_exist'));

		$r = $this->db->get_one('member_auth', array('uid' => $this->uid,'type'=>$type));
		if($r) {
			MSG('已经授权成功',HTTP_REFERER);
		} else {
			load_function('curl');
			$auth = load_class('auth', M);
			$auth->bind_auth = $this->uid;
			$info = $auth->$type();
			if($info['uid']) {

			}
		}
		MSG('授权成功','index.php?m=member&f=index&v=main');
	}
}