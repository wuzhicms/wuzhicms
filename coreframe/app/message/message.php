<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class message extends WUZHI_foreground{
 	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function listing() {
        $seo_title = '私信';
        $memberinfo = $this->memberinfo;
        $uid = $this->memberinfo['uid'];
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        if(isset($GLOBALS['keyword']) && !empty($GLOBALS['keyword'])) {
            $keyword = sql_replace($GLOBALS['keyword']);
            $where = "`touid`='$uid' AND (`username`='$keyword' or `content` LIKE '%$keyword%')";
        } else {
           $where = array('touid'=>$memberinfo['uid']);
        }

        $result = $this->db->get_list('message',$where, '*', 0, 10,$page,'id DESC');
        $this->db->update('message', array('status'=>0), array('touid' => $uid,'status'=>1));
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('message','listing');
	}
    public function add() {
        $seo_title = '发私信';
        $memberinfo = $this->memberinfo;
        if(isset($GLOBALS['submit'])) {
            $tousername = sql_replace($GLOBALS['tousername']);
            if($tousername=='') MSG('用户名错误');
            $r = $this->db->get_one('member',array('username'=>$tousername));
            if(!$r) MSG('用户名错误');
            $content = remove_xss($GLOBALS['content']);
            $this->db->insert('message',array('uid'=>$memberinfo['uid'],'touid'=>$r['uid'],'username'=>$memberinfo['username'],'addtime'=>SYS_TIME,'content'=>$content));
            MSG('私信发送成功',HTTP_REFERER);
        } else {
            $username = isset($GLOBALS['username']) ? remove_xss($GLOBALS['username']) : '';
            include T('message','add');
        }

    }

    /**
     * 清空
     */
    public function make_empty() {
        $memberinfo = $this->memberinfo;
        $this->db->delete('message',array('touid'=>$memberinfo['uid']));
        MSG('已清空','?m=message&f=message&v=listing');
    }
}