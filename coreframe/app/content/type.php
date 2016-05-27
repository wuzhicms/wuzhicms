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
 * 类别
 */
class type{
	private $siteconfigs;
	public function __construct() {
		$this->siteconfigs = get_cache('siteconfigs');
		$this->db = load_class('db');
		$this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;
	}

	public function listing() {
		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
		$typeid = isset($GLOBALS['typeid']) ? intval($GLOBALS['typeid']) : MSG(L('parameter_error'));
		//站点信息
		$siteid = $this->siteid;
		$siteconfigs = $this->siteconfigs;
		//栏目信息
		$categorys = get_cache('category','content');
		$category = get_cache('category_'.$cid,'content');
		if(empty($category)) MSG('栏目不存在');


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

		if(empty($_template))  $_template = TPLID.':list';
		$styles = explode(':',$_template);
		$project_css = isset($styles[0]) ? $styles[0] : 'default';
		if($project_css==TPLID) {
			$project_css .= '-'.$siteid;
		}
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
		if($project_css=='iiis') $project_css .= '-1';
		$max_r = $this->db->get_one('content_share', array('cid' => $cid),'id,title',0,'id DESC');
		$id = $max_r['id'];
		$is_ie8 = false;
		if(strpos($HTTP_SERVER_VARS[HTTP_USER_AGENT], "MSIE 8.0")) {
			$is_ie8 = true;
		}
		$request_uri = $_SERVER["REQUEST_URI"];
		$modelid = $category['modelid'];
		/**
		$model_field = get_cache('field_'.$modelid,'model');
		$typeid_field = $model_field['typeid']['setting']['options'];
		$typeid_field = explode("\r\n",$typeid_field);
		$type_field = array();
		foreach($typeid_field as $typeid_fields) {
			$typeid_fields = explode('|',$typeid_fields);
			$type_field[$typeid_fields[1]] = $typeid_fields[0];
		}
		**/
		$type_field = array();
		$max_year = date('Y');
		for($i=$max_year;$i>2000;$i--) {
			$type_field[$i] = $i;
		}
		$language_set = 1;
		include T('content',$_template.'_type',$project_css);
	}
}
?>