<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 用户定制 - 钩子
 */

class WUZHI_custom_hook {
	function __construct() {
		$this->db = load_class('db');
	}
	function run_hook($hookid,$data = '',$attend = array()) {
		switch ($hookid) {
			case 'content_pass':
				if($attend['status']==9) {
					$this->db->update('member', array('ext_groupid1'=>9,'checkmec'=>1), array('uid' => $data['owner']));
				} else {
					$this->db->update('member', array('ext_groupid1'=>0,'checkmec'=>0), array('uid' => $data['owner']));
				}
				break;
		}
	}
}