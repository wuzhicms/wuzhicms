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
 * 城市首页
 */
class city{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 首页
     */
    public function index() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $city = substr(rtrim($_SERVER["REQUEST_URI"],'/'),6);
        $hotcity = hotcity(0);
        if(empty($city)) {
            $cityid = get_cookie('cityid');
            $city = $categorys[$cityid]['catdir'];
            //$table, $where = '', $field = '*', $startid = 0, $pagesize
            $category_result = $this->db->get_list('category',array('modelid'=>3),'*',0,1000);
            include T('city','index',TPLID);
        } else {
            foreach($categorys as $cid=>$rs) {
                if($rs['catdir']==$city) {
                    $cityid = $cid;
                    set_cookie('cityname',$rs['name'],SYS_TIME+86400*7);
                    set_cookie('cityid',$cityid,SYS_TIME+86400*7);
                    $cityname = $rs['name'];
                    break;
                }
            }
            include T('content','index-city',TPLID);
        }

	}
    public function getareaid() {
        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('mec', array('id' => $id),'areaid,fuwu');
        echo json_encode($r);
    }
}
?>