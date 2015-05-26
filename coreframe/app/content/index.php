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
 * 网站首页
 */
class index{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 网站首页
     */
    public function init() {
        $isindex = 1;
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');

        $city = 'beijing';
//----

        //include T('city','index',TPLID);
//----
        include T('content','index',TPLID);
	}

    /**
     * 内容页面
     * url规则 /index.php?v=show&cid=24&id=79
     */
    public function show() {
        $siteconfigs = $this->siteconfigs;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        $categorys = get_cache('category','content');
        //查询数据
        $category = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');

        $model_r = $models[$category['modelid']];
        $master_table = $model_r['master_table'];
        $data = $this->db->get_one($master_table,array('id'=>$id));
        if(!$data || $data['status']!=9) MSG('信息不存在或者未通过审核！');
        if($model_r['attr_table']) {
            $attr_table = $model_r['attr_table'];
            if($data['modelid']) {
                $modelid = $data['modelid'];
                $attr_table = $models[$modelid]['attr_table'];
            }
            $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
            $data = array_merge($data,$attrdata);
        } else {
            $modelid = $model_r['modelid'];
        }

        require get_cache_path('content_format','model');
        $form_format = new form_format($modelid);
        $data = $form_format->execute($data);

        foreach($data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
        if($template) {
            $_template = $template;
        } elseif($category['show_template']) {
            $_template = $category['show_template'];
        } elseif($model_r['template']) {
            $_template = TPLID.':'.$model_r['template'];
        } else {
            $_template = TPLID.':show';
        }
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $elasticid = elasticid($cid);
        $seo_title = $title.'_'.$category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = !empty($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        //上一页
        $previous_page = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
        //下一页
        $next_page = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
        //手动分页
        $CONTENT_POS = strpos($content, '_wuzhicms_page_tag_');
        if(!empty($content) && $CONTENT_POS !== false) {
            $page = max($GLOBALS['page'],1);
            $contents = array_filter(explode('_wuzhicms_page_tag_', $content));
            $pagetotal = count($contents);
            $content = $contents[$page-1];
            $tmp_year = date('Y',$addtime);
            $tmp_month = date('m',$addtime);
            $tmp_day = date('d',$addtime);
            $content_pages = pages($pagetotal,$page,1,$category['showurl'],array('year'=>$tmp_year,'month'=>$tmp_month,'day'=>$tmp_day,'catdir'=>$category['catdir'],'cid'=>$cid,'id'=>$id));
        } else {
            $content_pages = '';
        }
        include T('content',$_template,$project_css);
    }

    /**
     * 栏目列表
     */
    public function listing() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        //站点信息
        $siteconfigs = $this->siteconfigs;
        //栏目信息
        $categorys = get_cache('category','content');
        $category = get_cache('category_'.$cid,'content');
        if(empty($category)) MSG('栏目不存在');
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
        include T('content',$_template,$project_css);
    }
}
?>