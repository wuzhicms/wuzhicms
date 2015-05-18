<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 积分兑换订单管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 订单列表
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('order_point', '', '*', 0, 20,$page,'orderid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $status = array();
        $status[1] = '待发货';
        $status[2] = '已发货';
        $status[3] = '订单完成';

        include $this->template('listing');
    }

    /**
     * 发货
     */
    public function send() {
        $orderid = intval($GLOBALS['orderid']);
        if(isset($GLOBALS['submit'])) {

            $formdata = array();
            $formdata['post_time'] = SYS_TIME;
            $formdata['status'] = 3;
            $formdata['express'] = $GLOBALS['express'];
            $formdata['snid'] = remove_xss($GLOBALS['snid']);
            $formdata['note'] = remove_xss($GLOBALS['note']);
            $this->db->update('order_point',$formdata,array('orderid'=>$orderid));
            MSG(L('operation_success').'<script>top.window.frames["iframeid"].location.reload();top.dialog.get(window).close().remove();</script>');
        } else {
            $r = $this->db->get_one('order_point',array('orderid'=>$orderid));
            $er = $this->db->get_one('express_address',array('addressid'=>$r['addressid']));

            $result = $this->db->get_list('express', '', '*', 0, 50,0,'eid ASC');
            include $this->template('send');
        }
    }

    /**
     * 查看
     */
    public function view() {
        $orderid = intval($GLOBALS['orderid']);
        $r = $this->db->get_one('order_point',array('orderid'=>$orderid));
        include $this->template('view');
    }
}