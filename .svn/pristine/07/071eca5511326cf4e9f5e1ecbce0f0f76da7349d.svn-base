<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 发票列表
 */
load_class('foreground', 'member');
class receipt extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
	}
    /**
     * receipt列表
     */
    public function listing() {
        $memberinfo = $this->memberinfo;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('receipt',array('uid'=>$memberinfo['uid']), '*', 0, 20,$page,'id DESC','','orderid');
        $pages = $this->db->pages;
        $total = $this->db->number;
        load_class('form');
        $status_arr = array('未审核','已审核');
        $where = "`uid`=".$memberinfo['uid']." AND `status` IN(1,5)";
        $order_result = $this->db->get_list('order_goods',$where, '*', 0, 100,0,'orderid DESC','','orderid');
        $order_values = array();
        $values = array_keys($result);
        foreach($order_result as $rs) {
            if(!in_array($rs['orderid'],$values)) {
                $order_values[$rs['orderid']] = $rs['remark'];
            }
        }
        include T('receipt','listing');
    }

    /**
     * 申请
     */
    public function apply() {
        $memberinfo = $this->memberinfo;
        $orderid = intval($GLOBALS['orderid']);
        $r = $this->db->get_one('receipt',array('uid'=>$memberinfo['uid'],'orderid'=>$orderid));
        if($r) MSG('您没有需要开具的订单');

        $where = "`uid`=".$memberinfo['uid']." AND `orderid`='$orderid' AND `status` IN(1,5)";
        $order_result = $this->db->get_one('order_goods',$where);
        if(!$order_result) MSG('您没有需要开具的订单');

        if(empty($GLOBALS['title'])) {
            MSG('请填写发票抬头');
        }
        if(empty($GLOBALS['linkman'])) {
            MSG('请填写联系人名称');
        }
        if(empty($GLOBALS['address'])) {
            MSG('请填写联系人地址');
        }
        if(empty($GLOBALS['tel'])) {
            MSG('请填写联系人电话');
        }
        $formdata = array();
        $formdata['orderid'] = $orderid;
        $formdata['title'] = remove_xss($GLOBALS['title']);
        $formdata['linkman'] = remove_xss($GLOBALS['linkman']);
        $formdata['address'] = remove_xss($GLOBALS['address']);
        $formdata['tel'] = remove_xss($GLOBALS['tel']);
        $formdata['zip'] = intval($GLOBALS['zip']);
        $formdata['uid'] = $memberinfo['uid'];
        $formdata['addtime'] = SYS_TIME;

        $this->db->insert('receipt', $formdata);
        MSG('发票申请已提交',HTTP_REFERER);
    }
}