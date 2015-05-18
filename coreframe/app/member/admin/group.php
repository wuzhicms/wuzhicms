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
class group extends WUZHI_admin {
	private $db, $group;
	function __construct() {
		$this->group = load_class('group', M);
		$this->db = load_class('db');
	}
	/**
	 * 后台用户组列表
	 */
	public function listing() {
		$page = max(1, (isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1));
		$result = $this->db->get_list('member_group', '', '*', 0, 20, $page, 'sort ASC, groupid ASC');
		$pages = $this->db->pages;
		include $this->template('group_listing', M);
	}
	/**
	 * 添加
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			if(!$this->group->add($GLOBALS['info']))MSG(L('operation_failure'));
			$this->group->set_cache();
			MSG(L('operation_success'));
		} else {
			include $this->template('group_add', M);
		}
	}
	/**
	 * 编辑
	 */
	public function edit() {
		$groupid = (int)$GLOBALS['groupid'];
		if(isset($GLOBALS['submit'])) {
			if(!$this->group->edit($GLOBALS['info'], $groupid))MSG(L('operation_failure'));
			$this->group->set_cache();
			MSG(L('operation_success').'<script>$("#g_'.$groupid.' td", top.window.frames["iframeid"].document).css("background-color", "#EFD04C");top.dialog.get(window).close().remove();</script>');
		} else {
			if($groupid)$group = $this->db->get_one('member_group', '`groupid`='.$groupid, '*');
			if(empty($group))MSG(L('not_exists'));
			include $this->template('group_edit', M);
		}
	}
	/**
	 * 删除
	 */
	public function del() {
		if(isset($GLOBALS['groupid']) && $GLOBALS['groupid']) {
			$where = is_array($GLOBALS['groupid']) ? ' IN ('.implode(',', $GLOBALS['groupid']).')' : ' = '.$GLOBALS['groupid'];
			$this->db->delete('member_group', 'issystem != 1 AND groupid'.$where);
			$this->group->set_cache();
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":1})';
			}else{
				MSG(L('operation_success'));
			}
		}else{
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":0})';
			}else{
				MSG(L('operation_failure'));
			}
		}
	}
	/**
	 * 排序
	 */
	public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('member_group',array('sort'=>$n),array('groupid'=>$cid));
            }
            $this->group->set_cache();
            MSG(L('operation_success'), HTTP_REFERER);
        } else {
            MSG(L('operation_failure'));
        }
	}
	/**
	 * 验证用户组名
	 */
	public function check_name() {
		$name = isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : (isset($GLOBALS['name']) && $GLOBALS['name'] ? $GLOBALS['name'] : false);
		if(strtolower(CHARSET) != 'utf-8')$name = iconv('UTF-8', 'gb2312//IGNORE', $name);
		$groupid = isset($GLOBALS['groupid']) ? (int)$GLOBALS['groupid'] : 0;
		echo $this->group->check_name($name, $groupid, 1);
	}
}