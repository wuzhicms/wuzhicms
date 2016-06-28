<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class biz_attention extends WUZHI_foreground{
 	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function listing() {
        $seo_title = '我的关注';
        $memberinfo = $this->memberinfo;
        $uid = $this->memberinfo['uid'];
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        if(isset($GLOBALS['keyword']) && !empty($GLOBALS['keyword'])) {
            $keyword = sql_replace($GLOBALS['keyword']);
            $where = "`msgtype`=0 AND ``touid`='$uid' AND (`username`='$keyword' or `content` LIKE '%$keyword%')";
        } else {
           $where = array('msgtype'=>0,'touid'=>$memberinfo['uid']);
        }

        $result = $this->db->get_list('message',$where, '*', 0, 10,$page,'id DESC');
        $this->db->update('message', array('status'=>0), array('touid' => $uid,'status'=>1));
        $pages = $this->db->pages;
        $total = $this->db->number;
        $linkage_data1 = $this->db->get_list('linkage_data', array('linkageid'=>6), '*', 0, 100, 0, 'sort ASC,lid ASC');
        $linkage_data2 = $this->db->get_list('linkage_data', array('linkageid'=>7), '*', 0, 100, 0, 'sort ASC,lid ASC');
        $linkage_data3 = $this->db->get_list('linkage_data', array('linkageid'=>8), '*', 0, 100, 0, 'sort ASC,lid ASC');
        $linkage_data4 = $this->db->get_list('linkage_data', array('linkageid'=>9), '*', 0, 100, 0, 'sort ASC,lid ASC');
        $tags = $this->db->get_list('attention', array('uid'=>$uid), '*', 0, 100, 0);
        $tag_result = key_value($tags,'tagname','tagname');

        if($tag_result) $search_data = implode(' ',$tag_result);

        $where = "`m`='content' AND MATCH (`tags_data`) AGAINST ('$search_data' IN BOOLEAN MODE)";
        $tmp_search_result = $this->db->get_list('search_index', $where, '*', 0, 100, 0);
        $search_result = array();
        foreach($tmp_search_result as $r) {
            $data_r = $this->db->get_one('search_result', array('id' => $r['id']));
            if($data_r) $r = array_merge($r,$data_r);
            $r['tags_data'] = explode(' ',$r['tags_data']);
            $search_result[] = $r;
        }

        include T('attention','biz_listing');
	}
    public function set_bq() {
        $uid = $this->memberinfo['uid'];
        $type = intval($GLOBALS['type']);
        if(is_array($GLOBALS['bq']) && !empty($GLOBALS['bq'])) {
            if(count($GLOBALS['bq'])>3) {
                MSG('最多只能选择3个标签',HTTP_REFERER,3000);
            }
            $this->db->delete('attention', array('uid' => $uid,'type'=>$type));
            foreach($GLOBALS['bq'] as $tagname) {
                $formdata = array();
                $formdata['uid'] = $uid;
                $formdata['tagname'] = $tagname;
                $formdata['type'] = $type;
                $this->db->insert('attention', $formdata);
            }
        }
        MSG('设置成功!',HTTP_REFERER);
    }
    public function delete() {
        $uid = $this->memberinfo['uid'];
        $type = intval($GLOBALS['type']);
        $tagname = strip_tags($GLOBALS['tagname']);
        //print_r(array('uid' => $uid,'tagname'=>$tagname,'type'=>$type));
        $this->db->delete('attention', array('uid' => $uid,'tagname'=>$tagname,'type'=>$type));
        if($type==1) {
            $linkageid = 6;
        } elseif($type==2) {
            $linkageid = 7;
        } elseif($type==3) {
            $linkageid = 8;
        } elseif($type==4) {
            $linkageid = 9;
        }
        $linkage_data1 = $this->db->get_list('linkage_data', array('linkageid'=>$linkageid), '*', 0, 100, 0, 'sort ASC,lid ASC');
        $str = '';
        $tags = $this->db->get_list('attention', array('uid'=>$uid), '*', 0, 100, 0);
        $tag_result = key_value($tags,'tagname','tagname');
        foreach($linkage_data1 as $r) {
            $checked =  '';
            if(!empty($tag_result) && in_array($r['name'],$tag_result)) {
                $checked =  'checked';
            }

            $str .='<label style="margin-right: 20px;">'.$r['name'].' <input type="checkbox" value="'.$r['name'].'" class="i-checks" name="bq[]" '.$checked.'></label>';
        }
        echo $str;
    }
}