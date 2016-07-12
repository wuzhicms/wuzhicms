<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 线下支付
 */

class WUZHI_offline {
    function __construct($config){
        $this->db = load_class('db');
    }

    function execute($r,$pay_r,$memberinfo) {
        $setting = unserialize($pay_r['setting']);
        include T('pay','pay_offline');
    }
}