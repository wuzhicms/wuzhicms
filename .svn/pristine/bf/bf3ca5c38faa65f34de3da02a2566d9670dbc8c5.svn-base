<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 友情链接
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;

	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 友情链接列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('link', '', '*', 0, 20,$page,'sort ASC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 添加友情链接
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['sitename'] = remove_xss($GLOBALS['form']['sitename']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['logo'] = remove_xss($GLOBALS['form']['logo']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['username'] = get_cookie('username');
            $formdata['addtime'] = SYS_TIME;
            $formdata['kid'] = intval($GLOBALS['form']['kid']);
            $linkageid = $this->db->insert('link',$formdata);
            MSG(L('operation success'));
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $options = $this->db->get_list('kind',array('keyid'=>'link'));
            $options = key_value($options,'kid','name');
            include $this->template('add');
        }
    }

    /**
     * 排序
     */
    public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('link',array('sort'=>$n),array('linkid'=>$cid));
            }
            MSG(L('operation success'));
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 修改友情链接
     */
    public function edit() {
        $linkid = intval($GLOBALS['linkid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['sitename'] = remove_xss($GLOBALS['form']['sitename']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['logo'] = remove_xss($GLOBALS['form']['logo']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['username'] = get_cookie('username');
            $formdata['addtime'] = SYS_TIME;
            $formdata['kid'] = intval($GLOBALS['form']['kid']);
            $this->db->update('link',$formdata,array('linkid'=>$linkid));
            $forward = $GLOBALS['forward'];
            MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('link',array('linkid'=>$linkid));
            $options = $this->db->get_list('kind',array('keyid'=>'link'));
            $options = key_value($options,'kid','name');
            include $this->template('edit');
        }
    }
    /**
     * 删除友情链接
     */
    public function delete() {
        $linkid = intval($GLOBALS['linkid']);
        $this->db->delete('link',array('linkid'=>$linkid));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}