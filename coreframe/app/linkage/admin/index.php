<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 联动菜单
 */
load_class('admin');

class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 联动菜单列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('linkage', '', '*', 0, 20,$page,'linkageid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 添加联动菜单
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['display_type'] = intval($GLOBALS['form']['display_type']);
            $formdata['level'] = intval($GLOBALS['form']['level']);
            $linkageid = $this->db->insert('linkage',$formdata);
            $config = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            set_cache('config_'.$linkageid,$config,'linkage');
            MSG(L('operation success'));
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            include $this->template('add');
        }
    }

    /**
     * 添加选项
     */
    public function add_item() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            if(empty($GLOBALS['form']['names'])) MSG(L('parameter error'));
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['linkageid'] = intval($GLOBALS['linkageid']);
            $formdata['pid'] = intval($GLOBALS['pid']);

            $names = explode("\n",$GLOBALS['form']['names']);
            foreach($names as $name) {
                $formdata['name'] = trim(remove_xss($name));
                $this->db->insert('linkage_data',$formdata);
            }
            if($formdata['pid']) {
                $this->db->update('linkage_data',array('child'=>1),array('lid'=>$formdata['pid']));
            }
            MSG(L('operation success'),'?m=linkage&f=index&v=item_listing&linkageid='.$formdata['linkageid'].'&pid='.$formdata['pid'].$this->su());
        } else {
            $show_formjs = 1;
            $linkageid = isset($GLOBALS['linkageid']) ? intval($GLOBALS['linkageid']) : 0;
            $pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
            $r = $this->db->get_one('linkage_data',array('lid'=>$pid));
            if(!$r) {
                $r = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            }
            include $this->template('add_item');
        }
    }
    /**
     * 联动菜单选项列表
     */
    public function item_listing() {
        $pid = intval($GLOBALS['pid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $linkageid = isset($GLOBALS['linkageid']) ? intval($GLOBALS['linkageid']) : 0;
        if($linkageid) {
            $where = array('linkageid'=>$linkageid,'pid'=>$pid);
        } else {
            $where = array('pid'=>$pid);
        }
        $result = $this->db->get_list('linkage_data', $where, '*', 0, 20,$page,"sort ASC,lid ASC");
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('item_listing');
    }
    /**
     * 排序
     */
    public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('linkage_data',array('sort'=>$n),array('lid'=>$cid));
            }
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 修改联动菜单
     */
    public function edit() {
        $linkageid = intval($GLOBALS['linkageid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['display_type'] = intval($GLOBALS['form']['display_type']);
            $formdata['level'] = intval($GLOBALS['form']['level']);
            $this->db->update('linkage',$formdata,array('linkageid'=>$linkageid));
            $config = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            set_cache('config_'.$linkageid,$config,'linkage');
            MSG(L('operation success'),'?m=linkage&f=index&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            include $this->template('edit');
        }
    }
    /**
     * 删除联动菜单
     */
    public function delete() {
        $linkageid = intval($GLOBALS['linkageid']);
        $this->db->delete('linkage',array('linkageid'=>$linkageid));
        $this->db->delete('linkage_data',array('linkageid'=>$linkageid));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 删除联动选项
     */
    public function delete_item() {
        $lid = intval($GLOBALS['lid']);
        $this->db->delete('linkage_data',array('lid'=>$lid));
        $this->delete_child($lid);
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 递归删除子选项
     */
    private function delete_child($lid) {
        $r = $this->db->get_one('linkage_data',array('pid'=>$lid));
        if($r) {
            $this->db->delete('linkage_data',array('lid'=>$r['lid']));
            $this->delete_child($r['lid']);
        }
    }
    /**
     * 修改联动菜单选项
     */
    public function edit_item() {
        $lid = intval($GLOBALS['lid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $this->db->update('linkage_data',$formdata,array('lid'=>$lid));
            $forward = $GLOBALS['forward'];
            MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $r = $this->db->get_one('linkage_data',array('lid'=>$lid));
            include $this->template('edit_item');
        }
    }
}