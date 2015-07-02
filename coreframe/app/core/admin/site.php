<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 站点管理
 */
load_class('admin');

class site extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 列表
     */
    public function listing() {
        //0, $order = '', $group = '', $keyfield = ''
        $result = $this->db->get_list('site', '', '*', 0, 100, 0, '','', 'siteid');
        set_cache('sitelist',$result);
        include $this->template('site_listing');
    }
    /**
     * 添加
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['logo'] = $GLOBALS['form']['logo'];
            $r = $this->db->get_one('site', array('name' => $formdata['name']));
            if($r) MSG('站点已存在，无需重复添加');
            $this->db->insert('site',$formdata);
            MSG(L('operation success'),'?m=core&f=site&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');

            include $this->template('site_add');
        }
    }
    /**
     * edit
     */
    public function edit() {
        $siteid = intval($GLOBALS['siteid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['logo'] = $GLOBALS['form']['logo'];
            $this->db->update('site',$formdata,array('siteid'=>$siteid));
            MSG(L('operation success'),'?m=core&f=site&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('site', array('siteid' => $siteid));
            include $this->template('site_edit');
        }
    }
    /**
     * edit
     */
    public function changesite() {
        $siteid = intval($GLOBALS['siteid']);
        set_cookie('siteid',$siteid);
    }

}