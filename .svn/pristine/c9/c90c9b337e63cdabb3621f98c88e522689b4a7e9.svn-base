<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 后台操作日志
 */
load_class('admin');

class logs extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 日志列表
	 */
	public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
		$result = $this->db->get_list('logs', '', '*', 0, 20,$page,'id DESC');
		$pages = $this->db->pages;

		include $this->template('logs_listing');
	}

    /**
     * 后台登录记录
     */
    public function login_listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('logintime', "status<2", '*', 0, 50,$page,'id DESC');
        $pages = $this->db->pages;
        include $this->template('logintime');
    }
}