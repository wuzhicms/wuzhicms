<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_cache_linkage {

  
    public function __construct() {
        $this->db = load_class('db');
    }
    public function cache() {
        $result = $this->db->get_list('linkage', '', '*', 0, 10000,0,'linkageid DESC');
        foreach($result as $r) {
            set_cache('config_'.$r['linkageid'],$r,'linkage');
        }
        return true;
    }
}
?>