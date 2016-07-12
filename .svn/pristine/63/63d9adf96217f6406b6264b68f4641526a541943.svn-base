<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 旅游报名
 */
load_class('admin');
class sign_up extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        $fieldtypes = array('订单id','提交人姓名','提交人电话');
        $status_arr = $this->status_arr;
        $status = $GLOBALS['status'];
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $id = intval($GLOBALS['id']);
        if($status) {
            $where = 'status='.$status;
        } else {
            $where = 'status>-1';
        }
        if($id) {
            $where .= " AND `id`='$id'";
        }
        $keyValue = strip_tags($GLOBALS['keyValue']);
        $fieldtype = intval($GLOBALS['fieldtype']);
        if($keyValue) {
            switch($fieldtype) {
                case 0:
                    $where .= " AND `order_no`='$keyValue'";
                    break;
                case 1:
                    $where .= " AND `truename`='$keyValue'";
                    break;
                case 2:
                    $where .= " AND `mobile`='$keyValue'";
                    break;
            }
        }
        $starttime = '';
        $endtime = '';
        if($GLOBALS['starttime']) {
            $starttime = strtotime($GLOBALS['starttime']);
            $where .= " AND `addtime`>'$starttime'";
        }
        if($GLOBALS['endtime']) {
            $endtime = strtotime($GLOBALS['endtime']);
            $where .= " AND `endtime`<'$endtime'";
        }
        $result = $this->db->get_list('tour_signup', $where, '*', 0, 20,$page,'tsid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $status_arr = array();
        $status_arr[0] = '未支付';
        $status_arr[1] = '已完成支付';
        load_class('form');
        include $this->template('sign_up_listing');
    }
    /**
     * 参团人列表
     */
    public function member() {
        $status_arr = $this->status_arr;
        $tsid = intval($GLOBALS['tsid']);
        $cardtypes = array('','身份证','护照');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('tour_signup_member', array('tsid'=>$tsid), '*', 0, 100,0,'smid ASC');
        $result2 = $this->db->get_list('tour_signup',array('tsid'=>$tsid), '*', 0, 1,0,'tsid DESC');
        if($result2[0]['cid']==52) {
            $data = $this->db->get_one('heighendtourism', array('id' => $result2[0]['id']));
        } else {
            $data = $this->db->get_one('tour', array('id' => $result2[0]['id']));
        }
        include $this->template('sign_up_member');
    }
    /**
     * 删除
     */
    public function delete() {
        $tsid = intval($GLOBALS['tsid']);
        $this->db->delete('tour_signup',array('tsid'=>$tsid));
        $this->db->delete('tour_signup_member',array('tsid'=>$tsid));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}