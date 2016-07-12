<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 我的面板
 */
load_class('admin');

class panel extends WUZHI_admin {
	function __construct() {
		$this->db = load_class('db');
	}

    /**
     * 编辑个人信息
     */
    public function edit_info() {
        $uid = $_SESSION['uid'];
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            if(empty($GLOBALS['form']['password'])) {
                $formdata['password'] = '';
            } else {
                $factor = substr(random_string('md5'),0,6);
                $password = md5(md5($GLOBALS['form']['password']).$factor);
                $formdata['password'] = $password;
                $formdata['factor'] = $factor;

            }
            $GLOBALS['form'] = remove_xss($GLOBALS['form']);
            $formdata['truename'] = $GLOBALS['form']['truename'];
            $formdata['lang'] = $GLOBALS['form']['lang'];
            $formdata['department'] = $GLOBALS['form']['department'];
            $formdata['face'] = $GLOBALS['form']['face'];
            $formdata['lang'] = $GLOBALS['form']['lang'];
            $formdata['email'] = $GLOBALS['form']['email'];
            $formdata['tel'] = $GLOBALS['form']['tel'];
            $formdata['mobile'] = $GLOBALS['form']['mobile'];
            $formdata['remark'] = $GLOBALS['form']['remark'];
            $this->db->update('admin',$formdata,array('uid'=>$uid));
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $roles = $this->db->get_list('admin_role', '', '*', 0, 100);
            $r = $this->db->get_one('admin',array('uid'=>$uid));
            $mr = $this->db->get_one('member',array('uid'=>$uid));
            $username = $mr['username'];
            $langs = array('zh-cn'=>'中文');
            include $this->template('edit_info');
        }
    }

    /**
     * 编辑操作日志
     */
    public function editor_log() {
        $page = $GLOBALS['page'];
        $page = max($page,1);
        $result = $this->db->get_list('editor_log', '', '*', 0, 20,$page,0,'logid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $actions = array('add'=>'添加','edit'=>'修改','sort'=>'排序','delete'=>'删除','check'=>'审核');
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }

        include $this->template('editor_log');
    }
}