<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 友情链接首页
 */
class index{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 链接首页
     */
    public function init() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = '友情链接-'.$siteconfigs['sitename'];
        $seo_keywords = '友情链接,'.$siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        include T('link','index',TPLID);
	}
}
?>