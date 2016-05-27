<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class affiche extends WUZHI_foreground{
 	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function sys() {
        $seo_title = '系统公告';
        $memberinfo = $this->memberinfo;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('affiche',"`endtime`>".SYS_TIME." AND `status` IN(1,2)", '*', 0, 5,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('affiche','member_listing');
	}
    public function show() {
        $seo_title = '系统公告';
        $GLOBALS['acbar'] = 4;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG('参数错误');
        $memberinfo = $this->memberinfo;
        $r = $this->db->get_one('affiche',array('id'=>$id));
        include T('affiche','member_show');
    }
}