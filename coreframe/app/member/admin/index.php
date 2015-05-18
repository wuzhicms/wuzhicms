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
class index extends WUZHI_admin {
	private $db, $member;
	function __construct() {
		$this->member = load_class('member', M);
		$this->db = load_class('db');
		$this->group = get_cache('group', M);
		$this->model = $this->db->get_list('model', '`m`="member"', 'modelid,name,attr_table', 0, 200, 0, '', '', 'modelid');
		$this->setting = get_cache('setting', 'member');
	}
	/**
	 * 后台用户列表
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
		$groupid = isset($GLOBALS['groupid']) ? intval($GLOBALS['groupid']) : '';
			
		$where = '';
		if(isset($GLOBALS['search'])){
			if($keyValue){
				$where = ' AND '.$keyType.'="'.$keyValue.'"';
			}else{
				$where .= $groupid ? ' AND groupid = '.$groupid : '';
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
		include $this->template('member_listing', M);
	}
	/**
	 * 添加用户
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			if(!$this->member->add($GLOBALS['info'])) MSG(L('operation_failure'));
			MSG(L('operation_success'),'?m=member&f=index&v=listing'.$this->su());
		} else {
			$group = $this->group;
			include $this->template('member_add', M);
		}
	}
	/**
	 * 编辑用户
	 */
	public function edit() {
		$uid = (int)$GLOBALS['uid'];
		if($uid)$member = $this->db->get_one('member', '`uid`='.$uid, '*');
		if(empty($member))MSG(L('user not_exists'));
		if(isset($GLOBALS['submit'])) {
			$GLOBALS['info']['factor'] = $member['factor'];
			$GLOBALS['info']['username'] = $member['username'];
			if(!$this->member->edit($GLOBALS['info'], $uid)) MSG(L('operation_failure'));
			$modelid = (int)$GLOBALS['info']['modelid'];
			
			//	判断是否有变更用户模型
			if($modelid != $member['modelid']){
				//	判断新的模型是否有用户数据
				if(!$this->db->get_one($this->model[$modelid]['attr_table'], 'uid='.$uid, 'uid')){
					$this->db->insert($this->model[$modelid]['attr_table'], array('uid'=>$uid));
				}else{
					//	删除旧模型的数据
					$this->db->query('DELETE FROM `wz_'.$this->model[$member['modelid']]['attr_table'].'` WHERE `uid`='.$uid);
				}
			}
			//	判断模型是否有设置字段
			$formdata = isset($GLOBALS['form']) ? $GLOBALS['form'] : '';
			if($formdata){
				require get_cache_path('member_add', 'model');
				$form = new form_add($modelid);
				$formdata = $form->execute($formdata);
            	if($formdata['attr_table'])$this->db->update($formdata['attr_table'],$formdata['attr_data'], '`uid`='.$uid);
				//执行更新
				require get_cache_path('member_update', 'model');
				$form_update = new form_update($modelid);
				$form_update->execute($formdata);
			}
			MSG(L('operation_success').'<script>$("#u_'.$uid.' td", top.window.frames["iframeid"].document).css("background-color", "#EFD04C");top.dialog.get(window).close().remove();</script>');
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
			include $this->template('member_edit', M);
		}
	}
	/**
	 * 删除用户
	 */
	public function del() {
		if(isset($GLOBALS['uid']) && $GLOBALS['uid']) {
			if(is_array($GLOBALS['uid'])){
				$GLOBALS['uid'] = array_map('intval', $GLOBALS['uid']);
				$where = ' IN ('.implode(',', $GLOBALS['uid']).')';
			}else{
				$where = ' = '.intval($GLOBALS['uid']);
			}
			$user = $this->db->get_list('member', 'uid'.$where, 'uid,modelid,ucuid');
			if($this->setting['ucenter'])$ucenter = load_class('ucenter', M);
			if($user)foreach ($user as $v){
				$this->db->delete('member', 'uid='.$v['uid']);
				//	这里要判断一下是不是选了模型  刚刚注册的会员是没有模型值的
				if($v['modelid'])$this->db->delete($this->model[$v['modelid']]['attr_table'], 'uid='.$v['uid']);
				//	删除登录信息
				$this->db->delete('logintime', 'uid='.$v['uid']);
				//	判断是否启用了uc
				if($this->setting['ucenter'] && $v['ucuid']){
					$ucenter->delete($v['ucuid']);
				}
				//	删除第三方通行证
				$this->db->delete('member_auth', 'uid='.$v['uid']);
			}
			
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":1})';
			}else{
				MSG(L('operation_success'),HTTP_REFERER);
			}
		}else{
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":0})';
			}else{
				MSG(L('error'));
			}
		}
	}
	/**
	 * 
	 * 重置密码
	 * @param int $uid
	 * @param string $email
	 * @param string $password
	 */
	public function password($uid=0, $username='', $email='', $password=''){
		$uid = $uid ? $uid : (int)$GLOBALS['uid'];
		$email = $email ? $email : $GLOBALS['email'];
		$username = $username ? $username : $GLOBALS['username'];
		if($this->member->password($uid, $username, $email, $password)){
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":1})';
			}else{
				return true;
			}
		}else{
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":0})';
			}else{
				return false;
			}
		}
	}
	public function set(){
		if(isset($GLOBALS['submit'])){
			$setting = $this->db->update('setting', array('data'=>serialize($GLOBALS['setting'])), 'keyid="setting" AND m="member"', 'data');
			set_cache('setting', $GLOBALS['setting'], M);
			$uc_config = "<?php\ndefined('IN_WZ') or exit('No direct script access allowed');\nreturn array (
				'default' => array (
					'dbhost' => '".$GLOBALS['setting']['uc_dbhost']."', 
					'dbname' => '".$GLOBALS['setting']['uc_dbname']."',
					'username' => '".$GLOBALS['setting']['uc_dbuser']."',
					'password' => '".$GLOBALS['setting']['uc_dbpw']."',
					'tablepre' => '".$GLOBALS['setting']['uc_dbtablepre']."',
					'dbcharset' => '".$GLOBALS['setting']['uc_dbcharset']."',
					'type' => 'mysql',
					'pconnect' => 0,
				),);?>";
			if(!@file_put_contents(WWW_ROOT.'configs/uc_mysql_config.php', $uc_config)){
				MSG('configs/uc_mysql_config.php'.L('not_writable'), HTTP_REFERER, 3000);
			}
			MSG( L('operation_success'), HTTP_REFERER, 3000);
		}else{
			$setting = $this->db->get_one('setting', 'keyid="setting" AND m="member"', 'data');
			if($setting){
				$setting = unserialize($setting['data']);
                set_cache('setting', $setting, M);
			}else{
				$setting = array();
			}
			$group = $this->group;
			include $this->template('setting',M);
		}
	}
	public function check_uc(){
		$uc_dbhost = isset($GLOBALS['uc_dbhost']) && trim($GLOBALS['uc_dbhost']) ? trim($GLOBALS['uc_dbhost']) : exit('0');
		$uc_dbuser = isset($GLOBALS['uc_dbuser']) && trim($GLOBALS['uc_dbuser']) ? trim($GLOBALS['uc_dbuser']) : exit('0');
		$uc_dbpw = isset($GLOBALS['uc_dbpw']) && trim($GLOBALS['uc_dbpw']) ? trim($GLOBALS['uc_dbpw']) : exit('0');
		if (@mysql_connect($uc_dbhost, $uc_dbuser, $uc_dbpw)) {
			exit('1');
		} else {
			exit('0');
		}
	}
    /**
     * 查看用户信息
     */
    public function view() {
        $uid = (int)$GLOBALS['uid'];
        if($uid)$member = $this->db->get_one('member', '`uid`='.$uid, '*');
        if(empty($member))MSG(L('user not_exists'));

            if(isset($GLOBALS['modelid']) && $GLOBALS['modelid'] != $member['modelid']){
                $modelid = (int)$GLOBALS['modelid'];
            }else{
                $modelid = $member['modelid'];
            }
            //	判断是否有模型id参数
            if($modelid){
                require get_cache_path('content_format','model');
                $form_format = new form_format($modelid);
                $data = $form_format->execute($member);
            }
            $fields = $form_format->fields;
            $fields['mobile']['name'] = '手机';
            $fields['email']['name'] = 'email';
            $fields['username']['name'] = '用户名';
            $fields['truename']['name'] = '真是姓名';
            $fields['money']['name'] = '拥有金额';
            $fields['points']['name'] = '积分';
            $fields['identity_card']['name'] = '身份证号';
            $fields['address']['name'] = '地址';
            $fields['livecity']['name'] = '居住城市';

            $group = $this->group;
            include $this->template('member_view', M);
    }
}