<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
set_time_limit(300);
/**
 * 敏感词管理
 */
load_class('admin');

class badword extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}

    /**
     * 敏感词列表
     */
    public function sdf() {

    }
    /**
     * 敏感词列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('badword', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        include $this->template('badword_listing');
    }
    /**
     * 添加敏感词
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $words = explode("\n",$GLOBALS['badword']);
            foreach($words as $word) {
                $word = trim($word);
                if(empty($word)) continue;
                $uid = $_SESSION['uid'];
                $r = $this->db->get_one('badword',array('word'=>$word));
                if($r) continue;
                $word = remove_xss($word);
                $this->db->insert('badword',array('word'=>$word,'addtime'=>SYS_TIME,'uid'=>$uid));

            }
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            include $this->template('badword_add');
        }
    }

    /**
     * 删除敏感词
     */
    public function delete() {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
        if(!$id) MSG(L('操作失败'));
        $this->db->delete('badword',array('id'=>$id));
        MSG(L('operation success'),HTTP_REFERER,500);
    }
}