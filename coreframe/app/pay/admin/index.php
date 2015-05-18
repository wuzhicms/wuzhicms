<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 在线支付
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	private $payments;
	private $status_arr;

	function __construct() {
		$this->db = load_class('db');
        $this->payments_res = $this->db->get_list('payment');
        $this->payments = key_value($this->payments_res,'id','name');
        $this->payments[0] = '异常';
        $this->status_arr = array(0=>'回收站',1=>'交易成功',2=>'交易失败',3=>'交易错误',4=>'交易超时',5=>'交易取消',6=>'等待用户付款',7=>'待商家发货',8=>'待用户确认收货',9=>'退款成功',10=>'交易进行中');
	}
    /**
     * 支付列表
     */
    public function listing() {
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('pay', "status>0", '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 后台充值
     */
    public function add() {
        $config = $this->db->get_one('payment',array('id'=>2));
        if($config['status']!=1) MSG('不支持后台充值，开启方式：充值配置中开启后台充值功能');
        if(isset($GLOBALS['submit'])) {
            load_function('common','pay');
            $formdata = array();
            $formdata['username'] = remove_xss($GLOBALS['username']);
            $mr = $this->db->get_one('member',array('username'=>$formdata['username']));

            if(!$mr) MSG('用户不存在');
            $formdata['uid'] = $mr['uid'];
            $plus_minus = intval($GLOBALS['plus_minus']);
            $money = $formdata['money'] = sprintf("%.2f",substr(sprintf("%.3f", $GLOBALS['money']), 0, -2));

            $formdata['order_no'] = create_order_no();
            $formdata['note'] = remove_xss($GLOBALS['note']);
            $formdata['plus_minus'] = $plus_minus;
            $formdata['adminuid'] = $_SESSION['uid'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['paytime'] = SYS_TIME;
            $formdata['endtime'] = SYS_TIME;
            $formdata['quantity'] = 1;
            $formdata['status'] = 1;
            $formdata['payment'] = 1;
            $username = get_cookie('username');
            if($plus_minus==1) {
                $plus_minus_type = '充值';
                $formdata['payname'] = $username.'为用户'.$plus_minus_type;
                $linkageid = $this->db->insert('pay',$formdata);
                $this->db->update('member', "`money`=(`money`+$money)", array('uid' =>$mr['uid']));
            } else {
                $plus_minus_type = '扣款';
                $formdata['payname'] = $username.'为用户'.$plus_minus_type;
                $linkageid = $this->db->insert('pay',$formdata);
                $this->db->update('member', "`money`=(`money`-$money)", array('uid' =>$mr['uid']));
            }


            MSG(L('operation success'));
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $options = $this->db->get_list('kind',array('keyid'=>'link'));
            $options = key_value($options,'kid','name');
            include $this->template('add');
        }
    }

    /**
     * 修改价格
     */
    public function edit() {

        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('pay',array('id'=>$id));

        if(isset($GLOBALS['submit'])) {
            if($r['status']!=6) MSG(L('当前状态无法修改价格！'));
            $formdata = array();
            $type = intval($GLOBALS['type']);
            $money = intval($GLOBALS['money']);
            $_money = $r['money'];
            if(($money>$_money) && $type==1) {
                $_money = $r['money'];
            } else {
                if($type==1) {
                    $_money = $_money-$money;
                } else {
                    $_money = $_money+$money;
                }
            }


            $this->db->update('pay',array('money'=>$_money),array('id'=>$id));

            MSG(L('operation_success').'<script>$("#edit", top.window.frames["iframeid"].document).css("background-color", "#EFD04C");top.dialog.get(window).close().remove();</script>');
        } else {
            $show_formjs = 1;

            include $this->template('edit');
        }
    }
    /**
     * 删除支付记录到回收站
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->update('pay',array('status'=>0),array('id'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 查看交易详情
     */
    public function view() {
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('pay',array('id'=>$id));
        include $this->template('view');
    }
    /**
     * 修改交易备注
     */
    public function edit_note() {
        $id = intval($GLOBALS['id']);
        $note = remove_xss($GLOBALS['note']);
        $this->db->update('pay',array('note'=>$note),array('id'=>$id));
        MSG(L('operation success'),HTTP_REFERER);
    }
}