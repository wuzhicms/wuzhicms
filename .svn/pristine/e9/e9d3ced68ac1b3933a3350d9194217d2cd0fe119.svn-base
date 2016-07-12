<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 *
 */

class WUZHI_surplus {
    function __construct($config){
        $this->db = load_class('db');
    }

    function execute($r,$pay_r,$memberinfo) {
        if($r['money']>$memberinfo['money']) {
            MSG('您的余额不足，请先充值或选择其他方式付款！');
        }
        $id = $r['id'];
        $money = $r['money'];
        $this->db->update('member',"`money`=(`money`-$money)",array('uid'=>$memberinfo['uid']));
        $this->db->update('pay',array('status'=>1),array('id'=>$id,'uid'=>$memberinfo['uid']));
        MSG('支付成功！','index.php?m=pay&f=payment&v=listing');
    }
}