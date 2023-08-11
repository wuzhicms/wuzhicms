<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 在线时长统计，3分钟统计一次
 */
load_class('admin');

final class onlinetime extends WUZHI_admin {

    function __construct() {
        $this->db = load_class('db');
    }
    /**
     * 统计在线时间
     */
    public function init() {
		$uid = $_SESSION['uid'];
		$dayid = date('Ymd');
		$onlinetime = $this->db->get_one('admin_onlinetime', array('uid' => $uid,'dayid'=>$dayid));
		$difftime = SYS_TIME-180;
		if($onlinetime) {
			if($onlinetime['lastupdate']>$difftime) {
				exit('1');
			}

			$onlinetimes = $onlinetime['onlinetimes']+3;
			$this->db->update('admin_onlinetime', array("onlinetimes"=>$onlinetimes,'lastupdate'=>SYS_TIME), array('uid' => $uid,'dayid'=>$dayid));
			exit('2');
		} else {
			$this->db->insert('admin_onlinetime', array('uid' => $uid,'dayid'=>$dayid,'onlinetimes'=>3,'lastupdate'=>SYS_TIME));
			exit('3');
		}
    }
}
?>