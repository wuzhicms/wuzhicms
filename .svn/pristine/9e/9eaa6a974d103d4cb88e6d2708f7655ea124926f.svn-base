<?php
class index{
	function __construct() {
	}

    /**
     *  邀请注册
     */
	function index() {
        $uid = intval($GLOBALS['uid']);
        if(!$uid) {
            header("Location:".WEBURL);
            exit;
        }
        $_uid = get_cookie('_uid');
        if($_uid && is_numeric($_uid)) {
            //已经登录的用户不算成功推广的下线
            header("Location:".WEBURL);
            exit;
        } else {
            $times = SYS_TIME+86400*7;
            set_cookie('ppc_uid',$uid,$times);
            $db = load_class('db');
            $ip = get_ip();
            $db->insert('ppc',array('uid'=>$uid,'addtime'=>SYS_TIME,'ip'=>$ip));
            //后台配置推广页面跳转地址
            $setting = get_cache('setting','ppc');
            if(empty($setting['redirect_url'])) MSG('请在后台配置推广页面地址');
            header("Location:".$setting['redirect_url']);
        }
	}
    public function test() {
        echo 'test';
    }
}
