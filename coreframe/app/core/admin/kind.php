<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 类别管理
 */
load_class('admin');

class kind extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 类别列表
	 */
	public function listing() {

		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$keyid = sql_replace($GLOBALS['keyid']);

		$where = array('keyid'=>$keyid);
		$result = $this->db->get_list('kind', $where, '*', 0, 20,$page);
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_formjs = 1;
		$show_dialog = 1;
		include $this->template('kind_listing');
	}
	/**
	 * 添加类别
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$keyid = sql_replace($GLOBALS['keyid']);
			$formdata = array();
			$formdata['keyid'] = $keyid;
			$formdata['name'] = $GLOBALS['name'];
			$formdata['remark'] = $GLOBALS['remark'];
			$this->db->insert('kind', $formdata);

			MSG(L('operation success'),HTTP_REFERER);
		}
	}
	/**
	 * 排序
	 */
	public function sort() {
		if(isset($GLOBALS['submit'])) {
			foreach($GLOBALS['sorts'] as $cid => $n) {
				$n = intval($n);
				$this->db->update('kind',array('sort'=>$n),array('kid'=>$cid));
			}
			MSG(L('operation success'),HTTP_REFERER);
		} else {
			MSG(L('operation failure'));
		}
	}
	/**
	 * 删除分类
	 */
	public function delete() {
		$kid = intval($GLOBALS['kid']);
		$this->db->delete('kind',array('kid'=>$kid));
		MSG(L('delete success'),HTTP_REFERER,1500);
	}

	/**
	 * 编辑
	 */
	public function edit() {
		$kid = intval($GLOBALS['kid']);
		if(isset($GLOBALS['submit'])) {
			$formdata = array();
			$formdata['name'] = $GLOBALS['name'];
			$formdata['remark'] = $GLOBALS['remark'];
			$this->db->update('kind', $formdata, array('kid' => $kid));
			MSG(L('operation_success').'<script>top.dialog.get(window).close().remove();</script>');
		} else {

			$set_iframe_url = 0;
			$show_formjs = 1;
			$show_dialog = 1;
			$data = $this->db->get_one('kind', array('kid' => $kid));
			include $this->template('kind_edit');
		}
	}
}