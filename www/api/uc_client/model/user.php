<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: user.php 1178 2014-11-03 07:05:21Z hypowang $
*/

!defined('IN_UC') && exit('Access Denied');

class usermodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->usermodel($base);
	}

	function usermodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get_user_by_uid($uid) {
		$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."members WHERE uid='$uid'");
		return $arr;
	}

	function get_user_by_username($username) {
		$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."members WHERE username='$username'");
		return $arr;
	}

	function get_user_by_email($email) {
		$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."members WHERE email='$email'");
		return $arr;
	}

	function get_user_by_sms($sms) {
		$arr = $this->db->fetch_first("SELECT * FROM ".UC_DBTABLEPRE."members WHERE sms='$sms'");
		return $arr;
	}

	function check_username($username) {
		$guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
		$len = $this->dstrlen($username);
		if($len > 15 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function dstrlen($str) {
		if(strtolower(UC_CHARSET) != 'utf-8') {
			return strlen($str);
		}
		$count = 0;
		for($i = 0; $i < strlen($str); $i++){
			$value = ord($str[$i]);
			if($value > 127) {
				$count++;
				if($value >= 192 && $value <= 223) $i++;
				elseif($value >= 224 && $value <= 239) $i = $i + 2;
				elseif($value >= 240 && $value <= 247) $i = $i + 3;
		    	}
	    		$count++;
		}
		return $count;
	}

	function check_mergeuser($username) {
		$data = $this->db->result_first("SELECT count(*) FROM ".UC_DBTABLEPRE."mergemembers WHERE appid='".$this->base->app['appid']."' AND username='$username'");
		return $data;
	}

	function check_usernamecensor($username) {
		$_CACHE['badwords'] = $this->base->cache('badwords');
		$censorusername = $this->base->get_setting('censorusername');
		$censorusername = $censorusername['censorusername'];
		$censorexp = '/^('.str_replace(array('\\*', "\r\n", ' '), array('.*', '|', ''), preg_quote(($censorusername = trim($censorusername)), '/')).')$/i';
		$usernamereplaced = isset($_CACHE['badwords']['findpattern']) && !empty($_CACHE['badwords']['findpattern']) ? @preg_replace($_CACHE['badwords']['findpattern'], $_CACHE['badwords']['replace'], $username) : $username;
		if(($usernamereplaced != $username) || ($censorusername && preg_match($censorexp, $username))) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function check_usernameexists($username) {
		$data = $this->db->result_first("SELECT username FROM ".UC_DBTABLEPRE."members WHERE username='$username'");
		return $data;
	}

	function check_emailformat($email) {
		return strlen($email) > 6 && strlen($email) <= 32 && preg_match("/^([a-z0-9\-_.+]+)@([a-z0-9\-]+[.][a-z0-9\-.]+)$/", $email);
	}

	function check_smsformat($sms) {
		return strlen($sms) == 11 && preg_match("/^1\d{10}$/", $sms);
	}

	function check_emailaccess($email) {
		$setting = $this->base->get_setting(array('accessemail', 'censoremail'));
		$accessemail = $setting['accessemail'];
		$censoremail = $setting['censoremail'];
		$accessexp = '/('.str_replace("\r\n", '|', preg_quote(trim($accessemail), '/')).')$/i';
		$censorexp = '/('.str_replace("\r\n", '|', preg_quote(trim($censoremail), '/')).')$/i';
		if($accessemail || $censoremail) {
			if(($accessemail && !preg_match($accessexp, $email)) || ($censoremail && preg_match($censorexp, $email))) {
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return TRUE;
		}
	}

	function check_emailexists($email, $username = '') {
		$sqladd = $username !== '' ? "AND username<>'$username'" : '';
		$email = $this->db->result_first("SELECT email FROM  ".UC_DBTABLEPRE."members WHERE email='$email' $sqladd");
		return $email;
	}

	function check_smsexists($sms, $username = '') {
		$sqladd = $username !== '' ? "AND username<>'$username'" : '';
		$sms = $this->db->result_first("SELECT email FROM  ".UC_DBTABLEPRE."members WHERE sms='$sms' $sqladd");
		return $sms;
	}

	function check_login($username, $password, &$user) {
		$user = $this->get_user_by_username($username);
		if(empty($user['username'])) {
			return -1;
		} elseif($user['password'] != md5(md5($password).$user['salt'])) {
			return -2;
		}
		return $user['uid'];
	}

	function add_user($username, $password, $email, $uid = 0, $questionid = '', $answer = '', $regip = '') {
		return $this->add_user_new($username, $password, $email, null, $uid, $questionid, $answer, $regip);
	}

	function add_user_new($username, $password, $email, $sms, $uid = 0, $questionid = '', $answer = '', $regip = '') {

		$regip = empty($regip) ? $this->base->onlineip : $regip;
		$salt = substr(uniqid(rand()), -6);
		$password = md5(md5($password).$salt);
		$sqladd = $uid ? "uid='".intval($uid)."'," : '';
		$sqladd .= $questionid > 0 ? " secques='".$this->quescrypt($questionid, $answer)."'," : " secques='',";
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."members SET $sqladd username='$username', password='$password', email='$email', sms='$sms', regip='$regip', regdate='".$this->base->time."', salt='$salt'");
		$uid = $this->db->insert_id();
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."memberfields SET uid='$uid'");
		// BEGIN 同步激活论坛
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member SET uid='$uid', username='$username', password='$password', email='$email', adminid='0', groupid='10', regdate='".$this->base->time."', credits='0', timeoffset='9999'");
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member_status SET uid='$uid', regip='$regip', lastip='$regip', lastvisit='".$this->base->time."', lastactivity='".$this->base->time."', lastpost='0', lastsendmail='0'");
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member_profile SET uid='$uid'");
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member_field_forum SET uid='$uid'");
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member_field_home SET uid='$uid'");
		$this->db->query("INSERT INTO ".DISCUZ_DBTABLEPRE."common_member_count SET uid='$uid', extcredits1='0', extcredits2='0', extcredits3='0', extcredits4='0', extcredits5='0', extcredits6='0', extcredits7='0', extcredits8='0'");

		// END
		return $uid;
	}


	function edit_user($username, $oldpw, $newpw, $email, $ignoreoldpw = 0, $questionid = '', $answer = '') {
		return $this->edit_user_new($username, $oldpw, $newpw, $email, null, $ignoreoldpw, $questionid, $answer);
	}

	function edit_user_new($username, $oldpw, $newpw, $email, $sms, $ignoreoldpw = 0, $questionid = '', $answer = '') {
		$data = $this->db->fetch_first("SELECT username, uid, password, salt FROM ".UC_DBTABLEPRE."members WHERE username='$username'");

		if($ignoreoldpw) {
			$isprotected = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."protectedmembers WHERE uid = '$data[uid]'");
			if($isprotected) {
				return -10;
			}
		}

		if(!$ignoreoldpw && $data['password'] != md5(md5($oldpw).$data['salt'])) {
			return -1;
		}

		$sqladd = $newpw ? "password='".md5(md5($newpw).$data['salt'])."'" : '';
		$sqladd .= $email ? ($sqladd ? ',' : '')." email='$email'" : '';
		$sqladd .= $sms ? ($sqladd ? ',' : '')." sms='$sms'" : '';
		if($questionid !== '') {
			if($questionid > 0) {
				$sqladd .= ($sqladd ? ',' : '')." secques='".$this->quescrypt($questionid, $answer)."'";
			} else {
				$sqladd .= ($sqladd ? ',' : '')." secques=''";
			}
		}
		if($sqladd) {
			$this->db->query("UPDATE ".UC_DBTABLEPRE."members SET $sqladd WHERE username='$username'");
			return $this->db->affected_rows();
		} else {
			return -9;
		}
	}

	function delete_user($uidsarr) {
		$uidsarr = (array)$uidsarr;
		if(!$uidsarr) {
			return 0;
		}
		$uids = $this->base->implode($uidsarr);
		$arr = $this->db->fetch_all("SELECT uid FROM ".UC_DBTABLEPRE."protectedmembers WHERE uid IN ($uids)");
		$puids = array();
		foreach((array)$arr as $member) {
			$puids[] = $member['uid'];
		}
		$uids = $this->base->implode(array_diff($uidsarr, $puids));
		if($uids) {
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."members WHERE uid IN($uids)");
			$this->db->query("DELETE FROM ".UC_DBTABLEPRE."memberfields WHERE uid IN($uids)");
			uc_user_deleteavatar($uidsarr);
			$this->base->load('note');
			$_ENV['note']->add('deleteuser', "ids=$uids");
			return $this->db->affected_rows();
		} else {
			return 0;
		}
	}

	function get_total_num($sqladd = '') {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."members $sqladd");
		return $data;
	}

	function get_list($page, $ppp, $totalnum, $sqladd) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."members $sqladd LIMIT $start, $ppp");
		return $data;
	}

	function name2id($usernamesarr) {
		$usernamesarr = uc_addslashes($usernamesarr, 1, TRUE);
		$usernames = $this->base->implode($usernamesarr);
		$query = $this->db->query("SELECT uid FROM ".UC_DBTABLEPRE."members WHERE username IN($usernames)");
		$arr = array();
		while($user = $this->db->fetch_array($query)) {
			$arr[] = $user['uid'];
		}
		return $arr;
	}

	function id2name($uidarr) {
		$arr = array();
		$query = $this->db->query("SELECT uid, username FROM ".UC_DBTABLEPRE."members WHERE uid IN (".$this->base->implode($uidarr).")");
		while($user = $this->db->fetch_array($query)) {
			$arr[$user['uid']] = $user['username'];
		}
		return $arr;
	}

	function quescrypt($questionid, $answer) {
		return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
	}

	function can_do_login($username, $ip = '') {

		$check_times = $this->base->settings['login_failedtime'] < 1 ? 5 : $this->base->settings['login_failedtime'];

		$username = substr(md5($username), 8, 15);
		$expire = 15 * 60;
		if(!$ip) {
			$ip = $this->base->onlineip;
		}

		$ip_check = $user_check = array();
		$query = $this->db->query("SELECT * FROM ".UC_DBTABLEPRE."failedlogins WHERE ip='".$ip."' OR ip='$username'");
		while($row = $this->db->fetch_array($query)) {
			if($row['ip'] === $username) {
				$user_check = $row;
			} elseif($row['ip'] === $ip) {
				$ip_check = $row;
			}
		}

		if(empty($ip_check) || ($this->base->time - $ip_check['lastupdate'] > $expire)) {
			$ip_check = array();
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."failedlogins (ip, count, lastupdate) VALUES ('{$ip}', '0', '{$this->base->time}')");
		}

		if(empty($user_check) || ($this->base->time - $user_check['lastupdate'] > $expire)) {
			$user_check = array();
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."failedlogins (ip, count, lastupdate) VALUES ('{$username}', '0', '{$this->base->time}')");
		}

		if ($ip_check || $user_check) {
			$time_left = min(($check_times - $ip_check['count']), ($check_times - $user_check['count']));
			return $time_left;

		}

		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."failedlogins WHERE lastupdate<".($this->base->time - ($expire + 1)), 'UNBUFFERED');

		return $check_times;
	}

	function loginfailed($username, $ip = '') {
		$username = substr(md5($username), 8, 15);
		if(!$ip) {
			$ip = $this->base->onlineip;
		}
		$this->db->query("UPDATE ".UC_DBTABLEPRE."failedlogins SET count=count+1, lastupdate='".$this->base->time."' WHERE ip='".$ip."' OR ip='$username'");
	}

}