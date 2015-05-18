<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 钩子调用类
 */
class WUZHI_hook{

	function run_hook($hookid,$key = '') {
		$hook_config = get_config('hook_config');
		if(!empty($hook_config)) {
			foreach($hook_config AS $_app) {
				$hookname = $_app.'_hook';
				$$hookname = load_class($_app.'_hook',$_app);
				$$hookname->run_hook($hookid,$key);
			}
		}
	}

}