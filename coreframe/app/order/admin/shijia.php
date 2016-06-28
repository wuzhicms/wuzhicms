<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 试驾收集管理
 */
load_class('admin');
class shijia extends WUZHI_admin {
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
        $id = intval($GLOBALS['id']);
        $where = '';
        if($id) {
            $where = "`id`=$id";
        } else {
            $where = '';
        }
        $result = $this->db->get_list('shijia', $where, '*', 0, 20,$page,'did DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('shijia_listing');
    }
    /**
     * zf
     */
    public function relay() {
        $did = intval($GLOBALS['did']);
        $r = $this->db->get_one('shijia', array('did' => $did));
        $keyValue = '';
        $keyType = '';
        if(isset($GLOBALS['keyType'])) {
            $keyType = $GLOBALS['keyType'];
            $keyValue = $GLOBALS['keyValue'];
            if($keyValue) {
                $where = "modelid=11 AND `$keyType` LIKE '%$keyValue%'";
                $result = $this->db->get_list('member', $where, '*', 0, 20, 0, 'uid DESC');
            }
        } elseif(isset($GLOBALS['submit'])) {
            load_function('common','pay');
            $formdata = array();
            $formdata['order_no'] = create_order_no();
            $formdata['to_uid'] = intval($GLOBALS['to_uid']);
            $formdata['username'] = $r['username'];
            $formdata['mobile'] = $r['mobile'];
            $formdata['pinpai'] = $r['pinpai'];
            $formdata['chexing'] = $r['chexing'];
            $formdata['addtime'] = $r['addtime'];
            $formdata['keytype'] = 0;//游客订单
            $formdata['zftime'] = SYS_TIME;
            $this->db->insert('demand_relay', $formdata);
            $formdata2 = array();
            $formdata2['op_uid'] = $_SESSION['uid'];
            $formdata2['to_uid'] = intval($GLOBALS['to_uid']);
            $formdata2['to_username'] = $GLOBALS['to_username'];
            $formdata2['updatetime'] = SYS_TIME;
            $this->db->insert('demand_history', $formdata2);
            $this->db->update('demand', array('flag'=>1),array('did' => $did));
            MSG('发送成功','?m=order&f=demand&v=listing'.$this->su());
        } else {
            $uid = $_SESSION['uid'];
            $where = "op_uid='$uid'";
            $data = $this->db->get_one('demand_history', $where,'*', 0,'hid DESC');
        }
        include $this->template('shijia_relay');
    }
    /**
     * 删除
     */
    public function delete() {
        $did = intval($GLOBALS['did']);
        $this->db->delete('shijia',array('did'=>$did));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}