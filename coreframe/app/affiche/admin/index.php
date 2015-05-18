<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 在线支付
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 公告列表
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('affiche', '', '*', 0, 20,$page,'sort DESC,id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 添加公告
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['title'] = remove_xss($formdata['title']);
            $formdata['note'] = remove_xss($formdata['note']);
            $formdata['addtime'] = SYS_TIME;
            $formdata['endtime'] = strtotime($GLOBALS['endtime']);
            $formdata['publisher'] = get_cookie('username');
            $formdata['css'] = 'color:#'.remove_xss(ltrim($GLOBALS['title_css'],'#').';'.$GLOBALS['font_weight']);
            $linkageid = $this->db->insert('affiche',$formdata);
            MSG(L('operation success'),'?m=affiche&f=index&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d');
            include $this->template('add');
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
            $formdata['note'] = remove_xss($formdata['note']);
            $formdata['addtime'] = SYS_TIME;
            $formdata['endtime'] = strtotime($GLOBALS['endtime']);
            $formdata['publisher'] = get_cookie('username');
            $formdata['css'] = 'color:#'.remove_xss(ltrim($GLOBALS['title_css'],'#').';'.$GLOBALS['font_weight']);
            $linkageid = $this->db->update('affiche',$formdata,array('id'=>$id));
            MSG(L('operation success'),'?m=affiche&f=index&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            load_function('admin');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d');
            $r = $this->db->get_one('affiche',array('id'=>$id));

            $styles = style($r['css']);//color:#ff0000;font-weight:bold
            $font_weight = $styles['font-weight'];
            $color = $styles['color'];
            include $this->template('edit');
        }
    }
    /**
     * 删除公告
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('affiche',array('id'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 排序
     */
    public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('affiche',array('sort'=>$n),array('id'=>$cid));
            }
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            MSG(L('operation failure'));
        }
    }
}