<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 设置
 */
load_class('admin');

class index extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 基本设置
     */
    public function init() {
        if(isset($GLOBALS['submit'])) {
            $setting = array_map('remove_xss',$GLOBALS['form']);
            set_cache('sms_config',$setting,'sms');
            MSG('更新成功',HTTP_REFERER);
        } else {
            $setting = get_cache('sms_config','sms');
            include $this->template('setting');
        }
    }
}