<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 绩效管理
 */
load_class('admin');
class set extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 策略列表
     */
    public function listing() {
        $cardid = intval($GLOBALS['cardid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('credit_set', '', '*', 0, 20,$page,'csid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('set_listing');
    }
	/**
	 * 操作记录
	 */
	public function recordlist() {
		$cardid = intval($GLOBALS['cardid']);
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$result = $this->db->get_list('credit', '', '*', 0, 20,$page,'jid DESC');
		$pages = $this->db->pages;
		$total = $this->db->number;
		include $this->template('set_recordlist');
	}
	/**
	 * 添加规则
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$formdata = array();
			$formdata['name'] =  $GLOBALS['name'];
			$formdata['action'] = $GLOBALS['action'];
			$formdata['point'] = $GLOBALS['point'];
			$formdata['type'] = $GLOBALS['type'];
			$formdata['cid'] = $GLOBALS['cid'];
			$formdata['quantity'] = $GLOBALS['quantity'];
			$this->db->insert('credit_set', $formdata);

			MSG('策略添加成功','?m=credit&f=set&v=listing'.$this->su());
		} else {
			$big_categorys = $this->db->get_list('category', array('pid'=>0,'type'=>0), '*', 0, 1000, 0, 'sort ASC,cid ASC');

			include $this->template('set_add');
		}
	}
	public function delete() {
		$csid = intval($GLOBALS['csid']);

		$this->db->delete('credit_set',array('csid'=>$csid));
		MSG('删除成功',HTTP_REFERER);
	}

}