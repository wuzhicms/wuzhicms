<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 商家订单
 */
load_class('foreground', 'member');
class biz_demand extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
        //企业用户权限检查
        if($this->memberinfo['modelid']!=11 || !$this->memberinfo['checkmec']) {
            MSG('您的帐号还未通过企业认证审核！如需帮助请联系客服。');
        }
	}

	/**
	 * 列表
	 */
	public function listing() {
		$memberinfo = $this->memberinfo;
		$uid = $memberinfo['uid'];
		$publisher = $memberinfo['username'];
		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$where = array('to_uid'=>$uid);
		$result = $this->db->get_list('demand_relay',$where, '*', 0, 30,$page,'rid DESC');
		$pages = $this->db->pages;
		$total = $this->db->number;

		include T('order','demand_listing');
	}
}