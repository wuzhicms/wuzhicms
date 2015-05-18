<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 推广
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 最新推广名单
     */
    public function listing() {
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('ppc', '', '*', 0, 20,$page,'id DESC');
        $ip_location = load_class('ip_location');
        foreach($result as $key=>$rs) {
            $result[$key]['ip_location'] = $ip_location->seek($rs['ip'],1);
        }

        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 配置
     */
    public function setting() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            set_cache('setting',$formdata,'ppc');
            $serialize_data = serialize($formdata);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $r = $this->db->get_one('setting',array('keyid'=>'configs','m'=>'ppc'));
            if($r) {
                $this->db->update('setting',array('data'=>$serialize_data,'updatetime'=>$updatetime),array('keyid'=>'configs','m'=>'ppc'));
            } else {
                $this->db->insert('setting',array('keyid'=>'configs','m'=>'ppc','data'=>$serialize_data,'updatetime'=>$updatetime));
            }
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $show_formjs = true;
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'configs','m'=>'ppc'));
            $setting = unserialize($r['data']);
            include $this->template('setting');
        }
    }
}