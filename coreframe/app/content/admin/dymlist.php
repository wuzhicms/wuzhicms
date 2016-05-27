<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 相关内容显示
 */
load_class('admin');
class dymlist extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
		$this->group = get_cache('group', 'member');
		$this->model = $this->db->get_list('model', '`m`="member"', 'modelid,name,attr_table', 0, 200, 0, '', '', 'modelid');
	}
    public function manage() {
		$id = $GLOBALS['id'];
		if(!$id) MSG('参数错误');

		if(isset($GLOBALS['groups'])) {
			//print_r($GLOBALS['groups']);
			//$result = $this->db->get_list('admin', '', '*', 0, 20, 0, 'uid DESC');
			$groupid = implode(',',$GLOBALS['groups']);
			if(!$groupid) MSG('请选择会员组');
			$tpl = 1;
			$modelids = $GLOBALS['modelids'];
			if(!$modelids) MSG('请选择模型');
			$data_r = $this->db->get_one('dymlist', array('id' => $id));
			load_class('py');

			$models = get_cache('model_member','model');
			$field_result = $diy = array();
			$fields = $showname = $diy = $ban_show = array();
			$fields = explode(',',$data_r['field']);
			$tmpmodelids = '';
			if(in_array(10,$modelids)) {
				$tmpmodelids[] = 10;
				foreach($modelids as $_modelid) {
					if($_modelid==10) continue;
					$tmpmodelids[] = $_modelid;
				}
			} else {
				$tmpmodelids = $modelids;
			}
			$modelids = $tmpmodelids;
			if(!$data_r) {
				foreach($modelids as $modelid) {
					$field_result[$modelid] = $field_arr = get_cache('field_'.$modelid,'model');
					foreach($field_result[$modelid] as $rs) {
						$fields[] = $rs['field'];
					}
					$showname = $field_br = $fields;
				}
			} else {
				$colors = array('#797979','#A95555','#3B99FC','#3F7707');
				$field_result = $fields_data = array();
				$j = 0;
				foreach($modelids as $modelid) {
					$field_result[$modelid] = get_cache('field_'.$modelid,'model');
					foreach($field_result[$modelid] as $rs) {
						$rs['field_color'] = $colors[$j];
						$fields_data[$rs['field']] = $rs;
					}
					$j++;
				}



				$field_result2 = array();
				foreach($fields as $_fields) {
					$field_result2[$_fields] = $fields_data[$_fields];
				}

				$diff_keys = array_diff(array_keys($fields_data), $fields);
				if (!empty($diff_keys)) {
					foreach ($diff_keys as $fed) {
						$field_result2[$fed] = $fields_data[$fed];
					}
				}
				//print_r($field_result2);exit;
			}

			$tpl = 1;
			if($data_r) {
				$showname = explode(',', $data_r['showname']);
				$field_br = explode(',', $data_r['field_br']);
				$diy = string2array($data_r['diy']);
				$tpl = $data_r['tpl'];
				$uids = explode(',', $data_r['uids']);
				$ban_show = explode(',', $data_r['ban_show']);
			}
			if($GLOBALS['sorttype']==1) {//按照字母排序
				$member_result = array();
				$result_query = $this->db->query("SELECT * FROM wz_member_group_extend e,wz_member m WHERE e.uid=m.uid AND e.groupid IN($groupid)");
				while($data = $this->db->fetch_array($result_query)) {
					$mr = $this->db->get_one('m_detail_data', array('uid' => $data['uid']),'LastName,FirstName');
					$mr_en = $this->db->get_one('m_detail_data_en', array('uid' => $data['uid']),'LastName,FirstName');
					$data['LastName'] = $mr['LastName'];
					$data['LastName_en'] = $mr_en['LastName'];
					$data['FirstName'] = $mr['FirstName'];
					$data['FirstName_en'] = $mr_en['FirstName'];
					$pre = WUZHI_py::encode($data['LastName']); //编码为拼音首字母
					$pre = strtolower($pre);
					$member_result[$pre.$data['uid']] = $data;
				}

				ksort($member_result);
				//print_r($member_result);
			} elseif($data_r && $groupid==$data_r['groupids']) {
				$member_result = $tmp = $keys = array();
				$result_query = $this->db->query("SELECT * FROM wz_member_group_extend e,wz_member m WHERE e.uid=m.uid AND e.groupid IN($groupid)");
				while ($data = $this->db->fetch_array($result_query)) {
					$mr = $this->db->get_one('m_detail_data', array('uid' => $data['uid']),'LastName,FirstName');
					$mr_en = $this->db->get_one('m_detail_data_en', array('uid' => $data['uid']),'LastName,FirstName');
					$data['LastName'] = $mr['LastName'];
					$data['LastName_en'] = $mr_en['LastName'];
					$data['FirstName'] = $mr['FirstName'];
					$data['FirstName_en'] = $mr_en['FirstName'];
					$tmp[$data['uid']] = $data;
					$keys[] = $data['uid'];
				}
				foreach ($uids as $uid) {
					$member_result[] = $tmp[$uid];
				}
				$diff_keys = '';
				$diff_keys = array_diff($keys, $uids);
				if (!empty($diff_keys)) {
					foreach ($diff_keys as $uid) {
						$member_result[] = $tmp[$uid];
					}
				}
			} else {

				$member_result = array();
				$result_query = $this->db->query("SELECT * FROM wz_member_group_extend e,wz_member m WHERE e.uid=m.uid AND e.groupid IN($groupid)");
				while($data = $this->db->fetch_array($result_query)) {
					$mr = $this->db->get_one('m_detail_data', array('uid' => $data['uid']),'LastName,FirstName');
					$mr_en = $this->db->get_one('m_detail_data_en', array('uid' => $data['uid']),'LastName,FirstName');
					$data['LastName'] = $mr['LastName'];
					$data['LastName_en'] = $mr_en['LastName'];
					$data['FirstName'] = $mr['FirstName'];
					$data['FirstName_en'] = $mr_en['FirstName'];
					$pre = WUZHI_py::encode($data['LastName']); //编码为拼音首字母
					$pre = strtolower($pre);
					$member_result[$pre.$data['uid']] = $data;
				}
				ksort($member_result);
			}

			include $this->template('dymlist_manage2');
			exit;
		} else {
			$data = $this->db->get_one('dymlist', array('id' => $id));
			$group_extend = $modelids = array();
			if(!$data) {
				$data = array();
				$data['groups'] = array();
				$data['modelids'] = array();
				$sorttype = 0;
			} else {
				$group_extend = explode(',',$data['groupids']);
				$modelids = explode(',',$data['modelids']);
				$sorttype = $data['sorttype'];
			}
			$group = $ext_group = array();
			foreach($this->group as $gr) {
				if($gr['pid']==0) {
					$group[$gr['groupid']] = $gr;
				} else {
					if(in_array($gr['groupid'],array(20,22,32,34))) $gr['pid'] = 0;

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
			$str="<tr id='gid\$groupid' class='\$trbg'><td class='categorytd'><input  name='groups[]' type='checkbox' value='\$groupid' id='box\$groupid' \$selected ><input name='pids[]' type='hidden' value='\$pid' id='hgid\$groupid'></td><td>\$groupid</td><td>\$spacer\$name</td></tr>";

			//返回树
			$tree_data.=$tree->create(0,$str);
			include $this->template('dymlist_manage');
		}

    }

	public function save() {
		$id = $GLOBALS['id'];
		if(!$id) MSG('参数错误');
		//print_r($GLOBALS);
		if(isset($GLOBALS['submit'])) {
			$groupids = $GLOBALS['groupids'];
			if(!$groupids) MSG('请选择会员组');
			$tpl = 1;
			$modelids = $GLOBALS['modelids'];
			if(!$modelids) MSG('请选择模型');
			$r = $this->db->get_one('dymlist', array('id' => $id));
			$formdata = array();
			$formdata['id'] = $id;
			$formdata['groupids'] = $groupids;
			$formdata['modelids'] = $modelids;
			$field = $GLOBALS['field'];
			if(empty($field)) MSG('请选择要显示的字段');
			$field = array_keys($field);
			$formdata['field'] = implode(',',$field);
			$showname = $GLOBALS['showname'];
			if(!empty($showname)) {
				$showname = array_keys($showname);
				$formdata['showname'] = implode(',',$showname);
			} else {
				$formdata['showname'] = '';
			}
			$ban_show = $GLOBALS['ban_show'];
			if(!empty($ban_show)) {
				$ban_show = array_keys($ban_show);
				$formdata['ban_show'] = implode(',',$ban_show);
			} else {
				$formdata['ban_show'] = '';
			}

			$diy = $GLOBALS['diy'];

			$formdata['diy'] = array2string($diy);
			$field_br = $GLOBALS['field_br'];
			if(!empty($field_br)) {
				$field_br = array_keys($field_br);
				$formdata['field_br'] = implode(',',$field_br);
			} else {
				$formdata['field_br'] = '';
			}


			$formdata['tpl'] = intval($GLOBALS['tpl']);
			$uids = '';
			foreach($GLOBALS['uids'] as $uid) {
				if($uid) $uids[] = $uid;
			}
			$formdata['uids'] = implode(',',$uids);
			$formdata['sorttype'] = intval($GLOBALS['sorttype']);

			if($r) {
				$this->db->update('dymlist', $formdata, array('id' => $id));
			} else {
				$this->db->insert('dymlist', $formdata);
			}
			MSG('<script>setTimeout("top.dialog.get(window).close().remove();",2000)</script>配置保存成功');

		}
	}

}