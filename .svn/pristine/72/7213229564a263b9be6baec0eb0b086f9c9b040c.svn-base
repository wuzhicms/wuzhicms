<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 支付配置
 */
load_class('admin');
class pay_config extends WUZHI_admin {
	private $db;


	function __construct() {
		$this->db = load_class('db');

	}
    /**
     * 列表
     */
    public function listing() {
        $status_arr = array(0=>'开发中',1=>'使用中',2=>'关闭');
        $result = $this->db->get_list('payment', "", '*', 0, 100,'id ASC');
        include $this->template('config_listing');
    }


    /**
     * 修改配置
     */
    public function edit() {

        $id = intval($GLOBALS['id']);
        $r = $this->db->get_one('payment',array('id'=>$id));
        if(!$r) MSG('支付方式不存在');
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['note'] = isset($GLOBALS['note']) ? remove_xss($GLOBALS['note']) : '';
            $formdata['setting'] = isset($GLOBALS['setting']) ? serialize($GLOBALS['setting']) : '';
            $formdata['status'] = intval($GLOBALS['status']);
            $this->db->update('payment',$formdata,array('id'=>$id));

            MSG(L('operation_success'),'?m=pay&f=pay_config&v=listing'.$this->su(),500);
        } else {
            if($r['status']==0) MSG('该功能尚未开发，如需帮助，请联系我们！');
            $show_formjs = 1;
            $setting  =  array();
            $setting = unserialize($r['setting']);
            include $this->template('config_'.$id);
        }
    }
}