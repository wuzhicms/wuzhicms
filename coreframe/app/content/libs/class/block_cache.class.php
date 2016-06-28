<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 推荐位缓存更新
 */
class WUZHI_block_cache{
    public function __construct() {
    }
    /**
     * 推荐位
     * @return bool
     */
    public function cache_all() {
        //清理目录
        $cache_path = CACHE_ROOT . 'block' . '/';
        delete_dirfile($cache_path);

        $db = load_class('db');
        $result = $db->get_list('block', '', '*', 0, 1000);
        foreach ($result as $r) {
            set_cache('block_'.$r['blockid'],$r,'block');
        }
        return true;
	}

}