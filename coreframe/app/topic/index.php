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
 * 专题
 */
class index{
    private $siteconfigs;
	public function __construct() {
        $this->db = load_class('db');
        $this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;
		$this->siteconfigs = get_cache('siteconfigs_'.$this->siteid);
	}

    /**
     * 专题首页
     */
    public function init() {
		$tid = intval($GLOBALS['tid']);
		if(!$tid) MSG('tid错误');
        $siteconfigs = $this->siteconfigs;

        $categorys = get_cache('category','content');
		$data_r = $this->db->get_one('topic', array('tid' => $tid));
		if(!$data_r) {
			MSG('专题不存在');
		}
		if($data_r['status']!=9) {
			MSG('专题未发布');
		}
		$style = $this->db->get_one('kind', array('kid' => $data_r['styleid']));
		$topic_css = $style['remark'];
		$page = max($GLOBALS['page'],1);
		$type_r = $this->db->get_one('kind', array('kid' => $data_r['kid']));
		$seo_title = $data_r['name'];
		$seo_keywords = $siteconfigs['seo_keywords'];
		$seo_description = $siteconfigs['seo_description'];
		$keyid = 'topic'.$tid;

		$sub_categorys = $this->db->get_list('kind', "`keyid`='$keyid'", '*', 0, 100, 0, 'sort DESC,kid ASC','','kid');

		$_template = $data_r['index_template'];
		if($_template=='') $_template = 'default:index';
		$styles = explode(':',$_template);
		$project_css = isset($styles[0]) ? $styles[0] : 'default';

		$_template = isset($styles[1]) ? $styles[1] : 'index';
		$kid = $data_r['kid'];
        include T('topic',$_template,$project_css);
	}


    /**
 * 子分类列表
 */
	public function listing() {
		$subkid = isset($GLOBALS['subkid']) ? intval($GLOBALS['subkid']) : MSG(L('parameter_error'));
		$tid = intval($GLOBALS['tid']);
		if(!$tid) MSG('tid错误');
		$siteconfigs = $this->siteconfigs;

		$categorys = get_cache('category','content');
		$data_r = $this->db->get_one('topic', array('tid' => $tid));
		$type_r = $this->db->get_one('kind', array('kid' => $data_r['kid']));
		$subtype_r = $this->db->get_one('kind', array('kid' => $subkid));

		$style = $this->db->get_one('kind', array('kid' => $data_r['styleid']));
		$topic_css = $style['remark'];

		$seo_title = $data_r['name'];
		$seo_keywords = $siteconfigs['seo_keywords'];
		$seo_description = $siteconfigs['seo_description'];
		$keyid = 'topic'.$tid;

		$sub_categorys = $this->db->get_list('kind', "`keyid`='$keyid'", '*', 0, 100, 0, 'sort DESC,kid ASC','','kid');

		$_template = $data_r['list_template'];
		if($_template=='') $_template = 'default:list';
		$styles = explode(':',$_template);
		$project_css = isset($styles[0]) ? $styles[0] : 'default';

		$_template = isset($styles[1]) ? $styles[1] : 'list';


		include T('topic',$_template,$project_css);
	}
	/**
	 * 专题内容页
	 */
	public function show() {

		$tcid = intval($GLOBALS['tcid']);
		if(!$tcid) MSG('tcid错误');
		$siteconfigs = $this->siteconfigs;

		$categorys = get_cache('category','content');
		$data_r = $this->db->get_one('topic_content', array('tcid' => $tcid));
		if(!$data_r) {
			MSG('内容不存在');
		}
		if($data_r['status']!=9) {
			MSG('内容审核中');
		}
		$type_r = $this->db->get_one('kind', array('kid' => $data_r['kid1']));
		$subtype_r = $this->db->get_one('kind', array('kid' => $data_r['kid2']));
		$topic_data = $this->db->get_one('topic', array('tid' => $data_r['tid']));

		$style = $this->db->get_one('kind', array('kid' => $topic_data['styleid']));
		$topic_css = $style['remark'];
		$seo_title = $data_r['title'];
		$seo_keywords = $siteconfigs['seo_keywords'];
		$seo_description = $siteconfigs['seo_description'];
		$keyid = 'topic'.$data_r['kid1'];

		$sub_categorys = $this->db->get_list('kind', "`keyid`='$keyid'", '*', 0, 100, 0, 'sort DESC,kid ASC','','kid');

		$_template = $data_r['show_template'];
		if($_template=='') $_template = 'default:show';
		$styles = explode(':',$_template);
		$project_css = isset($styles[0]) ? $styles[0] : 'default';

		$_template = isset($styles[1]) ? $styles[1] : 'show';


		include T('topic',$_template,$project_css);
	}
}
?>