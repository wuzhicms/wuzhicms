<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_group {
	private $db;
	public function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 添加
	 * @param	array	$data
	 * @return	boolean
	 */
	public function add($data){
		$info = $this->format($data);
		if(is_array($info)) $groupid = $this->db->insert('member_group', $info, true);
		return $groupid ? $groupid : false;
	}
	/**
	 * 编辑
	 * @param	array	$data
	 * @param	int		$uid
	 * @return	boolean
	 */
	public function edit($data, $groupid){
		$info = $this->format($data, $groupid);
		return $this->db->update('member_group', $info, '`groupid`='.$groupid);
	}
	/**
	 * 缓存
	 */
	public function set_cache(){
		$data = $this->db->get_list('member_group', '', '*', 0, 200, 0, '', '', 'groupid');
		set_cache('group', $data, 'member');
		unset($data);
	}
	/**
	 * 
	 * 检查组名是否可用
	 * @param	string	$name		要验证的组名
	 * @param	int		$groupid	组id
	 * @param	int		$return		返回的数据格式
	 * @return	boolean or json
	 */
	public function check_name($name, $groupid=0, $return = 0){
		if(empty($name))return $return ? '{"status":"n"}' : false;
		$data = $this->db->get_one('member_group', '`name` = "'.$name.'"', 'groupid');
		return empty($data) || $data['groupid'] == $groupid ? ($return ? '{"info":"'.L('check_ok', '', 'member').'","status":"y"}' : true): ($return ? '{"info":"'.L('group_exist', '', 'member').'","status":"n"}' : false);
	}
	/**
	 * 数据处理
	 * @param	$data		要处理的数据
	 * @param	$groupid	组id
	 * @return	boolean or array
	 */
	private function format($data, $groupid=0){
		if(!is_array($data))return false;
		$info = array();
		$info['name'] = $this->check_name($data['name'], $groupid) ? $data['name'] : MSG(L('group_exist', '', 'member'));
		$info['pid'] = intval($data['pid']);
		$info['sort'] = intval($data['sort']);
		$info['points'] = intval($data['points']);
		$info['upgrade'] = isset($data['upgrade']) ? 1 : 0;
		$info['money_y'] = round($data['money_y'], 2);
		$info['money_m'] = round($data['money_m'], 2);
		$info['money_d'] = round($data['money_d'], 2);
		return $info;
	}
}