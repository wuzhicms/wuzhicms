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

	}
	function run_hook($hookid,$key = '') {
		switch ($hookid) {
			case 'footer':
				echo 'content hook ok';
				break;
		}
	}
}