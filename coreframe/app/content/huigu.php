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
 * 团购回顾
 */
class huigu{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 团购栏目列表
     */
    public function listing() {
        $cid = intval($GLOBALS['cid']);
        //站点信息
        $siteconfigs = $this->siteconfigs;
        //栏目信息
        $categorys = get_cache('category','content');
        $category = get_cache('category_'.$cid,'content');
        if(empty($category)) MSG('栏目不存在');

        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : 'xa';
        $city_config = get_config('city_config');
        $cityid = $city_config[$city]['cityid'];
        $cityname = $city_config[$city]['cityname'];

        //分页初始化
        $page = max(intval($GLOBALS['page']),1);
        //分页规则
        $urlrule = '';

        if($category['child']) {
            $_template = $category['category_template'];
        } else {
            $_template = $category['list_template'];
        }
        if(empty($_template))  $_template = TPLID.':list';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $seo_title = '往期团购_'.$siteconfigs['sitename'];
        $seo_keywords = $category['seo_keywords'];
        $seo_description = $category['seo_description'];
        $elasticid = elasticid($cid);
        $model_r = get_cache('model_content','model');
        $master_table = $model_r[$category['modelid']]['master_table'];
        if($category['type']==1) {
            $r = $this->db->get_one($master_table,array('cid'=>$cid));
            if($r) {
                extract($r,EXTR_SKIP);
                if($attr_table = $model_r[$category['modelid']]['attr_table']) {
                    $r = $this->db->get_one($attr_table,array('id'=>$id));
                    extract($r,EXTR_SKIP);
                }
            }
        }
        $sub_categorys = sub_categorys($elasticid);
        include T('content',$_template.'_huigu',$project_css);
    }
}
?>