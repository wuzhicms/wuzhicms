<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_ucenter {
	public function __construct() {
		load_function('common', 'member');
		$this->db = load_class('db');
		$this->setting = get_cache('setting', 'member');

		define('UC_API', $this->setting['uc_api']) ;
		define('UC_IP', $this->setting['uc_ip']) ;
		define('UC_APPID', $this->setting['uc_appid']) ;
		define('UC_KEY', $this->setting['uc_key']) ;
		define('UC_DBHOST', $this->setting['uc_dbhost']) ;
		define('UC_DBUSER', $this->setting['uc_dbuser']) ;
		define('UC_DBPW', $this->setting['uc_dbpw']) ;
		define('UC_DBNAME', $this->setting['uc_dbname']) ;
		define('UC_DBPRE', $this->setting['uc_dbtablepre']) ;
		define('UC_DBTABLEPRE', $this->setting['uc_dbtablepre']);
    	define('UC_DBCHARSET', $this->setting['uc_dbcharset']); 
		define('UC_CONNECT', 'mysql');
		define('UC_DBCONNECT',0);
		define('API_RETURN_SUCCEED', 1);
		define('API_UPDATECREDIT', 1);
		define('API_GETCREDITSETTINGS', 1);
		define('API_UPDATECREDITSETTINGS', 1);
	
	}
	/**
	 * 用户登录
	 * @param	string	$username
	 * @param	string	$password
	 * @param	array	$user
	 * @return	string	$synlogin
	 */
	public function login($username, $password, &$user = array()){
		list($ucuid, $uc_username, $uc_password, $email) =  $this->uc_call("uc_user_login", array($username, $password));
		//	导入用户到UC数据库
		if($ucuid == '-1' && is_array($user) && $user){
			//	生成临时密码用于比对密码是否正确
			$password_t = md5(md5($password).$user['factor']);
			if($user['password'] == $password_t){
				$ucuid = $this->uc_call("uc_user_register", array($user['username'], $password, $user['email']));
				if($ucuid <= 0)MSG(L('user_not_exist'));
			}
			//	再一次调取UC的信息
			list($ucuid, $uc_username, $uc_password, $email) =  $this->uc_call("uc_user_login", array($username, $password));
		}
		if($ucuid == '-1')MSG(L('user_not_exist'));
		if($ucuid == '-2')MSG(L('password_error'), HTTP_REFERER);
		$synlogin = $this->uc_call('uc_user_synlogin', array($ucuid));
		//	同步数据到WZ
		if(!is_array($user) || empty($user)){
			$user = $this->db->get_one('member', '`username` = "'.$username.'"', '*');
			if(empty($user)){
				load_function('preg_check');
				if(strtolower(UC_DBCHARSET) != strtolower(CHARSET))$username = iconv(UC_DBCHARSET, CHARSET.'//IGNORE', $username);
				$user['username'] = $username;
				$user['email'] = $email;
				$user['factor'] = random_string('diy', 6);
				$user['password'] = md5(md5($password).$user['factor']);
				$user['ucuid'] = $ucuid;
				$user['modelid'] = '';
				$user['uid'] = $this->db->insert('member', $user, true);
			}
		}
		if($user['ucuid'] != $ucuid){
			$this->db->update('member', 'ucuid='.$ucuid, 'uid='.$user['uid']);
		}
		return $synlogin;
	}
	/**
	 * 用户退出
	 * @return	string	$ucsynlogout
	 */
	public function logout(){
		return $this->uc_call('uc_user_synlogout', array());
	}

	/**
	 * 删除用户
	 * @param int $ucuid
	 */
	public function delete($ucuid){
		return $this->uc_call('uc_user_delete', array($ucuid));
	}

	/**
	 * 用户注册
	 * @return	int	$ucuid
	 */
	public function register($user){
		$ucuid = $this->uc_call('uc_user_register', $user);
		if($ucuid <= 0){
			switch ($ucuid){
				case -1:
					MSG(L('uc_error_1'));
					break;
				case -2:
					MSG(L('uc_error_2'));
					break;
				case -3:
					MSG(L('uc_error_3'));
					break;
				case -4:
					MSG(L('uc_error_4'));
					break;
				case -5:
					MSG(L('uc_error_5'));
					break;
				case -6:
					MSG(L('uc_error_6'));
					break;
				default:
					MSG(L('uc_error_7'));
			}
		}
		return $ucuid;
	}
	/**
	*  修改用户信息
	*/
	public function uc_user_edit($username, $oldpw, $newpw, $email, $ignoreoldpw = 0, $questionid = '', $answer = ''){
		return $this->uc_call('uc_user_edit', array($username, $oldpw, $newpw, $email, $ignoreoldpw, $questionid, $answer));
	}
	final function uc_call($func, $params=null){
		if (!function_exists($func)){
			include_once(WWW_ROOT.'api/uc_client/client.php');
		}
		$res = call_user_func_array($func, $params);
		return $res;
	}
}