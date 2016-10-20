<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: sms.php 1139 2012-05-08 09:02:11Z pmonkey_w $
*/

!defined('IN_UC') && exit('Access Denied');

define('UC_MAIL_REPEAT', 5);

class smsmodel {

	var $db;
	var $base;
	var $apps;

	function __construct(&$base) {
		$this->smsmodel($base);
	}

	function smsmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
		$this->apps = &$this->base->cache['apps'];
	}

	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."smsqueue");
		return $data;
	}

	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT m.*, u.username, u.sms FROM ".UC_DBTABLEPRE."smsqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid ORDER BY dateline DESC LIMIT $start, $ppp");
		foreach((array)$data as $k => $v) {
			$data[$k]['message'] = dhtmlspecialchars($v['message']);
			$data[$k]['tosms'] = empty($v['tosms']) ? $v['sms'] : $v['tosms'];
			$data[$k]['dateline'] = $v['dateline'] ? $this->base->date($data[$k]['dateline']) : '';
			$data[$k]['appname'] = $this->base->cache['apps'][$v['appid']]['name'];
		}
		return $data;
	}

	function delete_sms($ids) {
		$ids = $this->base->implode($ids);
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."smsqueue WHERE smsid IN ($ids)");
		return $this->db->affected_rows();
	}

	function add($sms) {
		if($sms['level']) {
			$sql = "INSERT INTO ".UC_DBTABLEPRE."smsqueue (touid, tosms, message, charset, level, dateline, failures, appid) VALUES ";
			$values_arr = array();
			foreach($sms['uids'] as $uid) {
				if(empty($uid)) continue;
				$values_arr[] = "('$uid', '', '$sms[message]', '$sms[charset]', '$sms[level]', '$sms[dateline]', '0', '$sms[appid]')";
			}
			foreach($sms['smses'] as $sms) {
				if(empty($sms)) continue;
				$values_arr[] = "('', '$sms', '$sms[message]', '$sms[charset]', '$sms[level]', '$sms[dateline]', '0', '$sms[appid]')";
			}
			$sql .= implode(',', $values_arr);
			$this->db->query($sql);
			$insert_id = $this->db->insert_id();
			$insert_id && $this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='smsexists', value='1'");
			return $insert_id;
		} else {
			$sms['sms_to'] = array();
			$uids = 0;
			foreach($sms['uids'] as $uid) {
				if(empty($uid)) continue;
				$uids .= ','.$uid;
			}
			$users = $this->db->fetch_all("SELECT uid, username, sms FROM ".UC_DBTABLEPRE."members WHERE uid IN ($uids)");
			foreach($users as $v) {
				$sms['sms_to'][] = $v['sms'];
			}
			foreach($sms['smses'] as $sms) {
				if(empty($sms)) continue;
				$sms['sms_to'][] = $sms;
			}
			$sms['message'] = str_replace('\"', '"', $sms['message']);
			$sms['sms_to'] = implode(',', $sms['sms_to']);
			return $this->send_one_sms($sms);
		}
	}

	function send() {
		register_shutdown_function(array($this, '_send'));
	}

	function _send() {

		$sms = $this->_get_sms();
		if(empty($sms)) {
			$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."vars SET name='smsexists', value='0'");
			return NULL;
		} else {
			$sms['sms_to'] = $sms['tosms'] ? $sms['tosms'] : $sms['sms'];
			if($this->send_one_sms($sms)) {
				$this->_delete_one_sms($sms['smsid']);
				return true;
			} else {
				$this->_update_failures($sms['smsid']);
				return false;
			}
		}

	}

	function send_by_id($smsid) {
		if ($this->send_one_sms($this->_get_sms_by_id($smsid))) {
			$this->_delete_one_sms($smsid);
			return true;
		}
	}

	function send_one_sms($sms) {
		if(empty($sms)) return;
		$sms['sms_to'] = $sms['sms_to'] ? $sms['sms_to'] : $sms['sms'];
		$sms_setting = $this->base->settings;
		return include UC_ROOT.'lib/sendsms.inc.php';
	}

	function _get_sms() {
		$data = $this->db->fetch_first("SELECT m.*, u.username, u.sms FROM ".UC_DBTABLEPRE."smsqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid WHERE failures<'".UC_MAIL_REPEAT."' ORDER BY level DESC, smsid ASC LIMIT 1");
		return $data;
	}

	function _get_sms_by_id($smsid) {
		$data = $this->db->fetch_first("SELECT m.*, u.username, u.sms FROM ".UC_DBTABLEPRE."smsqueue m LEFT JOIN ".UC_DBTABLEPRE."members u ON m.touid=u.uid WHERE smsid='$smsid'");
		return $data;
	}

	function _delete_one_sms($smsid) {
		$smsid = intval($smsid);
		return $this->db->query("DELETE FROM ".UC_DBTABLEPRE."mailqueue WHERE smsid='$smsid'");
	}

	function _update_failures($smsid) {
		$smsid = intval($smsid);
		return $this->db->query("UPDATE ".UC_DBTABLEPRE."smsqueue SET failures=failures+1 WHERE smsid='$smsid'");
	}
}

?>