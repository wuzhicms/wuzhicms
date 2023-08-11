<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 编辑管理
 */
load_class('admin');
define('HTML',true);
class editor extends WUZHI_admin {
    private $siteid;
    private $siteurl;
    private $sitelist;
    function __construct() {
        $this->db = load_class('db');

        $this->siteid = get_cookie('siteid');
        if(!$this->siteid) {
            $this->siteid = 1;
            set_cookie('siteid',1);
        }
        $this->sitelist = get_cache('sitelist');
        $this->siteurl = isset($this->sitelist[$this->siteid]['url']) ? $this->sitelist[$this->siteid]['url'] : '';
    }

	public function keep_watch() {
		$roles = get_cache('roles');
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$where = '';
		if(strpos($_SESSION['role'],',1,')===false) {
			$admin_data = $this->db->get_one('admin', array('uid' => $_SESSION['uid']));
			if($admin_data['teamleader']) {
				$roles2 = explode(',',trim($_SESSION['role'],','));
				foreach($roles2 as $role) {
					if($where) {
						$where .= " OR `role` LIKE '%$role%'";
					} else {
						$where = "`role` LIKE '%$role%'";
					}
				}
			} else {
				$where = "`role`='-'";
			}
		}
		$result = $this->db->get_list('admin', $where, '*', 0, 1000,$page);
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_dialog = 1;
		$teamleader = array('','组长','副组长');
		include $this->template('keep_watch');
	}
	public function atwork() {

		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$uid = intval($GLOBALS['uid']);

		$where = array('uid'=>$uid,'status'=>9);
		$result = $this->db->get_list('atwork', $where, '*', 0, 20,$page);
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_formjs = 1;
		$show_dialog = 1;
		$starttime = date('Y-m-d H:00:00',SYS_TIME);
		$endtime = date('Y-m-d H:00:00',SYS_TIME+86400);
		load_class('form');
		include $this->template('atwork');
	}

	/**
	 * 添加请假
	 */
	public function atwork_add() {
		$formdata = array();
		$formdata['uid'] = $GLOBALS['uid'];
		$formdata['starttime'] = strtotime($GLOBALS['starttime']);
		$formdata['endtime'] = strtotime($GLOBALS['endtime']);
		$formdata['remark'] = $GLOBALS['remark'];
		$formdata['admin_uid'] = $_SESSION['uid'];
		$formdata['admin_username'] = get_cookie('wz_name');
		$formdata['status'] = 9;
		$this->db->insert('atwork', $formdata);
		MSG('提交成功',HTTP_REFERER);
	}
	/**
	 * 添加删除
	 */
	public function atwork_delete() {
		$aid = intval($GLOBALS['aid']);
		$formdata = array();
		$formdata['admin_uid'] = $_SESSION['uid'];
		$formdata['admin_username'] = get_cookie('wz_name');
		$formdata['status'] = 0;
		$this->db->update('atwork', $formdata,array('aid'=>$aid));
		MSG('删除成功',HTTP_REFERER);
	}

	/**
	 * 具体人的稿件统计
	 */
	public function editor_stat() {
		$page = $GLOBALS['page'];
		$page = max($page,1);
		$uid = intval($GLOBALS['uid']);
		$result = $this->db->get_list('editor_log', "`uid`='$uid'", 'dayid', 0, 20,$page, '','dayid');
		$pages = $this->db->pages;
		$total = $this->db->number;
		$actions = array('add'=>'添加','edit'=>'修改','sort'=>'排序','delete'=>'删除','check'=>'审核');
		include $this->template('editor_stat');
	}
	/**
	 * 编稿汇总考核
	 */
	public function all_stat() {
		$roles = get_cache('roles');
		$start = $GLOBALS['start'];
		$end = $GLOBALS['end'];
		if(!$end) $end = date('Y-m-d');
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$result = $this->db->get_list('admin', '', '*', 0, 1000,$page);
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_dialog = 1;
		load_class('form');
		$time2 = date('Y-m-d');
		include $this->template('editor_all_stat');
	}
	/**
	 * 编辑统计
	 */
	public function stats() {
		$types = array('列表','<font color="green">单网页</font>','<font color="#8b0000">外链</font>','隐藏');
		$siteid = get_cookie('siteid');
		$model_cache = get_cache('model_content','model');
		$where = "`keyid`='content' AND `siteid`='$siteid'";
		$sitelist = get_cache('sitelist');
		$result = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
		$endstr = date('Y-m-d');
		if($GLOBALS['end']) {
			$end = strtotime($GLOBALS['end']);
			$endstr = $GLOBALS['end'];

			$end = date('Ymd',$end);
			$where2 = "`dayid`<=$end";
		} else {
			$end = date('Ymd');
			$where2 = "`dayid`<=$end";
		}
		if($GLOBALS['start']) {
			$start = strtotime($GLOBALS['start']);
			$start = date('Ymd',$start);
			$where2 .= " AND `dayid`>=$start";
		}


		foreach($result as $cid=>$r) {
			$where3 = "`cid`=$cid AND ".$where2;
			$category_stat = $this->db->get_one('category_stat', $where3);

			$result[$cid]['num_contribute'] = $category_stat['num_contribute'];
			$result[$cid]['num_publish'] = $category_stat['num_publish'];
			$result[$cid]['num_gooditem'] = $category_stat['num_gooditem'];
			$result[$cid]['num_comment'] = $category_stat['num_comment'];

			$result[$cid]['str_manage'] = '<a class="btn btn-default btn-sm btn-xs" href="?m=content&f=category&v=add&pid='.$r['cid'].$this->su().'">添加子栏目</a> <a class="btn btn-primary btn-sm btn-xs" href="?m=content&f=category&v=edit&cid='.$r['cid'].$this->su().'">修改</a> <a class="btn btn-danger btn-sm btn-xs" href="javascript:makedo(\'?m=content&f=category&v=delete&cid='.$r['cid'].$this->su().'\', \'确认删除该记录？\')">删除</a>';
			$result[$cid]['ctype'] = $types[$r['type']];
			$result[$cid]['siteid'] = isset($sitelist[$r['siteid']]['name'])? $sitelist[$r['siteid']]['name']:'';
			$result[$cid]['modelname'] = $model_cache[$r['modelid']]['name'];
			if(strpos($r['url'],'://')===false) {
				$result[$cid]['url'] = '<a href="'.$sitelist[$r['siteid']]['url'].ltrim($r['url'],'/').'" target="_blank">访问</a>';
			} else {
				$result[$cid]['url'] = '<a href="'.$r['url'].'" target="_blank">访问</a>';
			}
		}

		$tree = load_class('tree','core',$result);
		$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
		//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
		$tree_data = '';

		//格式字符串
		$str="<tr><td>\$cid</td><td id='\$cid' \$selected>\$spacer\$name</td><td>\$modelname</td><td align='center'>\$num_contribute</td><td align='center'>\$num_publish</td><td align='center'>\$num_gooditem</td><td align='center'>\$num_comment</td></tr>";

		//返回树
		$tree_data.=$tree->create(0,$str);

		$tree_data.="";
		$show_dialog = 1;
		load_class('form');
		include $this->template('editor_stats',M);
	}
}
