<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: jiucai <zhaidw@jiucai.org>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');

//encode gbk
class rebuild extends WUZHI_admin {
	private $db;
	private $search;

	function __construct() {
		$this->db = load_class('db');
        $this->search = load_class('search',M);
	}
	/**
	 *
	 */
	public function index() {

		include $this->template('rebuild');

	}



	/**
	 *
	 */
	public function rebuild() {

        $this->search->delete_index();

        $this->search->create_index();
    }

}