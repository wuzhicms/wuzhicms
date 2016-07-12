<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 物流公司管理
 */
load_class('admin');
class express extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 物流公司列表
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('express', '', '*', 0, 20,$page,'eid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $this->cache();
        include $this->template('express_listing');
    }

    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['title'] = remove_xss($formdata['title']);
            $formdata['thumb'] = remove_xss($formdata['thumb']);
            $linkageid = $this->db->insert('express',$formdata);
            MSG(L('operation success'),'?m=order&f=express&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d');
            include $this->template('express_add');
        }
    }

    /**
     * 修改公告
     */
    public function edit() {
        $id = intval($GLOBALS['id']);
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['title'] = remove_xss($formdata['title']);
            $formdata['thumb'] = remove_xss($formdata['thumb']);
            $linkageid = $this->db->update('express',$formdata,array('eid'=>$id));
            MSG(L('operation success'),'?m=order&f=express&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            load_function('admin');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d');
            $r = $this->db->get_one('express',array('eid'=>$id));

            $styles = style($r['css']);//color:#ff0000;font-weight:bold
            $font_weight = $styles['font-weight'];
            $color = $styles['color'];
            include $this->template('express_edit');
        }
    }
    /**
     * 删除物流公司
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('express',array('eid'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    public function cache() {
        $result = $this->db->get_list('express', '', '*', 0, 100,0,'eid ASC','','eid');
        set_cache('express',$result,'order');
    }
}