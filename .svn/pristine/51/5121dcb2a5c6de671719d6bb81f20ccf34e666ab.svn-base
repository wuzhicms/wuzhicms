<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 后台菜单管理
 */
load_class('admin');

class menu extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 菜单管理
	 */
	public function listing() {
		$pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
		$where = array('pid'=>$pid);
		$result = $this->db->get_list('menu', $where, '*', 0, 100, 0, 'sort ASC');
		//print_r($result);
		include $this->template('menu_listing',M);
	}
	/**
	 * 菜单添加
	 */
	public function add() {
		if(isset($GLOBALS['submit']) || isset($GLOBALS['submit2'])) {
			$formdata = array();
			$formdata['name'] = $GLOBALS['form']['name'];
			$formdata['pid'] = intval($GLOBALS['form']['pid']);
			$formdata['m'] = $GLOBALS['form']['m'];
			$formdata['f'] = $GLOBALS['form']['f'];
			$formdata['v'] = $GLOBALS['form']['v'];
			$formdata['data'] = $GLOBALS['form']['data'];
			$formdata['display'] = $GLOBALS['form']['display'];
            $isopenid = $GLOBALS['isopenid'];
            $formdata['isopenid'] = $isopenid;
            if($isopenid) {
                $platform = load_class('open_platform');
                $formdata['menuid'] = $platform->get_menuid();
            } else {
                $r = $this->db->get_one('menu', array('isopenid' =>0),'*',0,'menuid DESC');
                $maxid = $r['menuid']+1;
                $formdata['menuid'] = $maxid;
            }
			$id = $this->db->insert('menu',$formdata);
			$this->db->update('menu',array('sort'=>$id),array('menuid'=>$id));
			//缓存菜单语音包
			load_class('cache_menu');
            if($GLOBALS['submit']) {
                $forward = '?m=core&f=menu&v=listing&pid='.$formdata['pid'].$this->su();
            } else {
                $forward = HTTP_REFERER;
            }
			MSG(L('operation success'),$forward);
		} else {
            //文件写入判断
           // COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php';
            $readonly = TRUE;
            if(is_writable(COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php')) {
                $readonly = FALSE;
            }
			$form = load_class('form');
            $menus = '';
            $pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
			if($pid) {
                $r = $this->db->get_one('menu', array('menuid'=>$pid));
                $parentname = $r['name'];
            } else {
                $menus = $this->db->get_list('menu', array('pid'=>0), '*', 0, 2000);
            }
			include $this->template('menu_add',M);
		}
	}
    /**
     * 菜单修改
     */
    public function edit() {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
        if(!$id) MSG(L('参数错误'));
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['pid'] = intval($GLOBALS['form']['pid']);
            $formdata['m'] = $GLOBALS['form']['m'];
            $formdata['f'] = $GLOBALS['form']['f'];
            $formdata['v'] = $GLOBALS['form']['v'];
            $formdata['data'] = $GLOBALS['form']['data'];
            $formdata['display'] = $GLOBALS['form']['display'];

            $this->db->update('menu',$formdata,array('menuid'=>$id));
            //缓存菜单语音包
            load_class('cache_menu');
            MSG(L('operation success'),$GLOBALS['forward']);
        } else {
            //文件写入判断
            // COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php';
            $readonly = TRUE;
            if(is_writable(COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php')) {
                $readonly = FALSE;
            }
            $form = load_class('form');
            $r = $this->db->get_one('menu', array('menuid'=>$id));
            $rs = $this->db->get_one('menu', array('menuid'=>$r['pid']));
            $parentname = $rs['name'];
            include $this->template('menu_edit',M);
        }
    }
    public function delete() {
            $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
            if(!$id) MSG(L('操作失败'));
            $this->db->delete('menu',array('menuid'=>$id));
            $this->delete_child($id);
            load_class('cache_menu');
            MSG(L('operation success'));
    }
    /**
     * 递归删除菜单
     */
    private function delete_child($menuid) {
        $r = $this->db->get_one('menu',array('pid'=>$menuid));
        if($r) {
            $this->db->delete('menu',array('menuid'=>$r['menuid']));
            $this->delete_child($r['menuid']);
        }
    }

    /**
     * 排序
     */
    public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('menu',array('sort'=>$n),array('menuid'=>$cid));
            }
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            MSG(L('operation failure'));
        }
    }

    /**
     * 获得上级菜单id
     */
    private function parentid($pid) {
        $r = $this->db->get_one('menu', array('menuid'=>$pid));
        return $r['pid'];
    }

    public function get_menu() {
        echo $GLOBALS['menuid'];
    }
}