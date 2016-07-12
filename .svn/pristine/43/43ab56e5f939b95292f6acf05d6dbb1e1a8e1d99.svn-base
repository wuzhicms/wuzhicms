<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 来源管理
 */
load_class('admin');

class copyfrom extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 来源列表
	 */
	public function listing() {
        $siteid = get_cookie('siteid');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        if(isset($GLOBALS['keywords'])) {
            $keywords = $GLOBALS['keywords'];
            $where = "`name` LIKE '%$keywords%'";
        } else {
            $where = '';
        }
		$result = $this->db->get_list('copyfrom', $where, '*', 0, 20,$page);
		$pages = $this->db->pages;
        $total = $this->db->number;
		include $this->template('copyfrom_listing');
	}
	/**
	 * 添加来源
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['logo'] = remove_xss($GLOBALS['form']['logo']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['updatetime'] = '0000-00-00 00:00:00';

			$this->db->insert('copyfrom',$formdata);
			MSG(L('operation success'),HTTP_REFERER);
		} else {
            $show_formjs = 1;
			$form = load_class('form');

			include $this->template('copyfrom_add');
		}
	}

    /**
     * 编辑来源
     */
    public function edit() {
        $fromid = intval($GLOBALS['fromid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['logo'] = remove_xss($GLOBALS['form']['logo']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['updatetime'] = '0000-00-00 00:00:00';

            $this->db->update('copyfrom',$formdata,array('fromid'=>$fromid));
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('copyfrom',array('fromid'=>$fromid));
            include $this->template('copyfrom_edit');
        }
    }

    /**
     * 删除来源
     */
    public function delete() {
        $fromid = isset($GLOBALS['fromid']) ? intval($GLOBALS['fromid']) : 0;
        if(!$fromid) MSG(L('操作失败'));
        $this->db->delete('copyfrom',array('fromid'=>$fromid));

        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}