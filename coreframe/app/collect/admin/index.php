<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 采集配置
 */
load_class('admin');

final class index extends WUZHI_admin {

    function __construct() {
        $this->db = load_class('db');
        $this->app_update = load_class('app','appupdate');
    }

	/**
	 * 规则列表
	 */
    function listing() {
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);

		$result = $this->db->get_list('collect_config','', '*', 0, 20,$page, 'configid DESC');
		$pages = $this->db->pages;
		$total = $this->db->number;

		$status = array('未采集或已完成','采集中');
		$pub_status = array('规则编写中','已发布');

		include $this->template('listing');
    }

}
?>