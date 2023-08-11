<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_function('common', M);

class replace_file extends WUZHI_admin
{
    private $db;

    function __construct()
    {
        $this->db = load_class('db');
        $GLOBALS['_menuid'] = isset($GLOBALS['_menuid']) ? intval($GLOBALS['_menuid']) : '';
        $this->_cache = get_cache(M);
    }

    public function listing()
    {
		$this->setconfig();
    }
    public function setconfig() {
		//http://p1.zgw.wuzhicms.com/uploadfile
		$type = 'down';
		if(isset($GLOBALS['submit'])) {

			$current_path = trim($GLOBALS['setting']['current_path']);
			$path = trim($GLOBALS['setting']['path']);
			$query = $this->db->query("UPDATE `wz_download_data` SET `downfiles` = REPLACE(`downfiles`, '$current_path', '$path')");
			$nums = $this->db->affected_rows($query);
			$this->db->update('setting', array('data'=>$path),array('keyid' => 'uploaddir','m'=>'attachment','v'=>$type));
			MSG('替换成功，总共影响了：'.$nums.' 条','?m=attachment&f=replace_file&v=listing'.$this->su());
		} else {
			$data = $this->db->get_one('setting', array('keyid' => 'uploaddir','m'=>'attachment','v'=>$type));

			include $this->template('replace_file_setconfig', M);
		}

	}

}