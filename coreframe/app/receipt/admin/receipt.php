<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 发票管理
 */
load_class('admin');
class receipt extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * receipt列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('receipt', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        $status_arr = array('<b>未开</b>','已开');
        include $this->template('listing');
    }

    /**
     * 审核
     */
    public function check() {
        $id = intval($GLOBALS['id']);
        $status = intval($GLOBALS['status']);
        $formdata = array('status'=>$status);
        $this->db->update('receipt', $formdata, array('id' => $id));
        MSG('设置成功',HTTP_REFERER);
    }
}