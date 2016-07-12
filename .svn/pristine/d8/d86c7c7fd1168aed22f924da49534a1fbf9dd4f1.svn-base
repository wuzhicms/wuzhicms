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
	/**
	 * @param $hookid
	 * @param string $data 传入内容，字符或者数组
	 * @param array $attend 附加参数，数组
	 */
	function run_hook($hookid,$data = '',$attend = array()) {
		$hook_config = get_config('hook_config');
		if(!empty($hook_config[$hookid])) {
			$hook_config = $hook_config[$hookid];
			foreach($hook_config AS $_app) {
				$hookname = $_app.'_hook';
				$$hookname = load_class($_app.'_hook',$_app);
				$$hookname->run_hook($hookid,$data,$attend);
			}
		}
	}

}