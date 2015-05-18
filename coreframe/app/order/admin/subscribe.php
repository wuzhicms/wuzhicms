<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 体检预约管理
 */
load_class('admin');
class subscribe extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        $cardid = intval($GLOBALS['cardid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('order_subscribe', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('subscribe_listing');
    }
    public function confirm() {
        $id = intval($GLOBALS['id']);
        $this->db->update('order_subscribe', array('status'=>1), array('id' => $id,'status'=>6));
        MSG('预约单确认成功',HTTP_REFERER);
    }
    public function setstatus() {
        $id = intval($GLOBALS['id']);
        $status = intval($GLOBALS['status']);
        $this->db->update('order_subscribe', array('status'=>$status), array('id' => $id));
        MSG('设置成功',HTTP_REFERER);
    }

}