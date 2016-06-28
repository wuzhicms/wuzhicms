<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//

class WUZHI_pay_callback {

    function __construct(){
        $this->db = load_class('db');
    }

    function update($order_no){
        $r = $this->db->get_one('pay', array('order_no' => $order_no));
        if($r['status']==1) {
            $mr = $this->db->get_one('member', array('uid' => $r['uid']));

            $formdata = array();
            $formdata['ext_groupid1'] = 7;
            if($mr['ext_groupid1_end']<SYS_TIME) {
                $formdata['ext_groupid1_start'] = SYS_TIME;
                $formdata['ext_groupid1_end'] = SYS_TIME+31536000;
            } else {
                $formdata['ext_groupid1_end'] = $mr['ext_groupid1_end']+31536000;
            }
            $this->db->update('member', $formdata, array('uid' => $r['uid']));
        }
        return true;
    }
}
?>
