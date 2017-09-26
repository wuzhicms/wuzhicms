<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 问题反馈管理
 */
load_class('admin');
class index extends WUZHI_admin {
    private $db;

    function __construct() {
        $this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
    }
    /**
     * 问题反馈列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $status=array(8=>'已回复',9=>'未回复');
        $result = $this->db->get_list('feedback', '', '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }
        include $this->template('listing');
    }


    /**
     * 查看
     */
    public function reply() {
        $id = intval($GLOBALS['id']);
        $reply_user = get_cookie('wz_name');
        if(isset($GLOBALS['submit'])) {
            $status = 8;//已回复
            if(!empty($GLOBALS['reply_user'])) $reply_user = remove_xss($GLOBALS['reply_user']);
            $this->db->update('feedback',array('status'=>$status,'reply'=>$GLOBALS['reply'],'replytime'=>SYS_TIME,'reply_user'=>$reply_user),array('id'=>$id));
			MSG("更新成功,窗口即将自动关闭<script>setTimeout('top.dialog.get(window).close().remove();',2000)</script>");
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            load_function('admin');
            $r = $this->db->get_one('feedback',array('id'=>$id));
			$set_iframe_url = 0;
            include $this->template('reply');
        }
    }


    /**
     * 删除留言
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('feedback',array('id'=>$id));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}