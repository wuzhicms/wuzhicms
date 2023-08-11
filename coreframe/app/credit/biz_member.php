<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class biz_member extends WUZHI_foreground{
    private $payments;
    private $status_arr;
	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function listing(){
        $seo_title = '账户积分';
		$memberinfo = $this->memberinfo;
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : -1;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('credit', "`uid`='".$memberinfo['uid']."'", '*', 0, 20,$page,'jid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $point_config = get_cache('point_config');
		$categorys = get_cache('category','content');

		foreach($result as $_k=>$r) {
			$r2 = $this->db->get_one('credit_data', array('jid' => $r['jid']));
			$result[$_k]['content'] = $r2['content'];
			$result[$_k]['catname'] = $categorys[$r['cid']]['name'];
		}
		include T('credit','biz_listing');
	}
    //查看柱状图
    public function lines() {
        $memberinfo = $this->memberinfo;
		$dayid = SYS_TIME-86400*31;
		$dayid = date('Ymd');
		$charts = $this->db->get_list('credit_day', "`uid`='".$memberinfo['uid']."' AND `dayid`<$dayid", '*', 0, 31,0,'cdid ASC');

		include T('credit','biz_lines');
    }
}