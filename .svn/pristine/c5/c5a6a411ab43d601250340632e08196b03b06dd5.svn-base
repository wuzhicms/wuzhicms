<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class index {
 	function __construct() {
	}
	public function listing() {
        $seo_title = '网站公告';
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        include T('affiche','list');
	}
    public function show() {
        $seo_title = '公告';
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG('参数错误');
        $this->db = load_class('db');
        $r = $this->db->get_one('affiche',array('id'=>$id));
        $_uid = get_cookie('_uid');

        if($r['status']==2 || is_numeric($_uid)) {
            extract($r,EXTR_SKIP);
            include T('affiche','show');
        } elseif($r['status']==1) {
            MSG('需要登录才可以查看','index.php?m=member&f=index&v=login');
        } else {
            MSG('参数错误');
        }
    }
}