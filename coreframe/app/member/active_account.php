<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 激活帐号
 */
class active_account{
	public function __construct() {
        $this->db = load_class('db');
	}

    /**
     *
     */
    public function init() {
		$uid = intval($GLOBALS['uid']);
		$randtime = intval($GLOBALS['randtime']);
		$activecode = $GLOBALS['activecode'];
		if(strlen($activecode)!=32 || $activecode!=md5($uid.$randtime)) MSG('链接地址错误');
		$r = $this->db->get_one('member', array('uid' => $uid));

		if($r['islock']==0) {
			MSG('帐号已经激活,不能重复激活','index.php?m=member');
		}
		$sys_name = $r['sys_name'];
		if(isset($GLOBALS['submit'])) {
			$username = strip_tags($GLOBALS['username']);
			$r2 = $this->db->get_one('member', array('username' => $username));
			if($r2 && $r2['uid']!=$uid) {
				MSG('用户名已经被占用,请更换',HTTP_REFERER,5000);
			}
			$password = $GLOBALS['password'];

			$factor = random_string('diy', 6,'23456789abcdefghjkmnpqrstuvwxyz');
			$password = md5(md5($password).$factor);
			$this->db->update('member', array('username'=>$username, 'password'=>$password,'factor'=>$factor,'pw_reset'=>0,'islock'=>0,'sys_name'=>0,'ischeck_email'=>1), array('uid' => $uid));
			$forward = urlencode('index.php?m=member');
			MSG('帐号激活成功,请登录','index.php?m=member&v=login&forward='.$forward);
		} else {
			$username = $r['username'];
			include T('member','active_account');
		}

    }
}
?>