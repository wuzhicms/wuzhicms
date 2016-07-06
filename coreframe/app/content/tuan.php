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
 * 团购页面
 */
class tuan{
    private $siteconfigs;
    public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
    }

    /**
     * 团购首页
     */
    public function init() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        $siteconfigs = $this->siteconfigs;
        $categorys = get_cache('category','content');
        $category = get_cache('category_'.$cid,'content');
        if(empty($category)) MSG('栏目不存在');
        $filterurl_config = get_config('filterurl_config','tuan');

        $where = '';
        $field_array = $filterurl_config['field'];
        $urlrule = $filterurl_config['urlrule'];
        $variables = array();
        foreach($field_array as $field) {
            $variables[$field] = isset($GLOBALS[$field]) ? intval($GLOBALS[$field]) : 0;
        }

        $order = isset($GLOBALS['order']) ? $GLOBALS['order'] : 0;
        $orderby_arr = array('sort DESC,id DESC','sort DESC,id DESC','id DESC','price DESC');
        $orderby = $orderby_arr[$order];

        $page = isset($GLOBALS['page']) ? $GLOBALS['page'] : 1;
        $page = max($page,1);
        $_POST['page_urlrule'] = $urlrule;
        $_POST['page_fields'] = $variables;

        $kw_style = $kw_house = '';
        $where = '';
        if($variables['style']) {
            $where .= " AND `style`='".$variables['style']."'";
            $kw_style = $filterurl_config['style'][$variables['style']];
        }

        if($variables['price']) {
            $min = $filterurl_config['price'][$variables['price']]['min'];
            $max = $filterurl_config['price'][$variables['price']]['max'];
            if($min && $max) {
                $where .= " AND `price` >= $min";
                $where .= " AND `price` <= $max";
            } else {
                if($min) $where .= " AND `price` > $min";
                if($max) $where .= " AND `price` < $max";
            }

        }
        //标签类中已经带 AND ,这里截取
        $where = substr($where,4);
        
        //权限检查
        /**
        $_groupid = $GLOBALS['_groupid'];
        $priv_data = $this->db->get_one('member_group_priv', array('groupid' => $_groupid,'value'=>$cid,'priv'=>'listview'));

        if(!$priv_data) {
            MSG('禁止访问');
        }
         **/
        //end 权限检查
        /**
        //城市站
        $city = get_cookie('city');
        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : $city=='' ? 'xa' : $city;
        $cookie_city = $_COOKIE[COOKIE_PRE.'city_key'];
        $city_config = get_config('city_config');
        $cityid = $city_config[$city]['cityid'];
        $cityname = $city_config[$city]['cityname'];
**/

        //分页初始化
        $page = max(intval($GLOBALS['page']),1);
        //分页规则
        $urlrule = '';
        $urlrule = WWW_PATH.$category['listurl'];
        if($category['child']) {
            $_template = $category['category_template'];
        } else {
            $_template = $category['list_template'];
        }
        if(ENABLE_SITES) {
            $siteid = intval($_GET['siteid']);
            if(!$siteid) $siteid = 1;
            $tplid = TPLID.'-'.$siteid;
        } else {
            $tplid = TPLID;
        }
        if(empty($_template))  $_template = $tplid.':list';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $seo_title = $category['seo_title'] ? $category['seo_title'] : $category['name'].'_'.$siteconfigs['sitename'];
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
        $modelid = $category['modelid'];
        $type_field = array();
        $language_set = 1;
        $top_categoryid = getcategoryid($cid);
        $top_category = $categorys[$top_categoryid];
        include T('content',$_template,$project_css);
    }
}
?>