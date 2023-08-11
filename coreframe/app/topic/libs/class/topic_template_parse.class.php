<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 专题模版，标签解析
 */
class WUZHI_topic_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
    public function __construct() {
        $this->db = load_class('db');
		//$this->sharedb = new WUZHI_db('server_mysql_share');
    }
    /**
     * 列表标签
     *
     * @param $c
     * @return array
     */
    public function listing($c) {
        if(!isset($c['tid']) && !isset($c['kid']) && !isset($c['subkid'])) return array();
        if(isset($c['tid'])) {
			$where = '`status`=9 AND `tid`=' . intval($c['tid']);
		} elseif(isset($c['kid'])) {
			$where = '`status`=9 AND `kid1`='.intval($c['kid']);
		} elseif(isset($c['subkid'])) {
		    if(strpos($c['subkid'],',')){
		        $where = '`status`=9 AND `kid2` in ('.$c['subkid'].')';
            }else{
                $where = '`status`=9 AND `kid2`='.intval($c['subkid']);
            }
        }  else {
            $where = '`status`=9';
        }
        if($c['recommend']){
            $where .= ' AND `recommend` ='.$c['recommend'] ;
        }
        $tid = intval($GLOBALS['tid']);
		$page = isset($c['page']) ? intval($c['page']) : 0;
		$pagesize = isset($c['pagesize']) ? intval($c['pagesize']) : 0;
		//$urlrule = '/topic-'.$tid.'.html|/topic-'.$tid.'-{$page}.html';
        $urlrule = '/index.php?m=topic&f=index&v=init&tid='.$tid.'&page={$page}';
		$rule_arr = array('tid'=>$tid);
        $order = isset($c['order']) ? $c['order'] : 'sort ASC,tcid DESC';
		$result = $this->db->get_list('topic_content', $where, '*', $c['start'], $c['pagesize'], $page,$order,'','',$urlrule,$rule_arr,5);
		$new_result = array();
		foreach ($result as $_k=>$_v) {
			if($_v['islink']) {
				$_v2 = $this->db->get_one('content_share', array('id' => $_v['id']));
				if($_v2) $_v = array_merge($_v,$_v2);
			} else {
				$_v['url'] = '/index.php?m=topic&v=show&tcid='.$_v['tcid'];
			}
            $_v3 = $this->db->get_one('content_rank',array('id'=>$_v['id']),'views');
            if($_v3) $_v = array_merge($_v,$_v3);
			$new_result[] = $_v;
		}
		$this->number = $this->db->number;
		$GLOBALS['pagesize'] = $c['pagesize'];
		$GLOBALS['pages'] = $c['page'];
		if($c['page']) {
			$this->pages = $this->db->pages;
			$GLOBALS['pages'] = $this->pages;
		}
		return $new_result;
		/**
		 //共享部分逻辑
        $result_tmp = $this->db->get_list('topic_content', $where, '*', $c['start'], $c['pagesize'], 0,$order);
		if($result_tmp) {
			$result = array();
			foreach($result_tmp as $r) {
				$share_item = $this->sharedb->get_one('share_item', array('sid' => $r['sid']));
				if($share_item) $r = array_merge($r,$share_item);
				$result[] = $r;
			}
			return $result;
		}
		return array();
		 **/
	}

    public function topicList($c){
        $where = 'status=9';
        $pagesize = isset($c['pagesize']) ? intval($c['pagesize']) : 5 ;
        $order = isset($c['order']) ? $c['order'] : 'tid DESC';
        $result = $this->db->get_list('topic',$where,'*','',$c['pagesize'],'',$order);
        return $result;
    }

    public function category($c){
        if (!isset($c['tid']) && empty($c['tid'])) return array();
        if(isset($c['tid'])){
            $where = '`keyid`="topic'.$c['tid'].'"';
        }
        $page = isset($c['page']) ? $c['page'] : 1;
        $order = isset($c['order']) ? $c['order'] : 'kid asc';
        $pagesize = intval($c['pagesize']);
        $pagesize = max(1,$pagesize);
        $result = $this->db->get_list('kind',$where, '*', $c['start'], $pagesize, $page,$order);
        return $result;
    }

    public function rank($c){
        //总排行，当日，昨日排行，周排行，月排行

        $tid = isset($c['tid']) ? intval($c['tid']) : 0;
        $order = isset($c['order']) ? $c['order'] : 'c.views DESC';
        $limit = isset($c['limit']) ? intval($c['limit']) : 10;

        $sql = "SELECT c.* FROM wz_content_rank AS c JOIN  wz_topic_content AS t ON c.id=t.id WHERE t.tid=".$tid." ORDER BY ".$order;
        $result_rank = $this->db->get_page_list($sql,'',$limit);
        foreach($result_rank as $rs){
            $r = $this->db->get_one('content_share',array('id'=>$rs['id']));
            $result[] = $r;
        }

        return $result;
    }

}