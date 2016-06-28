<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 收藏夹
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class biz_favorite extends WUZHI_foreground {
 	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 收藏列表
     */
	public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $result = $this->db->get_list('favorite', "`uid`='$uid'", '*', 0, 20,$page,'fid DESC');
print_r($uid);
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','biz_favorite_listing');
	}

    /**
     * 添加到收藏
     */
    public function add() {
        $formdata = array();
        $formdata['type'] = intval($GLOBALS['type']);
        $formdata['title'] = strip_tags($GLOBALS['title']);
        $formdata['url'] = strip_tags($GLOBALS['url']);
        $formdata['addtime'] = SYS_TIME;
        $formdata['uid'] = $this->memberinfo['uid'];
        $formdata['keyid'] = strip_tags($GLOBALS['keyid']);
        $r = $this->db->get_one('favorite', array('type' => $formdata['type'],'keyid'=>$formdata['keyid']));
        if($r) {
            exit('0');
        } else {
            $this->db->insert('favorite',$formdata);
            exit('100');
        }
    }

    public function delete() {
        $fid = intval($GLOBALS['fid']);
        $uid = $this->memberinfo['uid'];
        $this->db->delete('favorite',array('fid'=>$fid,'uid'=>$uid));
        MSG('删除成功',HTTP_REFERER);
    }
}