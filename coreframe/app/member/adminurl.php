<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 后台管理跳转
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
load_class('session');
class adminurl extends WUZHI_foreground {
 	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

	public function init() {
        $forward = $GLOBALS['forward'];
        $_token = md5($forward.$this->uid);
        $uid = $this->uid;
        if($_token!=$GLOBALS['token']) MSG('没有操作权限');

        $rs = $this->db->get_one('admin',array('uid'=>$uid));
        if(!$rs) MSG('没有操作权限');
        //判断有没有当前菜单的权限
        if(strpos($rs['role'],',1,')!==false || $this->check_private($rs['role'],$forward)) {
            $_SESSION['uid'] = $uid;
            $_SESSION['role'] = $rs['role'];
            set_cookie('username',$this->memberinfo['username']);
            set_cookie('wz_name',$rs['truename']);
            $_SESSION['ip'] = get_ip();
            $_SESSION['lock_screen'] = 0;

            header("Location:index.php".$forward.'&_su='._SU);
        } else {
            MSG('没有操作权限');
        }

	}

    /**
     * 判断有没有当前菜单的权限
     */
    private function check_private($role,$url) {
        parse_str(trim($url,'?'));
        $role = trim($role,',');
        $roles = explode(',',$role);
        foreach($roles as $role) {
            $keyid = substr(md5($role.$m.$f.$v),0,16);
            $r = $this->db->get_one('admin_private',array('keyid'=>$keyid),'chk');
            if($r && $r['chk']==1) return true;
        }
        return false;
    }
}