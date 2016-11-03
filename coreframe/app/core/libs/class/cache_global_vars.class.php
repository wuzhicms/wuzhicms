<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 更新自定义变量缓存
 */
class WUZHI_cache_global_vars{
    public function __construct() {

    }
    /**
     * 更新站点缓存
     * @return bool
     */
    public function cache_all() {
        $db = load_class('db');
		$result = $db->get_list('setting', array('m'=>'global_vars'), '*', 0, 1000,0,'','','keyid');
		$datas = array();
		foreach ($result as $key=>$v) {
			$datas[$key] = $v['data'];
		}
		$sitelist = $db->get_list('site', '', '*', 0, 20, 0, 'siteid DESC');
		foreach($sitelist as $r) {
			if($r['setting']) {
				$setting = unserialize($r['setting']);
				$setting = array_merge($setting,$datas);
				set_cache('siteconfigs_'.$r['siteid'],$setting);
			} else {
				$r2 = $db->get_one('setting',array('keyid'=>'configs','m'=>'core'));
				$setting = unserialize($r2['data']);
				$setting = array_merge($setting,$datas);
				set_cache('siteconfigs_'.$r['siteid'],$setting);
			}
		}
        return true;
	}
}