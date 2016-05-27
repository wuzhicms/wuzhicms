<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_function('common', M);

class yuding_config extends WUZHI_admin
{
    private $db;

    function __construct()
    {
        $this->db = load_class('db');
        $GLOBALS['_menuid'] = isset($GLOBALS['_menuid']) ? intval($GLOBALS['_menuid']) : '';
    }

    /**
     * 模块配置
     *
     * @author tuzwu
     * @createtime
     * @modifytime
     * @param
     * @return
     */
    public function set() {
        if (isset($GLOBALS['submit'])) {
            set_cache('yuding_config', $GLOBALS['setting'],'pay');
            MSG(L('operation_success'), HTTP_REFERER, 3000);
        }
        else {
            $show_dialog = 1;
            load_class('form');
            $setting = get_cache('yuding_config','pay');

            include $this->template('yuding_config', 'pay');
        }
    }
}