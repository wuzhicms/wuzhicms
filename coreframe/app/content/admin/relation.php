<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 相关内容显示
 */
load_class('admin');
class relation extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    public function manage() {
        $where = '';
        $keywords = '';
        $cid = intval($GLOBALS['cid']);

        if(isset($GLOBALS['keywords'])) {
            if(strtolower(CHARSET)=='gbk') {
                $keywords = iconv('utf-8','gbk',$GLOBALS['keywords']);
            } else {
                $keywords = $GLOBALS['keywords'];
            }
            $keywords = sql_replace($keywords);
            $GLOBALS['keytype'] = 'keywords';
        }
        $show_dialog = 1;
        $form = load_class('form');
        $where = array('keyid'=>M);
        $categorys = $this->db->get_list('category', $where, '*', 0, 200, 0, '', '', 'cid');
        foreach($categorys as $_cid=>$_value) {
            if($_cid==$cid) $categorys[$_cid]['selected'] = 'selected';
        }
        include $this->template('relation_manage');
    }

    public function listing() {
        $where = '';
        $keywords = '';
        $cid = intval($GLOBALS['cid']);
        $categorys = get_cache('category','content');
        $modelid = $categorys[$cid]['modelid'];

        $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
        $master_table = $model_r['master_table'];
        $where = "cid='$cid'";

        if(isset($GLOBALS['keywords'])) {
            if(isset($GLOBALS['charset']) && strtolower(CHARSET)=='gbk') {
                $keywords = iconv('utf-8','gbk',$GLOBALS['keywords']);
            } else {
                $keywords = $GLOBALS['keywords'];
            }
            $keywords = trim(sql_replace($keywords));
            // $master_table = 'content_share';
            if(isset($GLOBALS['keytype']) && $GLOBALS['keytype']=='username') {
                $where .= " AND `publisher` = '$keywords'";
            } else {
                $GLOBALS['keytype'] = 'keywords';
                $where .= "AND `title` LIKE '%$keywords%'";
            }
        }
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $result = $this->db->get_list($master_table,$where, '*', 0, 10,$page,'id DESC');

        $form = load_class('form');

        include $this->template('relation_listing');
    }
}