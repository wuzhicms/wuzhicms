<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class member extends WUZHI_foreground{
	function __construct() {
		$this->member = load_class('member', 'member');
		load_function('common', 'member');
		$this->member_setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function getcode(){
		$memberinfo = $this->memberinfo;
		$setting = get_cache('setting','ppc');

		include T('ppc','getcode');
	}
    public function stat(){
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $setting = get_cache('setting','ppc');
        $starttime = strtotime(date('Y-m-d'));
        $where = "`uid`='$uid' AND `addtime`>$starttime";
        $toay_count = $this->db->count_result('ppc',$where);
        $where = "`uid`='$uid'";
        $tatal_count = $this->db->count_result('ppc',$where);
        $where = "`ppc_uid`='$uid'";
        $total_member = $this->db->count_result('ppc_member',$where);

        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('ppc', '', '*', 0, 20,$page,'id DESC');
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }

        $pages = $this->db->pages;
        $total = $this->db->number;

        include T('ppc','stat');
    }

}