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
class favorite extends WUZHI_foreground {
 	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 收藏的套餐
     */
	public function tuan() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $result_rs = $this->db->get_list('favorite', "`uid`='$uid' AND `type`=1", '*', 0, 20,$page,'fid DESC');
        $result = array();
        foreach($result_rs as $r) {
            $tr=$this->db->get_one('tuangou',array('id'=>$r['keyid']));
            $r['price'] =  $tr['price'];
            $r['price_old'] =  $tr['price_old'];
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','favorite_tuan');
	}

    /**
     * 收藏的机构
     */
    public function mec() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $uid = $this->memberinfo['uid'];
        $publisher = $this->memberinfo['username'];
        $result_rs = $this->db->get_list('favorite', "`uid`='$uid' AND `type`=2", '*', 0, 20,$page,'fid DESC');
        $result = array();
        foreach($result_rs as $r) {
            $mecr=$this->db->get_one('mec',array('id'=>$r['keyid']));
            $r['thumb'] =  $mecr['thumb'];
            $r['address'] =  $mecr['address'];
            $r['tuan_list'] =  $tuan_list;
            $result[] = $r;
        }


        $pages = $this->db->pages;
        $total = $this->db->number;
        include T('member','favorite_mec');
    }
    public function tuangou_add() {
        $uid = $this->memberinfo['uid'];
        $id = intval($GLOBALS['id']);
        if(!$id) exit('0');
        $r = $this->db->get_one('favorite', array('uid' => $uid,'type'=>1,'keyid'=>$id));
        if(!$r) {
            $mec_r = $this->db->get_one('tuangou', array('id'=>$id),'title,url,favorite_nums');
            if(!$mec_r) exit('-1');
            $formdata = array();
            $formdata['type'] = 1;
            $formdata['title'] = $mec_r['title'];
            $formdata['url'] = $mec_r['url'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['uid'] = $uid;
            $formdata['keyid'] = $id;
            $this->db->insert('favorite', $formdata);
            $this->db->update('tuangou', array('favorite_nums'=>$mec_r['favorite_nums']+1), array('id' => $id));
        }
        exit('1');
    }
    public function mec_add() {
        $uid = $this->memberinfo['uid'];
        $id = intval($GLOBALS['id']);
        if(!$id) exit('0');
        $r = $this->db->get_one('favorite', array('uid' => $uid,'type'=>2,'keyid'=>$id));
        if(!$r) {
            $mec_r = $this->db->get_one('mec', array('id'=>$id),'title,url,favorite_nums');
            if(!$mec_r) exit('-1');
            $formdata = array();
            $formdata['type'] = 2;
            $formdata['title'] = $mec_r['title'];
            $formdata['url'] = $mec_r['url'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['uid'] = $uid;
            $formdata['keyid'] = $id;
            $this->db->insert('favorite', $formdata);
            $this->db->update('mec', array('favorite_nums'=>$mec_r['favorite_nums']+1), array('id' => $id));
        }
        exit('1');
    }
    public function delete() {
        $fid = intval($GLOBALS['fid']);
        $uid = $this->memberinfo['uid'];
        $this->db->delete('favorite',array('fid'=>$fid,'uid'=>$uid));
        MSG('删除成功',HTTP_REFERER);
    }
}