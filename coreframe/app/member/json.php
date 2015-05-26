<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 会员相关
 */
class json{
    private $siteconfigs;
    public  $childs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
    }


    public function active_email() {
        if(!isset($GLOBALS['auth']) || !isset($GLOBALS['uid']) || !isset($GLOBALS['email']) || !isset($GLOBALS['t'])) {
            MSG('验证失败！');
        }
        $auth = $GLOBALS['auth'];
        $uid = intval($GLOBALS['uid']);
        $email = $GLOBALS['email'];
        $t = $GLOBALS['t'];

        if(decode($auth)!=$t.$uid.$email) MSG('验证失败！');
        if($t<SYS_TIME-3600) {
            MSG('邮件验证超时，请重新验证！','index.php?m=member&f=index&v=edit_email');
        }
        $this->db->update('member', array('ischeck_email'=>1), array('uid' => $uid));
        $point_config = get_cache('point_config');
        $credit_api = load_class('credit_api','credit');
        $keyid = 'em'.$uid;
        //验证邮箱，只送一次
        if(!$credit_api->get($keyid)) {
            $credit_api->handle($uid, '+',$point_config['email_check'], '验证邮箱：'.$email,'',$keyid);
        }

        MSG('邮件验证成功！','index.php?m=member&f=index&v=account_safe');
    }

    /**
     * 会员中心，获取新消息
     */
    public function get_newmessage() {
        $uid = get_cookie('_uid');
        $arr = array();
        $r = $this->db->get_one('message', array('touid' => $uid,'status'=>1));
        if($r) {
            $arr['newmessage'] = 1;
        }
        echo json_encode($arr);
    }
    /*
     * 获取会员头像
     *
     * Author：沉默の羔羊
    */
    public function get_avatar() {
        $uid = $GLOBALS['uid'] ? intval($GLOBALS['uid']) : get_cookie('_uid');
        if(!$uid) {
            echo json_encode(R."images/userface.png");
            exit();
        }
        $dir = substr(md5($uid), 0, 2).'/'.$uid.'/';
        $avatar = ATTACHMENT_URL.'member/'.$dir."180x180.jpg";
        echo json_encode($avatar);
    }

}
?>