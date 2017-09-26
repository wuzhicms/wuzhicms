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
		$sta_arr = array(-1=>'所有状态',1=>'审核通过',0=>'待审核',3=>'审核不通过');
		$keyArr = array('username'=>'用户名', 'uid'=>'UID', 'email'=>'Email', 'mobile'=>'手机');
		$keyType = isset($GLOBALS['keyType']) && isset($keyArr[$GLOBALS['keyType']]) ? $GLOBALS['keyType'] : 'username';
		$keyValue = isset($GLOBALS['keyType']) ? sql_replace($GLOBALS['keyValue']) : '';
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		$loginTimeStart = isset($GLOBALS['loginTimeStart']) ? strtotime($GLOBALS['loginTimeStart']) : '';
		$loginTimeEnd = isset($GLOBALS['loginTimeEnd']) ? strtotime($GLOBALS['loginTimeEnd']) : '';
		$groupid = isset($GLOBALS['groupid']) ? intval($GLOBALS['groupid']) : '';
		$modelid = isset($GLOBALS['modelid']) ? intval($GLOBALS['modelid']) : 10;
		$checkmec = isset($GLOBALS['checkmec']) ? intval($GLOBALS['checkmec']) : -1;
		$extgid = intval($GLOBALS['extgid']);
		$modelid = intval($GLOBALS['modelid']);

		$group = $ext_group = array();
if(is_array($this->group)){
		foreach($this->group as $gr) {
			if($gr['issystem']==1) {
				$group[$gr['groupid']] = $gr;
			} else {
				//if(in_array($gr['groupid'],array(20,22,32,34))) $gr['pid'] = 0;
				$gr['selected'] = $extgid==$gr['groupid'] ? 'selected' : '';
				$ext_group[$gr['groupid']] = $gr;
			}
		}
}
		$tree = load_class('tree','core',$ext_group);
		$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
		//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
		$tree_data = '';

		//格式字符串
		$str = "<option value=\$id \$selected \$disable>\$spacer\$name</option>";
		//返回树
		$tree_data.=$tree->create(0,$str);
		$string = '<select name="extgid" class="form-control">';
		$string .= "<option>≡ 扩展会员组 ≡</option>";
		$string .= $tree_data;
		$string .= '</select>';

		if($extgid) {
			$where = "m.uid=e.uid";
			if(isset($GLOBALS['search'])){

				if($keyType=='username' || $keyType=='fullname'|| $keyType=='fullname_en') {
					$where .= " AND m.`$keyType` LIKE '%$keyValue%'";
				}elseif($keyValue){
					$where .= ' AND m.'.$keyType.'="'.$keyValue.'"';
				}
				$where .= $groupid ? ' AND m.groupid = '.$groupid : '';
				$where .= ' AND e.groupid = '.$extgid;
				$where .= $modelid ? " AND m.modelid LIKE '%".$modelid."%'" : '';

				if($regTimeStart) {
					$where .= ' AND m.regtime >= '.$regTimeStart;
				}
				if($regTimeEnd) {
					$regTimeEnd = $regTimeEnd+86400;
					$where .= ' AND m.regtime <= '.$regTimeEnd;
				}

				$where .= $loginTimeStart ? ' AND m.lasttime >= '.$loginTimeStart : '';
				$where .= $loginTimeEnd ? ' AND m.lasttime <= '.$loginTimeEnd+86400 : '';

			}
			$models = get_cache('model_member','model');
			$sql1 = "SELECT count(DISTINCT(m.uid)) as num FROM wz_member m,wz_member_group_extend e WHERE ".$where." ";
			$sql2 = "SELECT *,m.groupid FROM wz_member m,wz_member_group_extend e WHERE ".$where." GROUP BY m.uid ORDER BY m.uid DESC";
			$s_count  = $this->db->get_page_list_count($sql1,$where);
			$result_arr = $this->db->get_page_list($sql2,0,10,$page);
			$pages = pages($s_count['num'], $page, 10);
			$result = array();
			foreach($result_arr as $r) {
				$r['group_extend'] = $this->db->get_list('member_group_extend', array('uid'=>$r['uid']), '*', 0, 20, 0, 'extid ASC');
				$r['modelid'] = explode(',',$r['modelid']);

				$result[] = $r;
			}
		} else {
			if(isset($GLOBALS['search'])){
				$where = "1";
				if($keyType=='username' || $keyType=='fullname'|| $keyType=='fullname_en') {
					$where .= " AND `$keyType` LIKE '%$keyValue%'";
				}elseif($keyValue) {
					$where .= ' AND '.$keyType.'="'.$keyValue.'"';
				}
				$where .= $groupid ? ' AND groupid = '.$groupid : '';
				$where .= $modelid ? " AND modelid LIKE '%".$modelid."%'" : '';
				if($regTimeStart) {
					$where .= ' AND regtime >= '.$regTimeStart;
				}
				if($regTimeEnd) {
					$regTimeEnd = $regTimeEnd+86400;
					$where .= ' AND regtime <= '.$regTimeEnd;
				}

				$where .= $loginTimeStart ? ' AND lasttime >= '.$loginTimeStart : '';
				$where .= $loginTimeEnd ? ' AND lasttime <= '.$loginTimeEnd+86400 : '';
				if($checkmec>-1) {
					$where .= ' AND checkmec = '.$checkmec;
				}
			}
			$models = get_cache('model_member','model');
			$result_arr = $this->db->get_list('member', $where, '*', 0, 10, $page,'uid DESC');
			$pages = $this->db->pages;
			$result = array();
			foreach($result_arr as $r) {
				$r['group_extend'] = $this->db->get_list('member_group_extend', array('uid'=>$r['uid']), '*', 0, 10, 0, 'extid ASC');
				$r['modelid'] = explode(',',$r['modelid']);
				$result[] = $r;
			}
		}
		include $this->template('member_listing', M);
	}
	/**
	 * 添加用户
	 */
	public function add() {
		$models = get_cache('model_member','model');
		if(isset($GLOBALS['submit'])) {
			if(!isset($GLOBALS['info']['email'])) MSG('邮件不能为空');

			if(empty($GLOBALS['info']['groupid'])) {
				MSG('请选择会员组');
			}

			if(empty($GLOBALS['modelids'])) {
				MSG('请选择模型');
			}
			$GLOBALS['info']['modelid'] = implode(',',$GLOBALS['modelids']);

			if(!$uid = $this->member->add($GLOBALS['info'])) MSG(L('operation_failure'));
			$file = WWW_ROOT.'uploadfile/member/'.substr(md5($uid), 0, 2).'/'.$uid.'/';
			if(!is_dir($file)) mkdir($file,0777,true);

			$avatar_path = str_replace(ATTACHMENT_URL,ATTACHMENT_ROOT,$GLOBALS['avatar']);
			if($GLOBALS['avatar'] && file_exists($avatar_path)) {
				copy($avatar_path,$file.'180x180.jpg');
				$this->db->update('member', array('avatar'=>1), array('uid' => $uid));
			} else {
				$this->db->update('member', array('avatar'=>0), array('uid' => $uid));
			}

			if(!empty($GLOBALS['groups'])) {
				foreach($GLOBALS['groups'] as $groupid) {
					$formdata = array();
					$formdata['uid'] = $uid;
					$formdata['groupid'] = $groupid;
					$this->db->insert('member_group_extend', $formdata);
				}
			}

			if($GLOBALS['islock']==1) {//未激活
//发送激活邮件
				$sys_name = intval($GLOBALS['sys_name']);
				$this->db->update('member', array('islock'=>1,'sys_name'=>$sys_name), array('uid' => $uid));
				$config = get_cache('sendmail');
				$password = decode($config['password']);

				$username = $GLOBALS['info']['username'];
				$sendtime = date('F j, Y H:i',SYS_TIME);//January 20, 2016 17:14
				//Wed Jan 20 18:21:37 GMT-8 2016
				$subject = '激活您的帐号';
				$randtime = rand(10000,99999);
				$activecode = md5($uid.$randtime);
				$linkurl = WEBURL.'index.php?m=member&f=active_account&activecode='.$activecode.'&uid='.$uid.'&randtime='.$randtime;
				$weburl = WEBURL;
				ob_start();
				include T('member', 'mail_active');
				$message = ob_get_contents();
				ob_end_clean();
				load_function('sendmail');
				if(send_mail($GLOBALS['info']['email'],$subject,$message)===false) {
					MSG(L('邮件发送失败!'));
				}
			} else {
				$this->db->update('member', array('ischeck_email'=>1), array('uid' => $uid));
			}
			MSG(L('operation_success'),'?m=member&f=index&v=listing'.$this->su());
		} else {

			$group_extend_result = $group_extend = array();
			$group = $ext_group = array();
			foreach($this->group as $gr) {
				if($gr['issystem']==1) {
					$group[$gr['groupid']] = $gr;
				} else {
					//if(in_array($gr['groupid'],array(20,22,32,34))) $gr['pid'] = 0;

					$gr['selected'] = in_array($gr['groupid'],$group_extend) ? 'checked' : '';
					$gr['trbg'] = in_array($gr['groupid'],$group_extend) ? 'trbg' : '';
					$ext_group[$gr['groupid']] = $gr;
				}

			}
			$tree = load_class('tree','core',$ext_group);
			$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
			//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
			$tree_data = '';

			//格式字符串
			$str="<tr id='gid\$groupid' class='\$trbg'><td class='categorytd'><input  name='groups[]' type='checkbox' value='\$groupid' id='box\$groupid' \$selected onclick='set_gp(\$groupid,\$pid);'><input name='pids[]' type='hidden' value='\$pid' id='hgid\$groupid'></td><td>\$groupid</td><td>\$spacer\$name</td></tr>";

			//返回树
			$tree_data.=$tree->create(0,$str);
			$form = load_class('form');
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
		$models = get_cache('model_member','model');
		if(isset($GLOBALS['submit'])) {
			if(empty($GLOBALS['modelids'])) MSG('请选择模型');
			$GLOBALS['info']['factor'] = $member['factor'];
			$GLOBALS['info']['modelid'] = implode(',',$GLOBALS['modelids']);
			if(!$this->member->edit($GLOBALS['info'], $uid)) MSG(L('operation_failure'));

			$file = WWW_ROOT.'uploadfile/member/'.substr(md5($uid), 0, 2).'/'.$uid.'/';

			if(!is_dir($file)) mkdir($file,0777,true);
			$avatar_path = str_replace(ATTACHMENT_URL,ATTACHMENT_ROOT,$GLOBALS['avatar']);
			if($GLOBALS['avatar'] && file_exists($avatar_path)) {
				copy($avatar_path,$file.'180x180.jpg');
				$this->db->update('member', array('avatar'=>1), array('uid' => $uid));
			} else {
				$this->db->update('member', array('avatar'=>0), array('uid' => $uid));
			}

			$modelid = (int)$GLOBALS['info']['modelid'];
			$formdata = $GLOBALS['form'];

			$data = $data_en = array();
			foreach($formdata as $field=>$value) {
				$fields = explode('_',$field);
				$field = $fields[0];
				$modelid = $fields[1];
				if(is_array($value)) {
					$value = ','.implode(',',$value).',';
				}
				if($fields[2]) {
					$data_en[$modelid][$field] = $value;
				} else {

					$data[$modelid][$field] = $value;
				}
			}
			foreach($data as $modelid=>$rs) {

				$table = $models[$modelid]['attr_table'];

				$rd = $this->db->get_one($table, array('uid' => $uid));
				if($rd) {
					$this->db->update($table, $rs, array('uid' => $uid));
				} else {
					$rs['uid'] = $uid;
					$this->db->insert($table, $rs);
				}
			}

			//保存扩展会员组
			$this->db->delete('member_group_extend', array('uid' => $uid));
			if(!empty($GLOBALS['groups'])) {
				foreach($GLOBALS['groups'] as $groupid) {
					$formdata = array();
					$formdata['uid'] = $uid;
					$formdata['groupid'] = $groupid;
					$this->db->insert('member_group_extend', $formdata);
				}
			}

			MSG('信息修改成功!',HTTP_REFERER);
		} else {
			$modelid = $member['modelid'];
			//	判断是否有模型id参数

//print_r($models);
			if($modelid=='') $modelid = 10;
			$modelids = explode(',',$modelid);
			asort($modelids);
			$is_load = false;
			foreach($modelids as $modelid) {

				if($is_load==false) {
					require get_cache_path('member_form','model');
					$form_build = new form_build($modelid);
					$is_load = true;
				}

				$form_build->fields = get_cache('field_'.$modelid,'model');
				$tmp = $this->db->get_one($models[$modelid]['attr_table'], array('uid' => $uid));
				$formdata = 'formdata_'.$modelid;
				$formdata2 = 'formdata2_'.$modelid;
				$$formdata = $form_build->execute($tmp,$modelid);
			}
			$group_extend_result = $this->db->get_list('member_group_extend', array('uid'=>$uid), '*', 0, 50, 0, 'groupid ASC');
			$group_extend = array();
			foreach($group_extend_result as $er) {
				$group_extend[] = $er['groupid'];
			}
			$group = $ext_group = array();
			foreach($this->group as $gr) {
				if($gr['issystem']==1) {
					$group[$gr['groupid']] = $gr;
				} else {
					$gr['selected'] = in_array($gr['groupid'],$group_extend) ? 'checked' : '';
					$gr['trbg'] = in_array($gr['groupid'],$group_extend) ? 'trbg' : '';
					$ext_group[$gr['groupid']] = $gr;
				}

			}
			$tree = load_class('tree','core',$ext_group);
			$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
			//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
			$tree_data = '';

			//格式字符串
			$str="<tr id='gid\$groupid' class='\$trbg'><td class='categorytd'><input  name='groups[]' type='checkbox' value='\$groupid' id='box\$groupid' \$selected onclick='set_gp(\$groupid,\$pid);'><input name='pids[]' type='hidden' value='\$pid' id='hgid\$groupid'></td><td>\$groupid</td><td>\$spacer\$name</td></tr>";

			//返回树
			$tree_data.=$tree->create(0,$str);

			$form = load_class('form');
			$avatar = avatar($uid,180);
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
				foreach ($GLOBALS['uid'] as $uid) {
					$checkdata = $this->db->get_one('admin', array('uid' => $uid));
					if($checkdata) {
						$checkdata2 = $this->db->get_one('member', array('uid' => $uid));
						$username = $checkdata2['username'];
						MSG($username.'是后台管理员，如需删除，请先删除管理员');
					}
				}

				$where = ' IN ('.implode(',', $GLOBALS['uid']).')';
			}else{
				$uid = intval($GLOBALS['uid']);
				$checkdata = $this->db->get_one('admin', array('uid' => $uid));
				if($checkdata) {
					$checkdata2 = $this->db->get_one('member', array('uid' => $uid));
					$username = $checkdata2['username'];
					$data = array();
					$data['status'] = 2;
					$data['username'] = $username;
					$data = json_encode($data,true);
					echo $GLOBALS['callback'].'('.$data.')';
					exit;
				}
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
			$setting = get_cache('setting', M);
			$group = $this->group;
			include $this->template('setting',M);
		}
	}
	public function check_uc(){
		$uc_dbhost = isset($GLOBALS['uc_dbhost']) && trim($GLOBALS['uc_dbhost']) ? trim($GLOBALS['uc_dbhost']) : exit('0');
		$uc_dbuser = isset($GLOBALS['uc_dbuser']) && trim($GLOBALS['uc_dbuser']) ? trim($GLOBALS['uc_dbuser']) : exit('0');
		$uc_dbpw = isset($GLOBALS['uc_dbpw']) && trim($GLOBALS['uc_dbpw']) ? trim($GLOBALS['uc_dbpw']) : exit('0');
		if(function_exists('mysqli_connect')) {
			if (@mysqli_connect($uc_dbhost, $uc_dbuser, $uc_dbpw)) {
				exit('1');
			} else {
				exit('0');
			}
		} elseif (@mysql_connect($uc_dbhost, $uc_dbuser, $uc_dbpw)) {
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
	public function setcompany() {
		$uid = intval($GLOBALS['uid']);
		$check_company = intval($GLOBALS['check_company']);


		$this->db->update('member', array('checkmec'=>$check_company), array('uid' => $uid));
		MSG('<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>更新成功');
	}
	/**
	 * 审批用户列表
	 */
	public function check_list() {
		$group = $this->group;
		$page = max(1, (isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1));
		$sta_arr = array(-1=>'所有状态',1=>'审核通过',0=>'待审核',3=>'审核不通过');
		$keyArr = array('username'=>'登录名', 'uid'=>'UID', 'email'=>'Email', 'mobile'=>'手机');
		$keyType = isset($GLOBALS['keyType']) && isset($keyArr[$GLOBALS['keyType']]) ? $GLOBALS['keyType'] : 'username';
		$keyValue = isset($GLOBALS['keyType']) ? sql_replace($GLOBALS['keyValue']) : '';
		$regTimeStart = isset($GLOBALS['regTimeStart']) ? strtotime($GLOBALS['regTimeStart']) : '';
		$regTimeEnd = isset($GLOBALS['regTimeEnd']) ? strtotime($GLOBALS['regTimeEnd']) : '';
		$loginTimeStart = isset($GLOBALS['loginTimeStart']) ? strtotime($GLOBALS['loginTimeStart']) : '';
		$loginTimeEnd = isset($GLOBALS['loginTimeEnd']) ? strtotime($GLOBALS['loginTimeEnd']) : '';
		$groupid = 5;
		$checkmec = isset($GLOBALS['checkmec']) ? intval($GLOBALS['checkmec']) : -1;
		$extgid = intval($GLOBALS['extgid']);
		$modelid = intval($GLOBALS['modelid']);

			$where = $groupid ? ' groupid = '.$groupid : '1';
			if(isset($GLOBALS['search'])){

				if($keyType=='username' || $keyType=='fullname'|| $keyType=='fullname_en') {
					$where .= " AND `$keyType` LIKE '%$keyValue%'";
				}elseif($keyValue) {
					$where .= ' AND '.$keyType.'="'.$keyValue.'"';
				}

				$where .= $modelid ? " AND modelid LIKE '%".$modelid."%'" : '';
				if($regTimeStart) {
					$where .= ' AND regtime >= '.$regTimeStart;
				}
				if($regTimeEnd) {
					$regTimeEnd = $regTimeEnd+86400;
					$where .= ' AND regtime <= '.$regTimeEnd;
				}

				$where .= $loginTimeStart ? ' AND lasttime >= '.$loginTimeStart : '';
				$where .= $loginTimeEnd ? ' AND lasttime <= '.$loginTimeEnd+86400 : '';
				if($checkmec>-1) {
					$where .= ' AND checkmec = '.$checkmec;
				}
			}
			$models = get_cache('model_member','model');
			$result_arr = $this->db->get_list('member', $where, '*', 0, 10, $page,'uid DESC');
			$pages = $this->db->pages;
			$result = array();
			foreach($result_arr as $r) {
				$r['group_extend'] = $this->db->get_list('member_group_extend', array('uid'=>$r['uid']), '*', 0, 10, 0, 'extid ASC');
				$r['modelid'] = explode(',',$r['modelid']);
				$result[] = $r;
			}

		include $this->template('member_check', M);
	}
	public function check() {
		if(isset($GLOBALS['submit'])) {
			$uid = intval($GLOBALS['uid']);
			$this->db->update('member', array('groupid'=>3), array('uid' => $uid));
			MSG('审核通过',HTTP_REFERER);
		}
	}
}