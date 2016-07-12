<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', M);
class invite extends WUZHI_foreground{
	function __construct() {
		$this->member = load_class('member', M);
		load_function('common', M);
		$this->setting = get_cache('setting', M);
		parent::__construct();
	}
	public function index(){
		$memberinfo = $this->memberinfo;
		$setting = $this->setting;
		$page = max(1, intval($GLOBALS['page']));
		$pages = '';
		$infos = array();
		$count = array('buy'=>0, 'free'=>0);
		$total = $this->db->count('member_invite', 'uid='.$memberinfo['uid']);
		if($total){
			//	得到用户当月已经生成的邀请码数量
			$count = $this->db->fetch_array($this->db->query('SELECT COUNT(`isbuy` = 1 or null) as buy, COUNT(`isbuy` = 0 or null) as free FROM `wz_member_invite` WHERE uid='.$memberinfo['uid'].' AND createtime >'.strtotime(date('Y-m-d'))));
			$resource = $this->db->query('SELECT m.username as usinguser, i.* FROM `wz_member_invite` i LEFT JOIN `wz_member` m ON m.`uid` = i.`usinguid` WHERE i.uid='.$memberinfo['uid']);
			while($r = $this->db->fetch_array($resource))$infos[] = $r;
			$pages = pages($total['num'], $page, 20);
		}
		$buynum = $setting['invitenum'][$memberinfo['groupid']]['buy'] - $count['buy'];
		$freenum = $setting['invitenum'][$memberinfo['groupid']]['free'] - $count['free'];
		include T('member','invite');
	}
	/**
	 * 生成邀请码
	 */
	public function create(){
		if(empty($this->setting['invite']))exit($GLOBALS['callback'].'({error:1, msg:"系统关闭了邀请注册"})');
		$count = $this->db->fetch_array($this->db->query('SELECT COUNT(`isbuy` = 1 or null) as buy, COUNT(`isbuy` = 0 or null) as free FROM `wz_member_invite` WHERE uid='.$this->memberinfo['uid'].' AND createtime >'.strtotime(date('Y-m-d'))));
		$isbuy = 0;
		if($count['free'] >= $this->setting['invitenum'][$this->memberinfo['groupid']]['free']){
			if($count['buy'] >= $this->setting['invitenum'][$this->memberinfo['groupid']]['buy']){
				exit($GLOBALS['callback'].'({error:1, msg:"您今日的名额已用完"})');
			}
			//	这里得调用支付接口 暂时空着
			$isbuy = 1;
		}
		load_function('preg_check');
		$invite = random_string('diy', 8, '23456789abcdefghjkmnpqrstuvwxyz');
		$this->db->insert('member_invite', array('uid'=>$this->memberinfo['uid'], 'isbuy'=>$isbuy, 'invite'=>$invite, 'createtime'=>SYS_TIME));
		exit($GLOBALS['callback'].'({error:0, msg:"'.$invite.'"})');
	}
}