<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 钩子
 */

class WUZHI_content_hook {
	function __construct() {
		$this->db = load_class('db');
	}
	function run_hook($hookid,$data = '',$attend = array()) {
		switch ($hookid) {
			case 'test_hookid':
				echo 'content hook ok';
				break;
		}
	}
}