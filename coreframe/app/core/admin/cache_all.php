<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 更新所有缓存
 */
load_class('admin');

class cache_all extends WUZHI_admin {
    private $db;
   public function __construct() {
        $this->db = load_class('db');
    }
    public function index() {
        $where = array('keyid'=>'cache_all');
        $result = $this->db->get_list('setting', $where, '*', 0, 100);
        include $this->template('cache_all');
    }
    //更新缓存
    public function cache() {
       $caches = load_class($GLOBALS['file'],$GLOBALS['module']);
       if($caches->$GLOBALS['view']()) {
             MSG(L('operation success'),HTTP_REFERER);
       } else {
           MSG(L('operation failure'));
       }

    }
    //更新全部或者更新选择的
    public function cache_select() {
        $uid = $_SESSION['uid'];
        if(isset($GLOBALS['setcache'])) {
            $ids = get_cache('cache_all-'.$uid);
        } else {
            if(!isset($GLOBALS['ids']) || empty($GLOBALS['ids'])) {
                $where = array('keyid'=>'cache_all');
                $result = $this->db->get_list('setting', $where, '*', 0, 100);
                $ids = array();
                foreach($result as $r) {
                    $ids[] = $r['id'];
                }
            } else {
                $ids = array_map('intval',$GLOBALS['ids']);
            }
            set_cache('cache_all-'.$uid,$ids);
        }
        if(empty($ids)) MSG('缓存更新完成','?m=core&f=cache_all&v=index'.$this->su(),2000);
        $id = array_shift($ids);
        $r = $this->db->get_one('setting',array('id'=>$id));
        $caches = load_class($r['f'],$r['m']);
        if($caches->$r['v']()) {
            set_cache('cache_all-'.$uid,$ids);
            MSG($r['data'].L('update success'),'?m=core&f=cache_all&v=cache_select&setcache=1&'.$this->su(),200);
        } else {
            MSG(L('operation failure'));
        }
    }
}
?>