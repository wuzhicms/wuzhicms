<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class myissue extends WUZHI_foreground {
 	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

	public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $result = $this->db->get_list('guestbook', "`publisher`='$publisher'", '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('guestbook','myissue_listing');
	}
    public function ask() {
        $formdata = array();
        $formdata['title'] = isset($GLOBALS['title']) ? remove_xss($GLOBALS['title']) : strcut($GLOBALS['content'],80);
        $formdata['content'] = remove_xss($GLOBALS['content']);
        $formdata['addtime'] = SYS_TIME;
        $formdata['publisher'] = $this->memberinfo['username'];
        $formdata['ip'] = get_ip();
        $this->db->insert('guestbook', $formdata);
        MSG('您的提问已经提交，我们的专家会尽快给您回复',$GLOBALS['forward']);
    }
    public function newask() {
        include T('guestbook','newask');
    }
}