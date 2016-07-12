<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');
class mec extends WUZHI_admin {
	private $db, $group;
	function __construct() {
		$this->member = load_class('member', M);
		$this->db = load_class('db');
		$this->group = get_cache('group', M);
		$this->model = $this->db->get_list('model', '`m`="member"', 'modelid,name,attr_table', 0, 200, 0, '', '', 'modelid');
		$this->setting = get_cache('setting', 'member');
	}
	/**
	 * 审核机构
	 */
	public function listing() {
		$page = max(1, (isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1));

		$keyArr = array('username'=>'用户名', 'uid'=>'UID', 'email'=>'Email', 'mobile'=>'手机');
		$keyType = isset($GLOBALS['keyType']) && isset($keyArr[$GLOBALS['keyType']]) ? $GLOBALS['keyType'] : 'username';
		$keyValue = isset($GLOBALS['keyType']) ? sql_replace($GLOBALS['keyValue']) : '';
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		$loginTimeStart = isset($GLOBALS['loginTimeStart']) ? strtotime($GLOBALS['loginTimeStart']) : '';
		$loginTimeEnd = isset($GLOBALS['loginTimeEnd']) ? strtotime($GLOBALS['loginTimeEnd']) : '';
		$groupid = 5;

		$where = 'groupid = 5 AND checkmec=0';
		if(isset($GLOBALS['search'])){
			if($keyValue){
				$where = ' AND '.$keyType.'="'.$keyValue.'"';
			}else{
				$where .= $regTimeStart ? ' AND regtime >= '.$regTimeStart : '';
				$where .= $regTimeEnd ? ' AND regtime <= '.$regTimeEnd+86400 : '';
				$where .= $loginTimeStart ? ' AND lasttime >= '.$loginTimeStart : '';
				$where .= $loginTimeEnd ? ' AND lasttime <= '.$loginTimeEnd+86400 : '';
			}
			$where = substr($where, 4);
		}
		$result = $this->db->get_list('member', $where, '*', 0, 20, $page,'uid DESC');
		$pages = $this->db->pages;
		$group = $this->group;
		include $this->template('member_mec_listing');
	}

	/**
	 * 审核机构
	 */
	public function check() {
		$uid = (int)$GLOBALS['uid'];
		if($uid) $member = $this->db->get_one('member', '`uid`='.$uid, '*');
		if(empty($member))MSG(L('user not_exists'));
		if(isset($GLOBALS['submit'])) {
			$modelid = 23;

			//	判断模型是否有设置字段
			$formdata = isset($GLOBALS['form']) ? $GLOBALS['form'] : '';
			if($formdata){
				require get_cache_path('member_add', 'model');
				$form = new form_add($modelid);
				$formdata = $form->execute($formdata);
				$formdata['master_data']['checkmec'] = 1;
				$formdata['master_data']['mecid'] = intval($GLOBALS['mecid']);
				$this->db->update('member', $formdata['master_data'], array('uid' => $uid));

				if($formdata['attr_table'] && !empty($formdata['attr_data']))$this->db->update($formdata['attr_table'],$formdata['attr_data'], '`uid`='.$uid);
				//执行更新
				require get_cache_path('member_update', 'model');
				$form_update = new form_update($modelid);
				$form_update->execute($formdata);
			}
			MSG('审核通过',$GLOBALS['forward']);
		} else {
			if(isset($GLOBALS['modelid']) && $GLOBALS['modelid'] != $member['modelid']){
				$modelid = (int)$GLOBALS['modelid'];
			}else{
				$modelid = $member['modelid'];
			}
			//	判断是否有模型id参数
			if($modelid){
				require get_cache_path('member_form','model');
				$form_build = new form_build($modelid);
				$formdata = $form_build->execute($member);
			}
			$group = $this->group;
			$show_dialog = 1;
			$show_formjs = 1;
			include $this->template('member_mec_check');
		}
	}
}