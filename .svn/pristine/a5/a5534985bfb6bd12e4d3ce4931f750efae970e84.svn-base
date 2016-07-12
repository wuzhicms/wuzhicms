<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');


class WUZHI_pay_callback {

    function __construct(){
        $this->db = load_class('db');
        $this->credit_api = load_class('credit_api','credit');
    }

    function update($order_no,$pay_res = ''){
        if($pay_res['original_id']) {
            $r = $this->db->get_one('tuangou', array('id' => $pay_res['original_id']));
            if($r['return_point']) {

                $this->credit_api->handle($pay_res['uid'], '+', $r['return_point'], '积分返还：购买商品－'.$r['title']);
            }
        }
        $this->db->update('tour_signup', array('status'=>1), array('order_no' => $order_no));
        return true;
    }
}
?>
