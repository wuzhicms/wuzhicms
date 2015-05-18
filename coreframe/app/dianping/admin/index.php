<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 点评信息管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $where = "`keyid` LIKE 'mec%'";
        $result = $this->db->get_list('dianping', $where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }

        include $this->template('listing');
    }
    /**
     * 列表
     */
    public function taocan_listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $where = "`keyid` LIKE 'tuan%'";
        $result = $this->db->get_list('dianping', $where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }

        include $this->template('listing');
    }
    /**
     * 删除点评
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('dianping',array('id'=>$id));
        exit('1');
    }
}