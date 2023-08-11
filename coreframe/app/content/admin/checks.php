<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容添加
 */
load_class('admin');
define('HTML',true);

class checks extends WUZHI_admin {
    private $status_array = array(
        9=>'审核通过',
        8=>'定时发送',
        1=>'一审',
        2=>'二审',
        3=>'三审',
        4=>'四审',
        0=>'回收站',
        7=>'退稿',
        6=>'草稿',
    );
    private $status_array2 = array(
        8=>'定时发送',
        10=>'一审~三审',
        0=>'回收站',
        7=>'退稿',
        6=>'草稿',
    );
    private $siteid;
    private $siteurl;
    private $sitelist;
    function __construct() {
        $this->db = load_class('db');
        $this->private_check();
        $this->siteid = get_cookie('siteid');
        if(!$this->siteid) {
            $this->siteid = 1;
            set_cookie('siteid',1);
        }
        $this->sitelist = get_cache('sitelist');
        $this->siteurl = isset($this->sitelist[$this->siteid]['url']) ? $this->sitelist[$this->siteid]['url'] : '';
    }

    public function c1() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
        $siteid = get_cookie('siteid');
        $this->siteurl = substr($this->siteurl,0,-1);

        $type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
        $title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        //---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status`='1' AND `yuding_uid`=0";
		$categorys = get_cache('category','content');
		if(isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] : null) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

        //---

        $page = intval($GLOBALS['page']);
        $page = max($page,1);
        $models = get_cache('model_content','model');
        $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
        //$result = array();
        $pages = $this->db->pages;
        $show_dialog = 1;
        load_class('form');

		include $this->template('c1');
    }
    //签发稿件
	public function c2() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = intval($GLOBALS['type']);
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';
		//TODO ,这里可以修改审核级别 status=3 /4

		$where = "`status`='4' AND `yuding_uid`=0";
		$categorys = get_cache('category','content');
		if($GLOBALS['keyValue']) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c1');
	}
	public function c3() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';
		$uid = $_SESSION['uid'];
		$where = "`yuding_uid`='$uid'";
		$categorys = get_cache('category','content');
		if(isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] : null) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c3');
	}
	public function c4() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = intval($GLOBALS['type']);
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status` IN(2,3,4)";
		$categorys = get_cache('category','content');
		if($GLOBALS['keyValue']) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c4');
	}
	public function c5() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status`=9";
		$categorys = get_cache('category','content');
		if(isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] : null) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c5');
	}

    private function _status($status) {
    	if(isset($GLOBALS['cid'])) {
    		$category = get_cache('category_'.$GLOBALS['cid'],'content');
    		$workflowid = $category['workflowid'];
			if($workflowid) {
				$workflow_r = $this->db->get_one('workflow', array('workflowid' => $workflowid));
				for($i=1;$i<5;$i++) {
					if($workflow_r['level']>=$i) {
						$this->status_array[$i] = $workflow_r['level'.$i.'_name'];
					} else {
						unset($this->status_array[$i]);
					}
				}
			}
		}
        $status_array = $this->status_array;
        $string = '';
        foreach($status_array as $k=>$s) {
            if($k==$status) {
                $string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-check btn-icon"></i>'.$s.'</a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach($status_array as $k=>$s) {
            if($k!=$status) {
                $url = URL().'&status='.$k;
                $url = url_unique($url);
                $string .= '<li><a class="dropdown-item" href="?'.$url.'">'.$s.'</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }
    private function _status2($status) {
        $status_array = $this->status_array2;
        $string = '';
        foreach($status_array as $k=>$s) {
            if($k==$status) {
                $string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-check btn-icon"></i>'.$s.'</a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach($status_array as $k=>$s) {
            if($k!=$status) {
                $url = URL().'&status='.$k;
                $url = url_unique($url);
                $string .= '<li><a class="dropdown-item" href="?'.$url.'">'.$s.'</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }
    /**
     * 检查内容管理权限
     */
    private function private_check() {
        if(strpos($_SESSION['role'],',1,')!==false) return true;

        $actionids = array(1=>'listing',2=>'add',3=>'edit',4=>'delete',5=>'sort');
        if(in_array(V,$actionids)) {
            $cid = intval($GLOBALS['cid']);
            if($cid==0) return true;
            $actionids = array_flip($actionids);
            $actionid = $actionids[V];
            $role = trim($_SESSION['role'],',');
            $where = "`role` IN ($role) AND `cid`='$cid' AND `actionid`='$actionid'";
            if(!$this->db->get_one('category_private',$where)) {
                //查看副栏目是否给予权限，如果有，则继承权限
                $category = get_cache('category_'.$cid,'content');
                if($category && $category['pid']) {
                    $pid = $category['pid'];
                    $where = "`role` IN ($role) AND `cid`='$pid' AND `actionid`='$actionid'";
                    if($this->db->get_one('category_private',$where)) {
                        return true;
                    }
                }
                MSG(L('no content private'));
            }
        }
    }

	/**
	 * 预定
	 */
    public function check_yuding() {
		$id = $GLOBALS['id'];
		if(isset($GLOBALS['cancal'])) {//取消预定
			$this->db->update('content_share', array('yuding_uid'=>''), array('id' => $id));
			echo '移除成功！';
		} else {
			$data = $this->db->get_one('content_share', array('id' => $id));
			if($data['yuding_uid']==0) {
				$this->db->update('content_share', array('yuding_uid'=>$_SESSION['uid']), array('id' => $id));
				echo '预定成功！';
			} elseif($data['yuding_uid']!=$_SESSION['uid']) {
				$mr = $this->db->get_one('member', array('uid' => $data['yuding_uid']));
				echo '已经被 '.$mr['username'].'预定过了！';
			} else {
				echo '您已经预定过了！';
			}
		}

	}

	/**
	 * 文章属性设置
	 */
	public function set_shuxing() {
		if(isset($GLOBALS['submit'])) {
			$id = intval($GLOBALS['id']);
			$formdata = array();
			$formdata['zd'] = 0;
			$formdata['yx'] = 0;
			$formdata['tj'] = 0;
			if(isset($GLOBALS['zd'])) {
				$formdata['zd'] = 1;
			}
			if(isset($GLOBALS['yx'])) {
				$formdata['yx'] = 1;
			}
			if(isset($GLOBALS['tj'])) {
				$formdata['tj'] = 1;
			}
			$this->db->update('content_share', $formdata, array('id' => $id));
			MSG('<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>属性设置成功');

		} else {
			$id = intval($GLOBALS['id']);
			$data = $this->db->get_one('content_share', array('id' => $id));
			include $this->template('set_shuxing');
		}

	}
	/**
	 * 审核操作
	 */
	public function check_records() {
		if(isset($GLOBALS['submit'])) {
			$id = intval($GLOBALS['id']);
			$formdata = array();
			$formdata['zd'] = 0;
			$formdata['yx'] = 0;
			$formdata['tj'] = 0;
			if(isset($GLOBALS['zd'])) {
				$formdata['zd'] = 1;
			}
			if(isset($GLOBALS['yx'])) {
				$formdata['yx'] = 1;
			}
			if(isset($GLOBALS['tj'])) {
				$formdata['tj'] = 1;
			}
			$this->db->update('content_share', $formdata, array('id' => $id));
			MSG('<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>属性设置成功');

		} else {
			$id = intval($GLOBALS['id']);
			$data = $this->db->get_one('content_share', array('id' => $id));
			$qf_priv = 0;
			$admin_priv = $this->db->get_one('admin', array('uid' => $_SESSION['uid']),'qf_priv');
			$qf_priv = $admin_priv['qf_priv'];
			include $this->template('check_records');
		}

	}
	//一审
	public function ck1() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status`='1' AND `yuding_uid`=0";
		$categorys = get_cache('category','content');
        $keyValue = isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] : null;
		if($keyValue) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c1');
	}
	//二审
	public function ck2() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status`='2' AND `yuding_uid`=0";
		$categorys = get_cache('category','content');
		if(isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] : null) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c1');
	}
	//三审
	public function ck3() {
		$keyArr = array('username'=>'作者', 'title'=>'标题');
		$siteid = get_cookie('siteid');
		$this->siteurl = substr($this->siteurl,0,-1);

		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : null;
		$title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';

		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
		//---
		$modelid = 0;
		$_master_table = $master_table = 'content_share';

		$where = "`status`='3' AND `yuding_uid`=0";
		$categorys = get_cache('category','content');
		if(isset($GLOBALS['keyValue']) ? $GLOBALS['keyValue'] :null ) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = sql_replace($GLOBALS['keyValue']);
			switch ($keyType) {
				case 'username':
					$where .= " AND `publisher` = '%$keyValue%'";
					break;
				case 'title':
					$where .= " AND `title` LIKE '%$keyValue%'";
					break;
			}
		}
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		if($regTimeStart) {
			$where .= " AND `addtime`>='$regTimeStart'";
		}
		if($regTimeEnd) {
			$where .= " AND `addtime`<='$regTimeEnd'";
		}

		//---

		$page = intval($GLOBALS['page']);
		$page = max($page,1);
		$models = get_cache('model_content','model');
		$result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
		//$result = array();
		$pages = $this->db->pages;
		$show_dialog = 1;
		load_class('form');

		include $this->template('c1');
	}

	/**
	 * 用稿通知
	 */
	public function use_notice() {
		$nt = intval($GLOBALS['nt']);
		$id = intval($GLOBALS['id']);
		$this->db->update('content_share', array('use_notice'=>$nt), array('id' => $id));
		MSG('操作成功',HTTP_REFERER);
	}
}
