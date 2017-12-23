<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_member {
	public function __construct() {
		load_function('preg_check');
		load_function('common', 'member');
		$this->db = load_class('db');
		$this->setting = get_cache('setting', 'member');
	}
	/**
	 * 添加用户
	 * @param	array	$data
	 * @return	boolean or int
	 */
	public function add($data){
		if(!is_array($data))return false;
		$master_data = array();

		$master_data['username'] = $this->check_user($data['username']) ? $data['username'] : MSG(L('user_exist', '', 'member'));
		$master_data['modelid'] = isset($data['modelid']) ? $data['modelid'] : '';
		$master_data['groupid'] = $data['groupid'];
		//	判断邀请码
		if(isset($data['invite'])){
			if(!$this->check_invite($data['invite']))MSG(L('invite_error', '', 'member'));
		}
		//	判断Email格式
		//if(!$this->check_email($data['email']))MSG(L('email_exist', '', 'member'));
		$master_data['email'] =  $data['email'];
		//	判断 Mobile是否有效
		$master_data['mobile'] = isset($data['mobile']) && $data['mobile'] ? ($this->check_mobile($data['mobile']) ? $data['mobile'] : MSG(L('mobile_exist', '', 'member'))) : '';
		//	判断是否有更改密码且两次的密码是否一致
		if(empty($data['password']))MSG(L('password_empty', '', 'member'));
		if($data['password'] != $data['pwdconfirm'])MSG(L('password_not_identical', '', 'member'));
		$master_data['factor'] = random_string('diy', 6);
		$master_data['password'] = md5(md5($data['password']).$master_data['factor']);

		if(isset($data['locktime'])){
			$master_data['locktime'] = strtotime($data['locktime']);
			$master_data['islock'] = $master_data['locktime'] > SYS_TIME ? 1 : 0;
		}
		if(isset($data['viptime'])){
			$master_data['viptime'] = strtotime($data['viptime']);
			$master_data['vip'] = $master_data['viptime'] > SYS_TIME ? 1 : 0;
		}
		$master_data['regip'] = get_ip();
		$master_data['regtime'] = SYS_TIME;
		$master_data['points'] = $data['points'];
		$master_data['companyname'] = isset($data['companyname']) ? $data['companyname'] : '';
		$master_data['truename'] = sql_replace($data['truename']);
		$master_data['sex'] = intval($data['sex']);
		$master_data['birthday'] = sql_replace($data['birthday']);
		$master_data['marriage'] = intval($data['marriage']);

		$master_data['ischeck_email'] = isset($data['ischeck_email']) ? $data['ischeck_email'] : 0;
		$master_data['ischeck_mobile'] = isset($data['ischeck_mobile']) ? intval($data['ischeck_mobile']) : 0;
		$master_data['pw_reset'] = 0;

		$uid = $this->db->insert('member', $master_data, true);
		if($uid){
			return $uid;
		}else{
			return false;
		}
	}
	/**
	 * 编辑用户
	 * @param	array	$data
	 * @param	int		$uid
	 * @return	boolean
	 */
	public function edit($data, $uid){
		if(empty($uid) || !is_array($data))return false;
		$master_data = array();
		$r = $this->db->get_one('member', array('username' => $data['username']),'uid');
		if($r && $r['uid']!=$uid) MSG(L('user_exist', '', 'member'));
		$master_data['username'] = $data['username'];
		$master_data['truename'] = sql_replace($data['truename']);
		$master_data['modelid'] = $data['modelid'];
		$master_data['groupid'] = (int)$data['groupid'];
		if(!$master_data['groupid']) $master_data['groupid'] = 3;
		//	判断Email格式
		if(!is_email($data['email']))MSG(L('email_format_error', '', 'member'));
		//	判断是否有更改密码且两次的密码是否一致
		if(isset($data['password']) && $data['password'] != ''){
			if($data['password'] == $data['pwdconfirm']){
				$master_data['password'] = md5(md5($data['password']).$data['factor']);
			}else{
				MSG(L('password_not_identical', '', 'member'));
			}
		}

		//	判断Email 和 Mobile是否有效
		$master_data['email'] = $this->check_email($data['email'], $uid) ? $data['email'] : MSG(L('email_exist', 'member'));
		$master_data['mobile'] = isset($data['mobile']) && $data['mobile'] ? ($this->check_mobile($data['mobile'], $uid) ? $data['mobile'] : MSG(L('mobile_exist', '', 'member'))) : '';

		$master_data['locktime'] = strtotime($data['locktime']);
		$master_data['islock'] = $master_data['locktime'] > SYS_TIME ? 1 : 0;
		$master_data['viptime'] = strtotime($data['viptime']);
		$master_data['sex'] = intval($data['sex']);
		$master_data['birthday'] = sql_replace($data['birthday']);
		$master_data['marriage'] = intval($data['marriage']);
		$master_data['vip'] = $master_data['viptime'] > SYS_TIME ? 1 : 0;
		if(isset($master_data['password']))$this->password($uid, $data['username'], $master_data['email'], $data['password']);
		return $this->db->update('member', $master_data, '`uid`='.$uid);
	}
	/**
	 * 
	 * 检查用户名是否可用
	 * @param string $username	要验证的用户名
	 * @param int $return	返回的数据格式
	 * @return boolean or json
	 */
	public function check_user($username, $return = 0){
		if(empty($username) || !preg_match('/^[a-z0-9\x7f-\xff\-]{4,20}$/i', $username, $r))return $return ? '{"info":"用户名需要4-20位字符","status":"n"}' : false;
		$data = $this->db->get_one('member', '`username` = "'.$username.'"', 'uid');
		return empty($data) ? ($return ? '{"info":"'.L('check_ok', '', 'member').'","status":"y"}' : true): ($return ? '{"info":"'.L('user_exist', '', 'member').'","status":"n"}' : false);
	}
	/**
	 * 
	 * 检查手机号码是否正确
	 * @param int $mobile	要验证的手机号码
	 * @param int $uid		用户id
	 * @param int $return	返回的数据格式
	 * @return boolean or json
	 */
	public function check_mobile($mobile, $uid = 0, $return = 0){
		if(empty($mobile) || !is_mobile($mobile))return $return ? '{"status":"n"}' : false;
		$uid = (int)$uid;
		$data = $this->db->get_one('member', '`mobile` = "'.$mobile.'"'.($uid ? ' AND `uid` != '.$uid : ''), 'uid');
		return empty($data) ? ($return ? '{"info":"'.L('check_ok', '', 'member').'","status":"y"}' : true): ($return ? '{"info":"'.L('mobile_exist', '', 'member').'","status":"n"}' : false);
	}
	/**
	 * 
	 * 检查邮箱是否正确
	 * @param int $email	要验证的邮箱
	 * @param int $uid		用户id
	 * @param int $return	返回的数据格式
	 * @return boolean or json
	 */
	public function check_email($email, $uid = 0, $return = 0){
		if(empty($email) || !is_email($email))return $return ? '{"info":"'.L('parameters_error', '', 'member').'","status":"n"}' : false;
		$uid = (int)$uid;
		$data = $this->db->get_one('member', '`email` = "'.$email.'"'.($uid ? ' AND `uid` != '.$uid : ''), 'uid');
		return empty($data) ? ($return ? '{"info":"'.L('check_ok', '', 'member').'","status":"y"}' : true) : ($return ? '{"info":"'.L('email_exist', '', 'member').'","status":"n"}' : false);
	}
	/**
	 * 
	 * 检查邀请码是否合法
	 * @param int $invite	要验证的邀请码
	 * @param int $return	返回的数据格式
	 * @return boolean or json
	 */
	public function check_invite($invite, $return = 0){
		if(empty($invite) || strlen($invite) != 8 || !preg_match('/^[0-9a-z]{8}$/i', $invite))return $return ? '{"info":"'.L('parameters_error', '', 'member').'","status":"n"}' : false;
		$data = $this->db->get_one('member_invite', '`invite` = "'.$invite.'"', 'usinguid');
		return empty($data) || $data['usinguid'] ? ($return ? '{"info":"'.L('invite_exist', '', 'member').'","status":"n"}' : false) : ($return ? '{"info":"'.L('check_ok', '', 'member').'","status":"y"}' : true);
	}
	/**
	 * 更改用户密码并且发送邮件
	 * @param	int	$uid	要更改的用户
	 * @param	string	$email		用户Email
	 * @param	string	$password	密码  若为空则为随机分配(如果传递了此参数，本函数只给用户发送邮件不会实际去更改数据库里面的密码)
	 * @return	boolean		
	 */
	public function password($uid, $username, $email, $password=''){
		$uid = (int)$uid;
		//	如果没有password 参数说明是前台重置
		if(empty($password)){
			$password = random_string('diy', 8, '23456789abcdefghjkmnpqrstuvwxyz');
			$factor = random_string('diy', 6);
			$this->db->update('member', array('factor'=>$factor, 'password'=>md5(md5($password).$factor),'islock'=>0,'pw_reset'=>1), '`uid`='.$uid);
		}
		if($this->setting['ucenter']){
			$ucenter = load_class('ucenter', 'member');
			$ucenter->uc_user_edit($username, '', $password, '', true);
		}
		//	获取模版
		ob_start();
		include T('member', 'mail_setpassword');
		$template = ob_get_contents();
		ob_clean();
		//	发送Email
		load_function('sendmail');
		$fs = send_mail($email,L('set_password_email_title', '', 'member'),$template);

		return true;
	}
	/**
	 * 更改用户名
	 * @param	int 	$uid		要改变的uid
	 * @param	string	$oldname	旧的用户名
	 * * @param	string	$newname	新的用户名
	 * @return	boolean
	 */
	public function renameuser($uid, $oldname, $newname){
		$r = $this->db->get_one('member', "username='$oldname'", 'uid');
		if($r && $this->check_user($newname)){
			return $this->db->update('member', array('username'=>$newname, 'ucuid'=>$uid), '`uid`='.$r['uid']);
		}else{
			return false;
		}
	}
}