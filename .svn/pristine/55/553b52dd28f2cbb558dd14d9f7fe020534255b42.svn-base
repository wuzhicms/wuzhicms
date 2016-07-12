<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');
class friend extends WUZHI_admin {
	private $db, $member;
	function __construct() {
		$this->member = load_class('member', M);
		$this->db = load_class('db');
		$this->group = get_cache('group', M);
		$this->model = $this->db->get_list('model', '`m`="member"', 'modelid,name,attr_table', 0, 200, 0, '', '', 'modelid');
		$this->setting = get_cache('setting', 'member');
	}
	/**
	 * 推荐的用户
	 */
	public function listing() {
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$uid = $this->memberinfo['uid'];
		$categorys = get_cache('category','content');
		$publisher = $this->memberinfo['username'];

		$result_rs = $this->db->get_list('friend_elite', "`cityid` IN (0)", '*', 0, 20,$page,'id DESC');
		$result = array();
		foreach($result_rs as $r) {
			$r['member_info']=$this->db->get_one('member',array('uid'=>$r['uid']));
			$v1=$this->db->get_one('myfriend',array('myuid'=>$r['uid'],'uid'=>$uid));
			$v2=$this->db->get_one('myfriend',array('myuid'=>$uid,'uid'=>$r['uid']));
			if($v2 && $v1) {
				//相互关注
				$r['rtype']=1;
			} elseif($v2) {
				$r['rtype']=2;//已添加
			} elseif($v1) {
				$r['rtype']=3;//请求添加
			}
			$result[] = $r;
		}
		$pages = $this->db->pages;
		$total = $this->db->number;
		include $this->template('friend_listing');
	}
	/**
	 * 添加推荐用户
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$username = sql_replace($GLOBALS['username']);
			$r = $this->db->get_one('member', array('username' => $username));
			if(!$r) MSG('用户不存在');
			$formdata = array();
			$formdata['cityid'] = intval($GLOBALS['cityid']);
			$formdata['uid'] = $r['uid'];
			$this->db->insert('friend_elite', $formdata);

			MSG(L('operation_success'),'?m=member&f=friend&v=listing'.$this->su());
		} else {
			$group = $this->group;
			$form = load_class('form');
			$where = array('modelid'=>3);
			$categorys = $this->db->get_list('category', $where, '*', 0, 2000, 0, '', '', 'cid');
			$show_formjs = 1;
			include $this->template('friend_add');
		}
	}

	/**
	 * 删除用户
	 */
	public function delete() {
		$id = intval($GLOBALS['id']);
		$this->db->delete('friend_elite',array('id'=>$id));
		MSG('删除成功',HTTP_REFERER);
	}
}