<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 好友圈
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class friend extends WUZHI_foreground {
 	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 推荐的用户
     */
	public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];


        if($page>1)  {
            $rand_num = 2;
        } else {
            $rand_num = rand(1,2);
        }
        if($rand_num==1) {
            $result_rs = $this->db->get_list('friend_elite', "`cityid` IN (0)", '*', 0, 20,$page,'id DESC');
        } else {
            $result = $this->db->get_list('member', "", '*', 0, 1000,0,'uid DESC','','uid');
            shuffle($result);
            $n = 1;
            foreach($result as $key) {
                if($n>15) continue;
                $result_rs[] = $key;
                $n++;
            }
        }

        $result = array();
        foreach($result_rs as $r) {
            if($r['modelid']!=$this->memberinfo['modelid']) continue;
            $r['member_info']=$this->db->get_one('member',array('uid'=>$r['uid']));
            $v1=$this->db->get_one('myfriend',array('myuid'=>$r['uid'],'uid'=>$uid));
            $v2=$this->db->get_one('myfriend',array('myuid'=>$uid,'uid'=>$r['uid']));
            if($v2 && $v1) {
                //相互关注
                $r['rtype']=1;
            } elseif($v2) {
                $r['rtype']=2;//已添加
            } elseif($v1) {
                $r['rtype']=3;//请求添加
            }
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','friend_listing');
	}

    /**
     * 搜索用户
     */
    public function search() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $username = isset($GLOBALS['username']) ? sql_replace($GLOBALS['username']) : MSG('请输入会员名');
        $cityid = get_cookie('cityid');
        $result_rs = $this->db->get_list('member', "`username` LIKE '%$username%'", '*', 0, 20,$page,'uid DESC');
        $result = array();
        foreach($result_rs as $r) {
            $r['member_info']=$r;
            $v1=$this->db->get_one('myfriend',array('myuid'=>$r['uid'],'uid'=>$uid));
            $v2=$this->db->get_one('myfriend',array('myuid'=>$uid,'uid'=>$r['uid']));
            if($v2 && $v1) {
                //相互关注
                $r['rtype']=1;
            } elseif($v2) {
                $r['rtype']=2;//已添加
            } elseif($v1) {
                $r['rtype']=3;//请求添加
            }
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','friend_search_listing');
    }

    /**
     * 取消关注
     */
    public function cancelgz() {
        $uuid = intval($GLOBALS['uuid']);
        $uid = $this->memberinfo['uid'];
        $this->db->delete('myfriend',array('myuid'=>$uid,'uid'=>$uuid));
        exit('1');
    }

    /**
     * 关注
     */
    public function guanzhu() {
        $uuid = intval($GLOBALS['uuid']);
        $uid = $this->memberinfo['uid'];
        $r = $this->db->get_one('myfriend',array('myuid'=>$uid,'uid'=>$uuid));
        if(!$r) $this->db->insert('myfriend',array('myuid'=>$uid,'uid'=>$uuid));
        exit('1');
    }
    public function myfans() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $cityid = get_cookie('cityid');
        $result_rs = $this->db->get_list('myfriend',array('uid'=>$uid), '*', 0, 20,$page);
        $result = array();
        foreach($result_rs as $r) {
            $r['member_info']=$this->db->get_one('member',array('uid'=>$r['uid']));
            $v1=$this->db->get_one('myfriend',array('myuid'=>$uid,'uid'=>$r['uid']));
            if($v1) {
                //相互关注
                $r['rtype']=1;
            } else {
                $r['rtype']=3;//已添加
            }
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','myfans_listing');
    }
    public function myfriend() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $cityid = get_cookie('cityid');
        $result_rs = $this->db->get_list('myfriend',array('myuid'=>$uid), '*', 0, 20,$page);
        $result = array();
        foreach($result_rs as $r) {
            $r['member_info']=$this->db->get_one('member',array('uid'=>$r['uid']));
            $v1=$this->db->get_one('myfriend',array('myuid'=>$r['uid'],'uid'=>$uid));
            if($v1) {
                //相互关注
                $r['rtype']=1;
            } else{
                $r['rtype']=2;//已添加
            }
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','myfriend_listing');
    }
}