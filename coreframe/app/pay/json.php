<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class json{

	function __construct() {
        $this->db = load_class('db');
    }
	public function set_payment(){
        $uid = get_cookie('_uid');
        if(!$uid) exit('-1');
        $order_no = strip_tags($GLOBALS['order_no']);
        $r = $this->db->get_one('pay', array('order_no' => $order_no,'uid'=>$uid));
        if($r && $r['status']==6) {
            $payment = intval($GLOBALS['payment']);
            if($payment!=1) {
                $this->db->update('pay', array('payment'=>$payment), array('id' => $r['id']));
            }
        }
        echo '100';
    }
}