<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 广告管理
 */
load_class('admin');
load_function('common','promote');
class index extends WUZHI_admin {
	private $db;

	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 广告位管理
     */
    public function listingplace() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('promote_place', '', '*', 0, 50,$page,'pid ASC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listingplace');
    }

    public function listing() {
        $pid = intval($GLOBALS['pid']);
        $siteid = get_cookie('siteid');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('promote',array('pid'=>$pid,'siteid'=>$siteid), '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    public function search() {
        $siteid = get_cookie('siteid');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $fieldtype = $GLOBALS['fieldtype'];
        $keywords = $GLOBALS['keywords'];
        if($fieldtype=='place') {
            $where = "`siteid`='$siteid' AND `name` LIKE '%$keywords%'";
            $result = $this->db->get_list('promote_place', $where, '*', 0, 50,$page,'pid ASC');
            $pages = $this->db->pages;
            $total = $this->db->number;
            include $this->template('listingplace');
        } else {
            $where = "`siteid`='$siteid' AND `$fieldtype` LIKE '%$keywords%'";
            $result = $this->db->get_list('promote',$where, '*', 0, 20,$page,'id DESC');
            $pages = $this->db->pages;
            $total = $this->db->number;
            include $this->template('listing');
        }


    }

    /**
     * 添加广告位
     */
    public function addplace() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['width'] = intval($GLOBALS['form']['width']);
            $formdata['height'] = intval($GLOBALS['form']['height']);
            $formdata['keyid'] = strip_tags($GLOBALS['form']['keyid']);
            $formdata['siteid'] = get_cookie('siteid');
            $formdata['addtime'] = SYS_TIME;
            $formdata['updatetime'] = SYS_TIME;
            $this->db->insert('promote_place',$formdata);
            $this->set_cache();
            MSG(L('add success'),'?m=promote&f=index&v=listingplace'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            include $this->template('addplace');
        }
    }
    /**
     * 添加广告
     */
    public function add() {
        $pid = intval($GLOBALS['pid']);
        if(isset($GLOBALS['submit'])) {
            $r = $this->db->get_one('promote_place', array('pid' => $pid));
            $siteid = get_cookie('siteid');
            $formdata = array();
            $formdata['siteid'] = get_cookie('siteid');
            $formdata['pid'] = $pid;
            $formdata['keyid'] = $r['keyid'];
            $formdata['title'] = remove_xss($GLOBALS['form']['title']);
            $formdata['subtitle'] = remove_xss($GLOBALS['form']['subtitle']);
            $formdata['keywords'] = strip_tags($GLOBALS['form']['keywords']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['file'] = remove_xss($GLOBALS['form']['file']);
            $formdata['icon'] = remove_xss($GLOBALS['form']['icon']);
            $formdata['template'] = remove_xss($GLOBALS['form']['template']);
            $formdata['appid'] = $GLOBALS['form']['appid'];
            $formdata['param1'] = $GLOBALS['form']['param1'];
            $formdata['param2'] = $GLOBALS['form']['param2'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['updatetime'] = SYS_TIME;
            $formdata['starttime'] = strtotime($GLOBALS['starttime']);
            $formdata['endtime'] = strtotime($GLOBALS['endtime']);
            $id = $this->db->insert('promote',$formdata);
            $this->set_cache();
            $this->cache_js($id);
            MSG(L('add success'),'?m=promote&f=index&v=listing&pid='.$formdata['pid'].$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');

            include $this->template('add');
        }
    }

    /**
     * 修改
     */
    public function edit() {
        $id = intval($GLOBALS['id']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['title'] = remove_xss($GLOBALS['form']['title']);
            $formdata['subtitle'] = remove_xss($GLOBALS['form']['subtitle']);
            $formdata['url'] = remove_xss($GLOBALS['form']['url']);
            $formdata['file'] = remove_xss($GLOBALS['form']['file']);
            $formdata['icon'] = remove_xss($GLOBALS['form']['icon']);
            $formdata['keywords'] = strip_tags($GLOBALS['form']['keywords']);
            $formdata['template'] = remove_xss($GLOBALS['form']['template']);
            $formdata['updatetime'] = SYS_TIME;
            $formdata['appid'] = $GLOBALS['form']['appid'];
            $formdata['param1'] = $GLOBALS['form']['param1'];
            $formdata['param2'] = $GLOBALS['form']['param2'];
            $formdata['starttime'] = strtotime($GLOBALS['starttime']);
            $formdata['endtime'] = strtotime($GLOBALS['endtime']);
            $this->db->update('promote',$formdata,array('id'=>$id));
            $forward = $GLOBALS['forward'];
            $this->set_cache();
            $this->cache_js($id);
            MSG(L('edit success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('promote',array('id'=>$id));
            $pid = $r['pid'];
            $starttime = date('Y-m-d H:i:s',$r['starttime']);
            $endtime = date('Y-m-d H:i:s',$r['endtime']);
            include $this->template('edit');
        }
    }
    /**
     * 删除广告
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('promote',array('id'=>$id));
        $this->set_cache();
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 删除广告位
     */
    public function deleteplace() {
        $pid = intval($GLOBALS['pid']);
        $this->db->delete('promote_place',array('pid'=>$pid));
        $this->set_cache();
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 修改广告位
     */
    public function editplace() {
        $pid = intval($GLOBALS['pid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['width'] = intval($GLOBALS['form']['width']);
            $formdata['height'] = intval($GLOBALS['form']['height']);
            $formdata['keyid'] = strip_tags($GLOBALS['form']['keyid']);
            $formdata['updatetime'] = SYS_TIME;
            $this->db->update('promote_place',$formdata,array('pid'=>$pid));
            $this->db->update('promote',array('keyid'=>$formdata['keyid']),array('pid'=>$pid));

            $forward = $GLOBALS['forward'];
            $this->set_cache();
            MSG(L('edit success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('promote_place',array('pid'=>$pid));
            include $this->template('editplace');
        }
    }
    /**
     * 广告预览
     */
    public function view() {
        $pid = intval($GLOBALS['pid']);
        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('promote_place',array('pid'=>$pid));
        include $this->template('view');
    }
    private function set_cache() {
        $result = $this->db->get_list('promote_place', '', '*', 0, 100,0,'pid ASC','','pid');
        if(!empty($result)) {
            set_cache('place',$result,'promote');
            foreach($result as $rs) {
                $data2 = $this->db->get_list('promote',array('pid'=>$rs['pid']), '*', 0, 100,0,'id DESC');
                set_cache('place_'.$rs['pid'],$data2,'promote');
            }
        }
    }

    /**
     * 批量发布广告
     */
    public function batch() {
        $pid = intval($GLOBALS['pid']);
        if(isset($GLOBALS['submit'])) {
            if(!empty($GLOBALS['pids'])) {
                $siteid = get_cookie('siteid');
                $formdata = array();
                $formdata['siteid'] = get_cookie('siteid');
                $formdata['title'] = remove_xss($GLOBALS['form']['title']);
                $formdata['keywords'] = strip_tags($GLOBALS['form']['keywords']);
                $formdata['url'] = remove_xss($GLOBALS['form']['url']);
                $formdata['file'] = remove_xss($GLOBALS['form']['file']);
                $formdata['icon'] = remove_xss($GLOBALS['form']['icon']);
                $formdata['template'] = remove_xss($GLOBALS['form']['template']);
                $formdata['appid'] = $GLOBALS['form']['appid'];
                $formdata['param1'] = $GLOBALS['form']['param1'];
                $formdata['param2'] = $GLOBALS['form']['param2'];
                $formdata['addtime'] = SYS_TIME;
                $formdata['updatetime'] = SYS_TIME;
                foreach($GLOBALS['pids'] as $pid) {
                    $formdata['pid'] = $pid;
                    $this->db->insert('promote',$formdata);
                }
            }
            $this->set_cache();
            MSG(L('add success'),'?m=promote&f=index&v=listing&pid='.$formdata['pid'].$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $result = $this->db->get_list('promote_place', '', '*', 0, 100,0,'pid ASC');

            include $this->template('batch_add');
        }
    }

    /**
     * 生成js
     * @param $id 广告id
     */
    private function cache_js($id) {
        $r = $this->db->get_one('promote', array('id' => $id));
        //查询到广告位id。
        $pid = $r['pid'];
        $pr = $this->db->get_one('promote_place', array('pid' => $pid));
        $where = "`pid`='$pid' AND starttime<".SYS_TIME." AND endtime>".SYS_TIME;
        $result = $this->db->get_list('promote', $where, '*', 0, 10, 0, 'id DESC');
		if($result) {
			$rand_key = array_rand($result,1);
			$rand_result = $result[$rand_key];
		}

        $template = $r['template'];
        $file = WWW_ROOT.'promote/'.$pid.'.js';

        ob_start();
        include T('promote',$template);
        $data = ob_get_contents();
        ob_clean();
        $dir = dirname($file);
        if(!is_dir($dir)) {
            mkdir($dir, 0777,1);
        }
        $strlen = file_put_contents($file, $data);
        if(!is_writable($file)) {
            $file = str_replace(WWW_ROOT,'',$file);
            MSG(L('file').'：'.$file.'<br>'.L('not_writable'));
        }
    }

	/**
	 * 广告统计
	 */
	public function stat() {
		$pid = intval($GLOBALS['pid']);
		$month = $stat_table = date('Ym',SYS_TIME);

		$query = $this->db->query('show tables');
		$dbtalbes = array();
		while($r = $this->db->fetch_row($query)) {
			$dbtalbes[]=$r[0];
		}

		$tablepre = $this->db->tablepre;
		$check_tablename = $tablepre.$stat_table;
		if(!in_array($check_tablename,$dbtalbes)) {
			load_function('sql');
			$sql = "DROP TABLE IF EXISTS `wz_promote_stat_$stat_table`;
CREATE TABLE `wz_promote_stat_$stat_table` (
  `pid` int(10) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(15) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `qkey` varchar(13) NOT NULL,
  `addtime` datetime NOT NULL,
  `referer` varchar(100) NOT NULL,
  `day` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告统计';
ALTER TABLE `wz_promote_stat_$stat_table`
  ADD KEY `pid_2` (`pid`,`qkey`,`day`);";
			sql_execute($this->db,$sql);
			$this->db->update('promote', array('stat_table'=>$stat_table));
		}
		$r = $this->db->count('promote_stat_'.$month, '', "COUNT(*) AS num", 0, '', '');
		$result = $this->db->query("SELECT COUNT(*) as num,day FROM `wz_promote_stat_$month` WHERE pid=$pid GROUP by day");
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$result_detail = $this->db->get_list('promote_stat_'.$month, '', '*', 0, 20, $page, '');
		$ip_location = load_class('ip_location');
		foreach($result_detail as $key=>$rs) {
			$result_detail[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
		}
		$pages = $this->db->pages;
		$total = $this->db->number;
		include $this->template('stat');
	}
}
