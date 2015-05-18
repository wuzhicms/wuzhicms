<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 应用商城
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;

	function __construct() {
        MSG("<cite class='appshopmsg'>应用商城邀您成为开发者，销售分成高达60%<br>目前支持电话:010-82463345<br>邮件:zhw@wuzhicms.com 方式申请！</cite>");
		$this->db = load_class('db');
	}
    public function index() {


    }

}