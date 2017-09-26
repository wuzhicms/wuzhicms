<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 静态资源管理
 */
define('TPL_ROOT',WWW_ROOT.'res/');
load_class('admin');
class res extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->dir = isset($GLOBALS['dir']) && trim($GLOBALS['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', trim($GLOBALS['dir'])) : '';
        $this->dir = str_ireplace( array('%2F','//'),'/',$this->dir);
	}

    public function listing() {
        $dir = $this->dir;
        $lists = glob(TPL_ROOT.$dir.'/'.'*');
		if(empty($lists)) {
			MSG('/res/目录没有内容，此功能无法使用！');
		}
        //if(!empty($lists)) rsort($lists);
        $cur_dir = str_replace(array( WWW_ROOT ,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), TPL_ROOT.$dir.'/');
        $show_dialog = 1;
        include $this->template('res_listing');
    }

    /**
     * 修改模版
     */
    public function edit() {
        $dir = $this->dir;

        $file = $GLOBALS['file'];
        if(preg_match('/([^a-z0-9_\-\.]+)/i',$file)) MSG(L('file name error'));
        $extent = get_ext($file);
        if(!in_array($extent,array('js','css'))) {
            MSG(L('not support edit this file'));
        }
        $keyid = md5($dir.$file);
        $configs = include COREFRAME_ROOT.'configs/wz_config.php';
        if(isset($GLOBALS['submit'])) {

            if(!EDIT_TPL) MSG(L('online edit template has disabled'));
            //模板可写判断
            if(!is_writable(TPL_ROOT.$dir.'/'.$file.'.html')) MSG(L('readonly file',array('file'=>$dir.'/'.$file.'.html')));

            $uid = $_SESSION['uid'];
            $username = get_cookie('username');

            $code = $GLOBALS['wzhtml'];
            file_put_contents(TPL_ROOT.$dir.'/'.$file.'.html',$code);
            $code = addslashes($code);

            $this->db->insert('template_history',array('keyid'=>$keyid,'dir'=>$dir,'file'=>$file,'data'=>$code,'addtime'=>SYS_TIME,'uid'=>$uid,'username'=>$username));
            //写入文件

            MSG(L('edit success'),HTTP_REFERER);
        } else {
            if(!file_exists(TPL_ROOT.$dir.'/'.$file)) {
                MSG(L('file does not exists'));
            }
            $code = file_get_contents(TPL_ROOT.$dir.'/'.$file);
            $code = p_htmlspecialchars($code);

            $r = $this->db->get_one('template_history',array('keyid'=>$keyid));
            if(!$r) {//数据不存在时，添加最初始的模版
                $uid = $_SESSION['uid'];
                $username = get_cookie('username');
                $code = addslashes($code);
                $this->db->insert('template_history',array('keyid'=>$keyid,'dir'=>$dir,'file'=>$file,'data'=>$code,'addtime'=>SYS_TIME,'uid'=>$uid,'username'=>$username));
            }

            $ext = '';
            if($extent=='js') {
                $editext = 'javascript';
            } elseif($extent=='css') {
                $editext = 'css';
            }
            include $this->template('edit');
        }
    }
    /**
     * 查看模版记录：历史版本列表
     */
    public function history() {
        $dir = $this->dir;

        $file = $GLOBALS['file'];
        if(preg_match('/([^a-z0-9_\-\.]+)/i',$file)) MSG(L('file name error'));
        $cur_dir = str_replace(array( COREFRAME_ROOT ,DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array('',DIRECTORY_SEPARATOR), TPL_ROOT.$dir.'/');
        $keyid = md5($dir.$file);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('template_history', array('keyid'=>$keyid), '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        include $this->template('history');
    }

    /**
     * 查看历史详情
     */
    public function view() {
        $dir = $this->dir;
        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('template_history',array('id'=>$id));
        $code = $r['data'];
        $dir = str_ireplace( array('%2F','//'),'/',$dir);
        $file = $GLOBALS['file'];
        include $this->template('view');
    }

    public function delete() {
        $configs = include COREFRAME_ROOT.'configs/wz_config.php';
        if(!EDIT_TPL) MSG(L('online edit template has disabled'));
        $file = $GLOBALS['file'];
        if(preg_match('/([^a-z0-9_\-\.]+)/i',$file)) MSG(L('file name error'));
        $dir = $this->dir;
        $extent = get_ext($file);
        if(in_array($extent,array('js','css'))) {
        //删除前，将文件保存到数据
            $code = file_get_contents(TPL_ROOT.$dir.'/'.$file.'.html');
            $code = addslashes($code);
            $keyid = md5($dir.$file);
            $uid = $_SESSION['uid'];
            $username = get_cookie('username');
            $this->db->insert('template_history',array('keyid'=>$keyid,'dir'=>$dir,'file'=>$file,'data'=>$code,'addtime'=>SYS_TIME,'uid'=>$uid,'username'=>$username));
        }
        unlink(TPL_ROOT.$dir.'/'.$file.'.html');
        MSG(L('operation success'));
    }
}