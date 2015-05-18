<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 积分管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 积分列表
     */
    public function listing() {
        $cardid = intval($GLOBALS['cardid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('credit', '', '*', 0, 20,$page,'jid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 积分配置
     */
    public function set() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array_map('remove_xss',$GLOBALS['form']);
            set_cache('point_config',$formdata);
            $serialize_data = serialize($formdata);
            $updatetime = date('Y-m-d H:i:s',SYS_TIME);
            $this->db->update('setting',array('data'=>$serialize_data,'updatetime'=>$updatetime),array('keyid'=>'configs','m'=>'credit'));
            MSG(L('edit success'),HTTP_REFERER);
        } else {
            $setting = array();
            $r = $this->db->get_one('setting',array('keyid'=>'configs','m'=>'credit'));
            $setting = unserialize($r['data']);
            load_class('form');
            include $this->template('set');
        }
    }
    /**
     * 积分入帐
     */
    public function add() {
        $config = get_cache('point_config');
        if($config['status']!=1) MSG('未开启后台积分入帐，如需开启请在积分配置中开启');
        if(isset($GLOBALS['submit'])) {
            load_function('common','pay');
            $formdata = array();
            $formdata['username'] = remove_xss($GLOBALS['username']);
            $mr = $this->db->get_one('member',array('username'=>$formdata['username']));

            if(!$mr) MSG('用户不存在');
            $formdata['uid'] = $mr['uid'];
            $plus_minus = intval($GLOBALS['plus_minus']);
            $username = get_cookie('username');
            $point = intval($GLOBALS['point']);
            if($plus_minus==1) {
                $plus_minus_type = '增加';
                $plus_minus = '+';
                $left_point = $mr['points']+$point;
            } else {
                $plus_minus_type = '减少';
                $plus_minus = '-';
                $left_point = $mr['points']-$point;
                if($left_point<=0) {
                    MSG('用户积分为：'.$mr['points'].'，不足扣除'.$point);
                }
            }

            $payname = $username.'后台管理：'.$plus_minus_type.'积分，用户剩余积分：'.$left_point.'<br>'.$GLOBALS['note'];


            $credit_api = load_class('credit_api','credit');
            $credit_api->handle($mr['uid'], $plus_minus, $point, $payname);
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $options = $this->db->get_list('kind',array('keyid'=>'link'));
            $options = key_value($options,'kid','name');
            include $this->template('add');
        }
    }
}