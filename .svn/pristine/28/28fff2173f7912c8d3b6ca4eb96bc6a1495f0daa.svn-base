<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 更新角色缓存
 */
class WUZHI_cache_role{
    public function __construct() {

    }
    /**
     * 更新敏感词缓存，默认最多1万个敏感词
     * @return bool
     */
    public function cache_all() {
        $db = load_class('db');
        $result = $db->get_list('admin_role', '', '*', 0, 100,0,'','','role');
        set_cache('roles',$result);
        return true;
	}
}