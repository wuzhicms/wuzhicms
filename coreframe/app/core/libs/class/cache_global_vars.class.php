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
     * 更新敏感词缓存，默认最多1万个敏感词
     * @return bool
     */
    public function cache_all() {
        $db = load_class('db');
        $r = $db->get_one('setting',array('keyid'=>'configs','m'=>'core'));
        $datas = unserialize($r['data']);
        $result = $db->get_list('setting', array('m'=>'global_vars'), '*', 0, 1000,0,'','','keyid');
        foreach ($result as $key=>$v) {
            if(isset($datas[$key])) continue;
            $datas[$key] = $v['data'];
        }
        set_cache('siteconfigs',$datas);
        return true;
	}
}