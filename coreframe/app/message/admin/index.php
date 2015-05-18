<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 在线支付
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 站内私信列表
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('message', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 添加公告
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            if(empty($GLOBALS['usernames'])) MSG('收件人不能为空');
            if(empty($GLOBALS['content'])) MSG('不能发送空白内容');

            $formdata = array();
            $formdata['content'] = remove_xss($GLOBALS['content']);
            $formdata['addtime'] = SYS_TIME;
            $formdata['uid'] = $_SESSION['uid'];
            $formdata['username'] = $_SESSION['uid'];
            $usernames = $GLOBALS['usernames'];
            $usernames = explode(',',$usernames);
            $success_user = $error_user = array();
            foreach($usernames as $name) {
                $mr = $this->db->get_one('member',array('username'=>$name));
                if($mr) {
                    $success_user[] = $name;
                    $formdata['touid'] = $mr['uid'];
                    $this->db->insert('message',$formdata);
                } else {
                    $error_user[] = $name;
                }
            }
            $success_user = implode(',',$success_user);
            $error_user = implode(',',$error_user);
            MSG('成功发送给：'.$success_user.'<br>失败用户名：'.$error_user);
        } else {
            $show_formjs = 1;
            include $this->template('add');
        }
    }

    /**
     * 删除公告
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('message',array('id'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}