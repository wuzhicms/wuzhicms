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

final class collect extends WUZHI_admin {

    function __construct() {
        $this->db = load_class('db');
        $this->app_update = load_class('app','appupdate');
    }

	/**
	 * 获取网址规则配置
	 */
    function get_urls_config() {
		$configid = $GLOBALS['configid'];
		$data = $this->db->get_one('collect_config', array('configid' => $configid));
		include $this->template('get_urls_config');
    }

}
?>