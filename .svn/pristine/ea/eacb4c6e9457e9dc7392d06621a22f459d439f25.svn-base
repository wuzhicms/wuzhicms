<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 杂项
 */
load_class('admin');
class sundry extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}


    public function listing() {
        $show_dialog = 1;
        $result = array();
        $stype = isset($GLOBALS['stype']) ? intval($GLOBALS['stype']) : 1;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $keywords = isset($GLOBALS['keywords']) ? sql_replace($GLOBALS['keywords']) : '';
        $start = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
        $end = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';

        $modelid = $GLOBALS['modelid'];
        $form = load_class('form');
        $where = array('modelid'=>$modelid);
        $categorys = $this->db->get_list('category', $where, '*', 0, 200, 0, '', '', 'cid');

        $options = array(1=>'标题',2=>'描述',3=>'发布人');
        $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
        $master_table = $model_r['master_table'];
        $where = "status=9";

        $model_r = $this->db->get_one('model',array('modelid'=>$modelid));

        $master_table = $model_r['master_table'];
        if($cid) {
            $where = "`cid`='$cid' AND `status`='$status'";
        } else {
            $where = "`status`='$status'";
        }

        switch($stype) {
            case 1:
                if($keywords) $where .= " AND `title` LIKE '%$keywords%'";
                break;
            case 2:
                if($keywords) $where .= " AND `remark` LIKE '%$keywords%'";
                break;
            case 3:
                if($keywords) $where .= " AND `publisher`='$keywords'";
                break;
        }
        if($start) {
            $where .= " AND `addtime`>'".strtotime($start)."'";
        }
        if($end) {
            $where .= " AND `addtime`<'".strtotime($end)."'";
        }
        $page = intval($GLOBALS['page']);
        $page = max($page,1);

        $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'sort DESC');
        $pages = $this->db->pages;

        $form = load_class('form');

        include $this->template('sundry_listing');
    }
}