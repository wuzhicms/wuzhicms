<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 地图
 */
class map{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 地图
     */
    public function init() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $hotcity = hotcity(0);
        $category_result = $this->db->get_list('category',array('modelid'=>3),'*',0,1000);
        $city = substr(rtrim($_SERVER["REQUEST_URI"],'/'),5);
        if($city=='') $city = 'beijing';

        foreach($categorys as $cid=>$rs) {
            if($rs['catdir']==$city) {
                $cityid = $cid;
                set_cookie('cityname',$rs['name'],SYS_TIME+86400*7);
                set_cookie('cityid',$cityid,SYS_TIME+86400*7);
                $cityname = $rs['name'];
                break;
            }
        }

        $page = max(intval($GLOBALS['page']),1);

        $urlrule = 'javascript:change_pagemap({$page});';
        include T('content','map',TPLID);
	}
    /**
     * search result
     */
    public function search() {
        $categorys = get_cache('category','content');
        $cityname = remove_xss($GLOBALS['cityname']);
        foreach($categorys as $cid=>$rs) {
            if($rs['name']==$cityname) {
                $cityid = $cid;
                set_cookie('cityname',$rs['name'],SYS_TIME+86400*7);
                set_cookie('cityid',$cityid,SYS_TIME+86400*7);
                $city = $rs['catdir'];
                break;
            }
        }

        $page = max(intval($GLOBALS['page']),1);
        $urlrule = 'javascript:change_pagemap({$page});';
        include T('content','map-search',TPLID);
    }
    /**
     * search mec
     */
    public function search2() {
        $categorys = get_cache('category','content');
        $cityname = remove_xss($GLOBALS['cityname']);

        $page = max(intval($GLOBALS['page']),1);
        $urlrule = 'javascript:change_pagemap2({$page});';
        $where = "`status`=9 AND `title` LIKE '%$cityname%'";
        $result = $this->db->get_list('mec', $where, '*', 0, 10, $page, 'id DESC','','',$urlrule,'',3);
        $pages = $this->db->pages;
        include T('content','map-search2',TPLID);
    }
}
?>