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
class group extends WUZHI_admin {
	private $db, $group;
	function __construct() {
		$this->group = load_class('group', M);
		$this->db = load_class('db');
	}
	/**
	 * 后台用户组列表
	 */
	public function listing() {
		$page = max(1, (isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1));
		$result = $this->db->get_list('member_group', '', '*', 0, 1000, 0, 'sort ASC, groupid ASC');

		$group = $ext_group = array();
		foreach($result as $gr) {
			$gr['str_manage'] = '<a href="javascript:void(0)" onclick="edit('.$gr['groupid'].')" class="btn btn-primary btn-xs">修改</a> <a href="index.php?m=member&f=group&v=private_set&groupid='.$gr['groupid'].$this->su().'" class="btn btn-info btn-xs">访问权限设置</a> <a href="javascript:void(0)" onclick="del('.$gr['groupid'].')" class="btn btn-danger btn-xs">删除</a>';
			$gr['issystem'] = $gr['issystem'] ? '<font color="red">是</font>' : '<font color="green">否</font>';
			$gr['upgrade'] = $gr['upgrade'] ? '<font color="green">是</font>' : '<font color="red">否</font>';
			$ext_group[$gr['groupid']] = $gr;
		}

		$tree = load_class('tree','core',$ext_group);
		$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
		//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
		$tree_data = '';
		//格式字符串
		$str="<tr><td class='categorytd'><div><input type='checkbox' name='groupid[]' value='\$groupid'></div></td><td class='categorytd'><div><input class='center'style='padding:3px' name='sorts[\$groupid]' type='text' size='3' value='\$sort'></div></td><td>\$groupid</td><td id='\$cid' \$selected>\$spacer\$name</td><td>\$issystem</td><td>\$upgrade</td><td>\$str_manage</td></tr>";

		//返回树
		$tree_data.=$tree->create(0,$str);

		$tree_data.="";
		$show_dialog = 1;
		include $this->template('group_listing', M);
	}
	/**
	 * 添加
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {

			$groupid = $this->group->add($GLOBALS['info']);
			if(!$groupid) MSG(L('operation_failure'));
			$this->group->set_cache();
			//如果存在上级,则将上级权限赋值给当前组
			if($GLOBALS['info']['pid']) {
				$pid = $GLOBALS['info']['pid'];
				$priv_data = $this->db->get_list('member_group_priv', array('groupid' => $pid), '*', 0, 2000, 0);
				if($priv_data) {
					$formdata = array();
					foreach($priv_data as $rs) {
						$formdata = $rs;
						$formdata['groupid'] = $groupid;
						$this->db->insert('member_group_priv', $formdata);
					}
				}
			}
			MSG(L('operation_success'),'');
		} else {
			$groups = get_cache('group', M);
			$group = $ext_group = array();
			foreach($groups as $gr) {
				$ext_group[$gr['groupid']] = $gr;
			}

			$tree = load_class('tree','core',$ext_group);
			$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
			//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
			$tree_data = '';

			//格式字符串
			$str = "<option value=\$id \$selected \$disable>\$spacer\$name</option>";
			//返回树
			$tree_data.=$tree->create(0,$str);
			$string = '<select name="info[pid]" class="form-control">';
			$string .= "<option>≡ 选择上级分类 ≡</option>";
			$string .= $tree_data;
			$string .= '</select>';

			include $this->template('group_add', M);
		}
	}
	/**
	 * 编辑
	 */
	public function edit() {
		$groupid = (int)$GLOBALS['groupid'];
		if(isset($GLOBALS['submit'])) {
			if(!$this->group->edit($GLOBALS['info'], $groupid))MSG(L('operation_failure'));
			$this->group->set_cache();
			MSG(L('operation_success').'<script>$("#g_'.$groupid.' td", top.window.frames["iframeid"].document).css("background-color", "#EFD04C");top.dialog.get(window).close().remove();</script>');
		} else {
			if($groupid)$group = $this->db->get_one('member_group', '`groupid`='.$groupid, '*');
			if(empty($group))MSG(L('not_exists'));
			$groups = get_cache('group', M);
			$ext_group = array();
			foreach($groups as $gr) {
				$gr['selected'] = $gr['groupid']== $group['pid'] ? 'selected' : '';
				$ext_group[$gr['groupid']] = $gr;
			}

			$tree = load_class('tree','core',$ext_group);
			$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
			//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
			$tree_data = '';

			//格式字符串
			$str = "<option value=\$id \$selected \$disable>\$spacer\$name</option>";
			//返回树
			$tree_data.=$tree->create(0,$str);
			$string = '<select name="info[pid]" class="form-control">';
			$string .= "<option>≡ 选择上级分类 ≡</option>";
			$string .= $tree_data;
			$string .= '</select>';
			$set_iframe_url = 0;
			include $this->template('group_edit', M);
		}
	}
	/**
	 * 删除
	 */
	public function del() {
		if(isset($GLOBALS['groupid']) && $GLOBALS['groupid']) {
			if(is_array($GLOBALS['groupid'])) {
				$where = ' IN ('.implode(',', $GLOBALS['groupid']).')';
				foreach($GLOBALS['groupid'] as $gid) {
					$this->db->delete('member_group_priv', array('groupid' => $gid));
				}
			} else {
				$where = ' = '.$GLOBALS['groupid'];
				$this->db->delete('member_group_priv', array('groupid' => $GLOBALS['groupid']));
			}

			$this->db->delete('member_group', 'issystem != 1 AND groupid'.$where);
			$this->group->set_cache();


			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":1})';
			}else{
				MSG(L('operation_success'));
			}
		}else{
			if(isset($GLOBALS['callback'])){
				echo $GLOBALS['callback'].'({"status":0})';
			}else{
				MSG(L('operation_failure'));
			}
		}
	}
	/**
	 * 排序
	 */
	public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('member_group',array('sort'=>$n),array('groupid'=>$cid));
            }
            $this->group->set_cache();
            MSG(L('operation_success'), HTTP_REFERER);
        } else {
            MSG(L('operation_failure'));
        }
	}
	/**
	 * 验证用户组名
	 */
	public function check_name() {
		$name = isset($GLOBALS['param']) && $GLOBALS['param'] ? $GLOBALS['param'] : (isset($GLOBALS['name']) && $GLOBALS['name'] ? $GLOBALS['name'] : false);
		if(strtolower(CHARSET) != 'utf-8')$name = iconv('UTF-8', 'gb2312//IGNORE', $name);
		$groupid = isset($GLOBALS['groupid']) ? (int)$GLOBALS['groupid'] : 0;
		echo $this->group->check_name($name, $groupid, 1);
	}

	/**
	 * 权限设置
	 */
	public function private_set() {
		$groupid = intval($GLOBALS['groupid']);
		if(isset($GLOBALS['cid'])) {
			$cid = intval($GLOBALS['cid']);
			$chk = intval($GLOBALS['chk']);
			$formdata = array();
			$formdata['groupid'] = $groupid;
			$formdata['value'] = $cid;
			$formdata['priv'] = strip_tags($GLOBALS['actype']);
			if($chk) {
				$this->db->insert('member_group_priv', $formdata);
			} else {
				$this->db->delete('member_group_priv', $formdata);
			}
			exit('1');
		} else {
			$r_member_group = $this->db->get_one('member_group',array('groupid'=>$groupid));
			$group_priv_result = $this->db->get_list('member_group_priv', array('groupid'=>$groupid), '*', 0, 1000, 0);
			$group_priv = array();
			foreach($group_priv_result as $rs) {
				$group_priv[$rs['priv']][] = $rs['value'];
			}

			$types = array('列表','单网页','<font color="#8b0000">外链</font>','隐藏');
			$siteid = get_cookie('siteid');
			$model_cache = get_cache('model_content','model');
			$where = "`keyid`='content' AND `siteid`='$siteid'";
			$sitelist = get_cache('sitelist');
			$result = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
			foreach($result as $cid=>$r) {
				if($r['type']!=2) {
					$listview = $group_priv['listview'] && in_array($cid,$group_priv['listview']) ? 'checked' : '';
					$view = $group_priv['view'] && in_array($cid,$group_priv['view']) ? 'checked' : '';
					$add = $group_priv['add'] && in_array($cid,$group_priv['add']) ? 'checked' : '';
					$result[$cid]['private'] = '<label><input type="checkbox" onclick="st(\'listview\',this);" name="listview" '.$listview.' value="'.$cid.'"> 浏览列表</label>
<label><input type="checkbox" onclick="st(\'view\',this);" name="view" '.$view.' value="'.$cid.'"> 内容访问</label>
<label><input type="checkbox" onclick="st(\'add\',this);" name="add" '.$add.' value="'.$cid.'"> 投稿</label>
';
				} else {
					$result[$cid]['private'] = '';
				}

				$result[$cid]['ctype'] = $types[$r['type']];
				$result[$cid]['siteid'] = isset($sitelist[$r['siteid']]['name']) ? $sitelist[$r['siteid']]['name'] : '';
				$result[$cid]['modelname'] = $model_cache[$r['modelid']]['name'];
				$result[$cid]['url'] = '<a href="'.$r['url'].'" target="_blank">访问</a>';
			}
			$tree = load_class('tree','core',$result);
			$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
			//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
			$tree_data = '';

			//格式字符串
			$str="<tr><td>\$cid</td><td>\$siteid</td><td id='\$cid' \$selected>\$spacer\$name</td><td>\$ctype</td><td>\$modelname</td><td>\$url</td><td></td><td>\$private</td></tr>";

			//返回树
			$tree_data.=$tree->create(0,$str);

			$tree_data.="";
			$show_dialog = 1;


			$result = $this->db->get_list('menu', '', '*', 0, 2000, 0, 'sort ASC');
			$privates_rs = $this->db->get_list('admin_private', array('role'=>$role), '*', 0, 2000);
			$privates = array();
			foreach($privates_rs as $rs) {
				if($rs['chk']) $privates[] = $rs['id'];
			}
			include $this->template('private_set');
		}
	}
}