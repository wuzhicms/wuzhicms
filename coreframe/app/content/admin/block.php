<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 区块管理
 */
load_class('admin');
class block extends WUZHI_admin {
	private $db;
    private $siteid;
    private $status_array = array(
        9=>'审核通过',
        8=>'定时发送',
        1=>'一审',
        2=>'二审',
        3=>'三审',
        0=>'回收站',
        7=>'退稿',
        6=>'草稿',
    );
	function __construct() {
		$this->db = load_class('db');
        $this->siteid = get_cookie('siteid');
	}

    public function listing() {
		if(empty($this->siteid)) MSG('站点缓存丢失，请修改站点，并提交');
        $where = array('siteid'=>$this->siteid,'tplid'=>TPLID);
		
        $page = intval($GLOBALS['page']);

        $result = $this->db->get_list('block', $where, '*', 0, 20, $page,'blockid DESC');
        $pages = $this->db->pages;

        include $this->template('block_listing');
    }
    public function item_listing() {
        $sitelist = get_cache('sitelist');
        $siteid = get_cookie('siteid');
        $blockid = intval($GLOBALS['blockid']);
        $where = array('blockid'=>$blockid,'siteid'=>$siteid);
        $page = intval($GLOBALS['page']);
        $result = $this->db->get_list('block_data', $where, '*', 0, 20, $page,'sort DESC,id DESC');
        $pages = $this->db->pages;

        include $this->template('item_listing');
    }
    /**
     * 列表排序
     */
    public function item_sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('block_data',array('sort'=>$n),array('id'=>$cid));
            }
            MSG(L('operation success'));
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 删除列表项
     */
    public function item_delete() {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
        if(!$id) MSG(L('操作失败'));
        $this->db->delete('block_data',array('id'=>$id));
        MSG(L('operation success'),HTTP_REFERER,500);
    }
    public function item_edit() {
        $id = intval($GLOBALS['id']);
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['addtime'] = SYS_TIME;

            $formdata = array_map('remove_xss',$formdata);
            if(isset($GLOBALS['attform'])) {
                $attform = $GLOBALS['attform'];

                $attform = array_map('remove_xss',$attform);
                $formdata['attach'] = serialize($attform);
            }

            $this->db->update('block_data',$formdata,array('id'=>$id));
            $r = $this->db->get_one('block_data',array('id'=>$id));
            $rs = $this->db->get_one('block',array('blockid'=>$r['blockid']));
            //生成静态
            if($rs['createhtml']) {
                $GLOBALS['blockids'] = array($r['blockid']);
                $this->html(0);
            }
            $forward = $GLOBALS['forward'];
            MSG(L('edit success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('block_data',array('id'=>$id));
            $rs = $this->db->get_one('block',array('blockid'=>$r['blockid']));
            $attach = '';
            if($r['attach']) $attach = unserialize($r['attach']);

            $result = $this->db->get_list('kind', array('keyid'=>'interest'), '*', 0, 50, 0, 'kid ASC');
            $interest = key_value($result,'maxid','name');
            include $this->template('blockitem_edit');
        }
    }

    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['tplid'] = TPLID;
            $formdata['type'] = intval($GLOBALS['type']);
            $formdata['modelid'] = intval($GLOBALS['modelid']);
            $formdata['codetype'] = intval($GLOBALS['codetype']);
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['siteid'] = $this->siteid;
            $formdata['max_number'] = 500;
            if($formdata['type']==1) {
                $code = $GLOBALS['form']['template_code'];
            } elseif($formdata['type']==2) {
                $code = $GLOBALS['form']['code'];
            } elseif($formdata['type']==3) {
                $formdata['url'] = safe_htm($GLOBALS['form']['rssurl']);
                $code = $GLOBALS['form']['template_code'];
            } elseif($formdata['type']==4) {
                $formdata['url'] = safe_htm($GLOBALS['form']['jsonurl']);
                $code = $GLOBALS['form']['template_code'];
            }
            $formdata['createhtml'] = intval($GLOBALS['createhtml']);
            $formdata['updatetime'] = SYS_TIME;
            $formdata['timing'] = SYS_TIME+3600;
            $formdata['status'] = 9;
            $isopenid = $GLOBALS['isopenid'];
            $formdata['isopenid'] = $isopenid;
            if($isopenid) {
                $platform = load_class('open_platform');
                $formdata['blockid'] = $platform->get_blockid();
            } else {
                $r = $this->db->get_one('block', array('isopenid' =>0),'*',0,'blockid DESC');
                $maxid = $r['blockid']+1;
                $formdata['blockid'] = $maxid;
            }
            $blockid = $this->db->insert('block',$formdata);
            //替换 #wz#
            if($formdata['type']==1) {
                $str = 'type="1" blockid="'.$blockid.'"';
            } elseif($formdata['type']==2) {
                $str = 'type="2" blockid="'.$blockid.'"';
            } elseif($formdata['type']==3) {
                $str = 'type="3" blockid="'.$blockid.'" url="'.$formdata['url'].'"';
            } elseif($formdata['type']==4) {
                $str = 'type="4" blockid="'.$blockid.'" url="'.$formdata['url'].'"';
            }
            $formdata['code'] = str_replace('#wz#',$str,$code);
            $this->db->update('block',array('code'=>$formdata['code']),array('blockid'=>$blockid));
            set_cache('block_'.$blockid,$formdata,'block');
            //生成静态
            if($formdata['createhtml']) {
                $GLOBALS['blockids'] = array($blockid);
                $this->html(0);
            }
            MSG(L('add success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $models = $this->db->get_list('model', '', '*', 0, 100, 0, 'modelid ASC');
            include $this->template('block_add');
        }
    }
    public function edit() {
        $blockid = intval($GLOBALS['blockid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['type'] = intval($GLOBALS['type']);
            $formdata['modelid'] = intval($GLOBALS['modelid']);
            $formdata['codetype'] = intval($GLOBALS['codetype']);
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['max_number'] = 500;
            if($formdata['type']==1) {
                $code = $GLOBALS['form']['template_code'];
            } elseif($formdata['type']==2) {
                $code = $GLOBALS['form']['code'];
            } elseif($formdata['type']==3) {
                $formdata['url'] = safe_htm($GLOBALS['form']['rssurl']);
                $code = $GLOBALS['form']['template_code'];
            } elseif($formdata['type']==4) {
                $formdata['url'] = safe_htm($GLOBALS['form']['jsonurl']);
                $code = $GLOBALS['form']['template_code'];
            }
            $formdata['createhtml'] = intval($GLOBALS['createhtml']);
            $formdata['updatetime'] = SYS_TIME;
            $formdata['timing'] = SYS_TIME+3600;
            $formdata['status'] = 9;


            //替换 #wz#
            if($formdata['type']==1) {
                $str = 'type="1" blockid="'.$blockid.'"';
            } elseif($formdata['type']==2) {
                $str = 'type="2" blockid="'.$blockid.'"';
            } elseif($formdata['type']==3) {
                $str = 'type="3" blockid="'.$blockid.'" url="'.$formdata['url'].'"';
            } elseif($formdata['type']==4) {
                $str = 'type="4" blockid="'.$blockid.'" url="'.$formdata['url'].'"';
            }
            $formdata['code'] = addslashes(str_replace('#wz#',$str,$code));
            $this->db->update('block',$formdata,array('blockid'=>$blockid));
            set_cache('block_'.$blockid,$formdata,'block');
            //生成静态
            if($formdata['createhtml']) {
                $GLOBALS['blockids'] = array($blockid);
                $this->html(0);
            }
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('block',array('blockid'=>$blockid));
            $r['code'] = stripslashes($r['code']);
            $models = $this->db->get_list('model', '', '*', 0, 100, 0, 'modelid ASC');
            include $this->template('block_edit');
        }
    }
    /**
     * 删除区块
     */
    public function delete() {
        $blockid = isset($GLOBALS['blockid']) ? intval($GLOBALS['blockid']) : 0;
        if(!$blockid) MSG(L('操作失败'));
        $this->db->delete('block',array('blockid'=>$blockid));

        MSG(L('operation success'),HTTP_REFERER,500);
    }

    /**
     * 生成静态
     */
    public function html($return = true) {
        load_function('content','content');
        define('HTML',TRUE);
        if(is_array($GLOBALS['blockids'])) {
            $template = load_class('template');
            $webroot = WWW_ROOT.ltrim(WWW_PATH,'/').'webs/';
            if(!is_dir($webroot)) @mkdir($webroot, 0777, true);
            foreach($GLOBALS['blockids'] as $blockid) {
                $r = $this->db->get_one('block',array('blockid'=>$blockid));
				$r['code'] = stripslashes($r['code']);
                $code = $template->template_parse($r['code']);
                $cache_path = CACHE_ROOT.'templates/default/block/';
                if(!is_dir($cache_path)) @mkdir($cache_path, 0777, true);
                file_put_contents($cache_path.$blockid.'.php', $code);
                ob_start();
                include $cache_path = CACHE_ROOT.'templates/default/block/'.$blockid.'.php';
                $contents = ob_get_contents();
                ob_end_clean();

                file_put_contents($webroot.$blockid.'.html',$contents);
            }
        }
        if($return) MSG(L('create success'));
    }

    /**
     * 添加自定义内容
     */
    public function add_content() {
        $blockid = $GLOBALS['blockid'];
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['keyid'] = '';
            $formdata['blockid'] = $blockid;
            $formdata['addtime'] = SYS_TIME;
            $formdata['siteid'] = get_cookie('siteid');
            $formdata['isdiy'] = 1;

            $formdata = array_map('remove_xss',$formdata);
            if(isset($GLOBALS['attform'])) {
                $attform = $GLOBALS['attform'];
                $attform = array_map('remove_xss',$attform);
                $formdata['attach'] = serialize($attform);
            }
            $this->db->insert('block_data',$formdata);

            $forward = '?m=content&f=block&v=item_listing&blockid='.$blockid.$this->su();
            MSG(L('add success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $rs = $this->db->get_one('block',array('blockid'=>$blockid));
            $attach = '';

            $result = $this->db->get_list('kind', array('keyid'=>'interest'), '*', 0, 50, 0, 'kid ASC');
            $interest = key_value($result,'maxid','name');
            include $this->template('block_add_content');
        }
    }
}