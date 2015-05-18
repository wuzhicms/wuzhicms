<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 工作流
 */
load_class('admin');

class workflow extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 工作流列表
     */
    public function listing() {
        $module_names = get_config('module_names');

        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('workflow', '', '*', 0, 20,$page);
        foreach($result as $key=>$r) {
            if($r['level1_user']!='') {
                $leveluser = unserialize($r['level1_user']);
                //$leveluser = array_values($leveluser);
                $str = '';
                foreach($leveluser as $uid=>$le) {
                    $str .= '<a href="?m=core&f=workflow&v=deluser&level=1&uid='.$uid.'&workflowid='.$r['workflowid'].$this->su().'" title="点击删除">'.$le.'</a> <br>';
                }
                $r['level1_user'] = $str;
            }
            if($r['level2_user']!='') {
                $leveluser = unserialize($r['level2_user']);
                $str = '';
                foreach($leveluser as $uid=>$le) {
                    $str .= '<a href="?m=core&f=workflow&v=deluser&level=2&uid='.$uid.'&workflowid='.$r['workflowid'].$this->su().'" title="点击删除">'.$le.'</a> <br>';
                }
                $r['level2_user'] = $str;
            }
            if($r['level3_user']!='') {
                $leveluser = unserialize($r['level3_user']);
                $str = '';
                foreach($leveluser as $uid=>$le) {
                    $str .= '<a href="?m=core&f=workflow&v=deluser&level=3&uid='.$uid.'&workflowid='.$r['workflowid'].$this->su().'" title="点击删除">'.$le.'</a> <br>';
                }
                $r['level3_user'] = $str;
            }
            $result[$key] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('workflow_listing');
    }
    public function adduser() {
        if($GLOBALS['submit']) {
            $username = sql_replace($GLOBALS['username']);
            $r = $this->db->get_one('member',array('username'=>$username));
            if(!$r) MSG('用户名不存在');
            $rs = $this->db->get_one('admin',array('uid'=>$r['uid']));
            if(!$rs) MSG('请先在添加管理员处，添加该用户');
            $workflowid = intval($GLOBALS['workflowid']);
            $level = intval($GLOBALS['level']);
            $wr = $this->db->get_one('workflow',array('workflowid'=>$workflowid));
            $users = array();
                if($wr['level'.$level.'_user']!='') {
                    $users = unserialize($wr['level' . $level . '_user']);
                }
                $users[$r['uid']]=$rs['truename'] ? $rs['truename'] : $username;
                $users = serialize($users);
                $this->db->update('workflow',array('level'.$level.'_user'=>$users),array('workflowid'=>$workflowid));

            MSG(L('add success'),$GLOBALS['forward']);
        } else {
            $show_formjs = 1;
            include $this->template('workflow_adduser');
        }

    }
    public function deluser() {
        $workflowid = intval($GLOBALS['workflowid']);
        $level = intval($GLOBALS['level']);
        $uid = intval($GLOBALS['uid']);
        $wr = $this->db->get_one('workflow',array('workflowid'=>$workflowid));
        $users = array();
        if($wr['level'.$level.'_user']!='') {
            $users = unserialize($wr['level' . $level . '_user']);
            unset($users[$uid]);
        }
        $users = serialize($users);
        $this->db->update('workflow',array('level'.$level.'_user'=>$users),array('workflowid'=>$workflowid));
        MSG(L('delete success'),HTTP_REFERER);
    }
}