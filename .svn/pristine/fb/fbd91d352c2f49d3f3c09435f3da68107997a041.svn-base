<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 预约卡相关
 */
class card {
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 预约卡登陆
     */
    public function login(){
        if(isset($GLOBALS['card_no'])) {
            if(empty($GLOBALS['card_no']) || empty($GLOBALS['password'])) {
                MSG('卡号和密码必须填写','?m=order&f=card&v=login',2000);
            }
            $card_no = sql_replace($GLOBALS['card_no']);
            $r = $this->db->get_one('order_card',array('card_no'=>$card_no));
            if($r) {
                $password = decode($r['password'],'Hx0si1');
                if($password!=$GLOBALS['password']) MSG('卡号或者密码错误');
                if($r['status']==2) MSG('您的预约卡已经使用过，不能重复预约，您可以通过登录“会员中心”查看详情！');
                //验证成功
                $mr = $this->db->get_one('member',array('username'=>$card_no));
                if($mr) {
                    $formdata = $mr;
                } else {
                    $factor = random_string('diy',6,'abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
                    $password = md5(md5($password).$factor);
                    $formdata = array('username'=>$card_no,'password'=>$password,'factor'=>$factor,'groupid'=>6,'points'=>0,'modelid'=>10,'email'=>'','regtime'=>SYS_TIME,'lasttime'=>SYS_TIME);
                    $formdata['uid'] = $this->db->insert('member',$formdata);
                    $this->db->update('order_card',array('uid'=>$formdata['uid']),array('cardid'=>$r['cardid']));
                }

                $this->create_cookie($formdata,SYS_TIME+604800);
                MSG('欢迎您的光临，即将进入预约信息页','?m=order&f=order_form&v=order_workflow&acbar=3');
            } else {
                MSG('卡号或者密码错误');
            }
        } else {
            include T('order','index');
        }
    }
    private function create_cookie($info, $cookietime=0){
        set_cookie('auth', encode($info['uid']."\t".$info['password']."\t".$cookietime, substr(md5(_KEY), 8, 8)), $cookietime);
        set_cookie('_uid', $info['uid'], $cookietime);
        set_cookie('_username', $info['username'], $cookietime);
        set_cookie('_groupid', $info['groupid'], $cookietime);
        load_function('string');
        setcookie(COOKIE_PRE.'truename', escape($info['username']), $cookietime, COOKIE_PATH, COOKIE_DOMAIN, 0);
        setcookie(COOKIE_PRE.'modelid', $info['modelid'], $cookietime, COOKIE_PATH, COOKIE_DOMAIN, 0);
    }
}
?>