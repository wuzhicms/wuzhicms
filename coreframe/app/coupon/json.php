<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class json {
    private $db;
    public function __construct() {
        $this->db = load_class('db');
    }

    public function checkcard() {
        if(isset($GLOBALS['param'])) {
            $order_no = sql_replace($GLOBALS['param']);
            $r = $this->db->get_one('coupon_card', "`card_no`='$order_no'");
            if($r && $r['status']!=3) {
                echo '{"info":"可以使用！","status":"y"}';
            } else {
                echo '{"info":"优惠券信息错误！","status":"n"}';
            }
        } else {

        }
    }
}
?>