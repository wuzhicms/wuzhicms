<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 管理员权限管理
 */
load_class('admin');

class power extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 管理员列表
	 */
	public function listing() {
        $roles = get_cache('roles');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
		$result = $this->db->get_list('admin', '', '*', 0, 20,$page);
		$pages = $this->db->pages;
        $total = $this->db->number;
		include $this->template('power_listing');
	}
	/**
	 * 添加管理员
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
            if(empty($GLOBALS['form']['username'])) MSG(L('parameter error'));
            $username = $GLOBALS['form']['username'];
            $r = $this->db->get_one('member',array('username'=>$username));
            if(!$r['uid']) MSG(L('账号不存在，请先管理会员处－添加账号'));
            $rs = $this->db->get_one('admin',array('uid'=>$r['uid']));
            if($rs) MSG(L('管理员已存在！'));
			$formdata = array();
			$formdata['uid'] = $r['uid'];
            if(empty($GLOBALS['form']['password'])) {
                $formdata['password'] = '';
            } else {
                $factor = substr(random_string('md5'),0,6);
                $password = md5(md5($GLOBALS['form']['password']).$factor);
                $formdata['password'] = $password;
                $formdata['factor'] = $factor;
            }
            $formdata['role'] = intval($GLOBALS['form']['role']);
            $formdata['truename'] = remove_xss($GLOBALS['form']['truename']);
			$this->db->insert('admin',$formdata);
			MSG(L('operation success'));
		} else {
            $show_formjs = 1;
			$form = load_class('form');
            $roles = $this->db->get_list('admin_role', '', '*', 0, 100);

			include $this->template('power_add');
		}
	}

    /**
     * 编辑管理员
     */
    public function edit() {
        $uid = intval($GLOBALS['uid']);
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

            $formdata['role'] = intval($GLOBALS['form']['role']);
            $formdata['truename'] = remove_xss($GLOBALS['form']['truename']);


            $this->db->update('admin',$formdata,array('uid'=>$uid));
            MSG(L('edit success'),'?m=core&f=power&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $roles = $this->db->get_list('admin_role', '', '*', 0, 100);
            $r = $this->db->get_one('admin',array('uid'=>$uid));
            $mr = $this->db->get_one('member',array('uid'=>$uid));
            $username = $mr['username'];
            include $this->template('power_edit');
        }
    }


    /**
     * 添加角色
     */
    public function role_add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['remark'] = $GLOBALS['form']['remark'];
            $this->db->insert('admin_role',$formdata);

            MSG(L('operation success'),'?m=core&f=power&v=role_listing'.$this->su());
        } else {

            $show_formjs = 1;
            include $this->template('role_add');
        }
    }

    /**
     * 修改角色
     */
    public function role_edit() {
        $role = intval($GLOBALS['role']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['remark'] = $GLOBALS['form']['remark'];
            $this->db->update('admin_role',$formdata,array('role'=>$role));
            MSG(L('edit success'),'?m=core&f=power&v=role_listing'.$this->su());
        } else {
            $show_formjs = 1;
            $r = $this->db->get_one('admin_role',array('role'=>$role));
            include $this->template('role_edit');
        }
    }

    /**
     * 角色列表
     */
    public function role_listing() {
        $result = $this->db->get_list('admin_role', '', '*', 0, 100);
        $cache_role = load_class('cache_role');
        $cache_role->cache_all();
        include $this->template('role_listing');
    }

    /**
     * 权限设置
     */
    public function private_set() {
        $role = intval($GLOBALS['role']);
        if(isset($GLOBALS['id'])) {
            $id = intval($GLOBALS['id']);
            $chk = intval($GLOBALS['chk']);
            $mr = $this->db->get_one('menu', array('menuid'=>$id));
            $r = $this->db->get_one('admin_private',array('id'=>$id,'role'=>$role));
            $keyid = substr(md5($role.$mr['m'].$mr['f'].$mr['v']),0,16);
            if($r) {
                $this->db->update('admin_private',array('chk'=>$chk,'keyid'=>$keyid),array('id'=>$id,'role'=>$role));
            } else {
                $this->db->insert('admin_private',array('id'=>$id,'role'=>$role,'chk'=>$chk,'keyid'=>$keyid));
            }
            exit('1');
        } else {
            $r_role = $this->db->get_one('admin_role',array('role'=>$role));
            $parent_top = $this->db->get_list('menu', '`pid`=0', '*', 0, 20);

            $result = $this->db->get_list('menu', '', '*', 0, 2000, 0, 'sort ASC');
            $privates_rs = $this->db->get_list('admin_private', array('role'=>$role), '*', 0, 2000);
            $privates = array();
            foreach($privates_rs as $rs) {
               if($rs['chk']) $privates[] = $rs['id'];
            }
            include $this->template('private_set');
        }

    }

    /**
     * 删除角色
     */
    public function role_delete() {
        $role = isset($GLOBALS['role']) ? intval($GLOBALS['role']) : 0;
        if(!$role || $role==1) MSG(L('操作失败'));
        $this->db->delete('admin_role',array('role'=>$role));

        MSG(L('delete success'),HTTP_REFERER,1500);
    }

    /**
     * 删除管理员
     */
    public function delete() {
        $uid = isset($GLOBALS['uid']) ? intval($GLOBALS['uid']) : 0;
        if(!$uid) MSG(L('操作失败'));
        //不允许删除创始人
        $founders = explode(',',FOUNDERS);
        if(in_array($uid,$founders)) MSG(L('不能删除创始人'));
        $this->db->delete('admin',array('uid'=>$uid));

        MSG(L('operation success'),HTTP_REFERER,500);
    }

    /**
     * 登录记录
     */
    public function logintime() {
        $uid = intval($GLOBALS['uid']);
        $mr = $this->db->get_one('member',array('uid'=>$uid),'username');

        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('logintime', array('uid'=>$uid), '*', 0, 50,$page,'id DESC');
        $pages = $this->db->pages;
        include $this->template('logintime');
    }
}