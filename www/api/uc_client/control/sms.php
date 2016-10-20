<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: sms.php 1059 2011-03-01 07:25:09Z pmonkey_w $
*/

!defined('IN_UC') && exit('Access Denied');

class smscontrol extends base {

	function __construct() {
		$this->smscontrol();
	}

	function smscontrol() {
		parent::__construct();
		$this->init_input();
	}

	function onadd() {
		$this->load('sms');
		$sms = array();
		$sms['appid']		= $this->app['appid'];
		$sms['uids']		= explode(',', $this->input('uids'));
		$sms['smses']		= explode(',', $this->input('smses'));
		$sms['message']	= $this->input('message');
		$sms['charset']	= $this->input('charset');
		$sms['level']		= abs(intval($this->input('level')));
		$sms['dateline']	= $this->time;
		return $_ENV['sms']->add($sms);
	}
}

?>