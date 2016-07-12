<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 实物订单管理
 */
load_class('admin');
class goods extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 订单列表
     */
    public function listing() {
        $cardtype = isset($GLOBALS['cardtype']) ? $GLOBALS['cardtype'] : -1;
        $keytype = isset($GLOBALS['keytype']) ? $GLOBALS['keytype'] : '';
        $keywords = isset($GLOBALS['keywords']) ? trim($GLOBALS['keywords']) : '';

        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $where = '';
        if($cardtype!=-1) {
            $where = "cardtype='$cardtype'";
        }
        if($keywords) {
            if($keytype==0) {
                $where .= $where ? " AND order_no LIKE '$keywords%'" : "order_no LIKE '$keywords%'";
            } elseif($keytype==1 && $keywords) {
                $r = $this->db->get_one('member', array('username' => $keywords));
                if($r) {
                    $uid = $r['uid'];
                    $where .= $where ?  " AND uid = '$uid'" :  "uid = '$uid'";
                } else {
                    MSG('用户不存在',HTTP_REFERER);
                }
            }
        }
        $result_r = $this->db->get_list('order_goods',$where, '*', 0, 10,$page,'orderid DESC','order_no');
        $total = $this->db->number;
        foreach($result_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result[] = $r;
        }

        $pages = pages($total, $page, 10);

        $status = array();
        $status[1] = '已付款（待预约）';
        $status[2] = '待付款';
        $status[3] = '交易取消';
        $status[5] = '已付款（已预约）';
        $status[6] = '已发货';

        include $this->template('goods_listing');
    }

    /**
     * 发货
     */
    public function send_goods() {
        $orderid = intval($GLOBALS['orderid']);
        if(isset($GLOBALS['submit'])) {
            if(empty($GLOBALS['cardno'])) {
                MSG('请填写预约卡号');
            }
            $cardnos = explode("\n",$GLOBALS['cardno']);
            foreach($cardnos as $cardno) {
                $cardno = trim($cardno);
                $r1 = $this->db->get_one('order_card', array('card_no' => $cardno));
                if(!$r1) MSG($cardno.' 预约卡号不存在！');
                if($r1['uid']) MSG($cardno.' 预约卡已经有主人了，不能重复发送');
            }

            $r = $this->db->get_one('order_goods',array('orderid'=>$orderid));
            foreach($cardnos as $cardno) {
                $cardno = trim($cardno);
                $this->db->update('order_card', array('uid' => $r['uid'], 'batchid' => $r['order_no']), array('card_no' => $cardno));
            }
            $formdata = array();
            $formdata['post_time'] = SYS_TIME;
            $formdata['status'] = 6;
            $formdata['express'] = remove_xss($GLOBALS['express']);
            $formdata['snid'] = remove_xss($GLOBALS['snid']);
            $formdata['note'] = remove_xss($GLOBALS['note']);
            $this->db->update('order_goods',$formdata,array('orderid'=>$orderid));
            //


            MSG(L('operation_success').'<script>top.window.frames["iframeid"].location.reload();top.dialog.get(window).close().remove();</script>');
        } else {
            $r = $this->db->get_one('order_goods',array('orderid'=>$orderid));
            $er = $this->db->get_one('express_address',array('addressid'=>$r['addressid']));
            $result = $this->db->get_list('express', '', '*', 0, 50,0,'eid ASC');
            include $this->template('send_goods');
        }
    }

    /**
     * 查看
     */
    public function view() {
        $orderid = intval($GLOBALS['orderid']);
        $r = $this->db->get_one('order_goods',array('orderid'=>$orderid));
        $er = $this->db->get_one('express_address',array('addressid'=>$r['addressid']));
        include $this->template('view');
    }
}