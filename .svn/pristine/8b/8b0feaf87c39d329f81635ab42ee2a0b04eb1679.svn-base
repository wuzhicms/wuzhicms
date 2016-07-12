<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 优惠券管理
 */
load_class('foreground', 'member');
class coupon extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
	}
    /**
     * 列表
     */
    public function listing() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $endtime = SYS_TIME;
        $where = "`uid`='$uid' AND `status`=0 AND `endtime`>$endtime";
        $result1 = $this->db->get_list('coupon_card_active',$where, '*', 0, 50,0,'aid DESC');

        $where = "`uid`='$uid' AND `status`=1";
        $result2 = $this->db->get_list('coupon_card_active',$where, '*', 0, 50,0,'aid DESC');

        $where = "`uid`='$uid' AND `status`=0 AND `endtime`<$endtime";
        $result3 = $this->db->get_list('coupon_card_active',$where, '*', 0, 50,0,'aid DESC');

        include T('coupon','listing');
    }

    /**
     * 优惠券激活
     */
    public function getit() {
        $order_no = sql_replace($GLOBALS['order_no']);
        $r = $this->db->get_one('coupon_card', "`card_no`='$order_no'");
        if($r) {
            if($r['status']==2) {
                MSG('您输入的优惠券已经被激活，不能重复使用');
            }
            $memberinfo = $this->memberinfo;
            $formdata = array();
            $formdata['cardid'] = $r['cardid'];
            $formdata['card_no'] = $r['card_no'];
            $formdata['title'] = $r['title'];
            $formdata['remark'] = $r['remark'];
            $formdata['mount'] = $r['mount'];
            $formdata['id'] = $r['id'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['endtime'] = $r['endtime'];
            $formdata['url'] = $r['url'];
            $formdata['uid'] = $memberinfo['uid'];
            $formdata['status'] = 0;
            $this->db->insert('coupon_card_active', $formdata);
            $formdata2 = array();
            if($r['usetype']) {
                $formdata2 = array('uid'=>$memberinfo['uid']);
            } else {
                //仅能使用一次
                $formdata2 = array('uid'=>$memberinfo['uid'],'status'=>2);
            }
            $this->db->update('coupon_card',$formdata2, array('cardid' => $r['cardid']));
            MSG('优惠券激活成功','index.php?m=coupon&f=coupon&v=listing');
        } else {
            MSG('您输入的优惠券不存在');
        }
    }
}