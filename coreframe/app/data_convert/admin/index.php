<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: haochuan <haochuan6868@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 数据转化
 */
load_class('admin');
load_function('common',M);

class index extends WUZHI_admin{
	private $db;
	private $mysql;
	function __construct() {
		$this->db = load_class('db');
	}

	/**
	 *
	 */
	public function listing() {
		$result = $this->db->get_list('data_convert', '', '*', 0, 20, 0, 'dcid DESC');
		include $this->template('listing');
	}
	/**
	 * 新增转化配置
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$formdata = array();
			$formdata['title'] = $GLOBALS['form']['title'];
			$dcid = $this->db->insert('data_convert', $formdata);

			//TODO 保存
			MSG('添加成功，继续添加字段配置');
		} else {
			$dbconfig = get_config('mysql_config');
			$dbconfig = $dbconfig['default'];

			include $this->template('add');
		}

	}

	/**
	 * 转化
	 */
	public function convert() {
		$dcid = intval($GLOBALS['dcid']);
		$data_convert = $this->db->get_one('data_convert', array('dcid' => $dcid));
		$to_table = $data_convert['to_table'];
		$to_table2 = $data_convert['to_table2'];
		$extension_sql = $data_convert['extension_sql'];
		$old_table_sql = $data_convert['old_table_sql'];
		$where = "`dcid`=$dcid";
		$data_convert_fields = $this->db->get_list('data_convert_fields', $where, '*', 0, 100, 0, 'id DESC');
		$filed_config = array();
		foreach($data_convert_fields as $rs) {
			$filed_config[$rs['to_table']][] = $rs;
		}

		$this->fdb = new WUZHI_db('mysql_convert_1_from');
		$this->tdb = new WUZHI_db('mysql_convert_1_to');

		$start = isset($GLOBALS['start']) ? intval($GLOBALS['start']) : 0;
		$pagesize = 50;
		$from_sql = $data_convert['from_sql']." LIMIT $start,$pagesize";
		$start+=$pagesize;
		$query = $this->fdb->query($from_sql);
		if($query->num_rows==0) {
			MSG('转化完成','?m=data_convert&f=index&v=listing'.$this->su());
		}

		while ($r = $this->fdb->fetch_array($query)) {
			
			$result[] =  $r;
			$formdata = array();
			foreach($filed_config[$to_table] as $fr) {
				$to_field = $fr['to_field'];
				$from_field = $fr['from_field'];
				if($from_field=='') {
					$formdata[$to_field] = $fr['default_value'];
				} elseif($fr['fun']) {
					$data = $r[$from_field];

					$efx = explode('~',$fr['fun']);
					if(isset($efx[1])) {
						$fun = $efx[0];
						$formdata[$to_field] = $fun($data,$efx[1]);
					} else {
						$fun = $fr['fun'];
						$formdata[$to_field] = $fun($data);
					}

				} else {
					$formdata[$to_field] = $r[$from_field];
				}
			}
			$newid = $this->tdb->insert($to_table, $formdata);
			if($to_table2) {
				$formdata = array();
				foreach($filed_config[$to_table2] as $fr) {
					$to_field = $fr['to_field'];
					$from_field = $fr['from_field'];
					if($from_field=='') {
						if($fr['fun']=='get_index') {
							$formdata[$to_field] = $newid;
						} else {
							$formdata[$to_field] = $fr['default_value'];
						}
					} elseif($fr['fun']) {
						$fun = $fr['fun'];
						$data = $r[$from_field];
						$formdata[$to_field] = $fun($data);
					} else {
						$formdata[$to_field] = $r[$from_field];
					}
				}
				$this->tdb->insert($to_table2, $formdata);
			}
			//扩展：执行自定义SQL，并替换SQL中的变量
			if($extension_sql) {
				$querystring = $extension_sql;
				$querystring = str_replace('{{newid}}',$newid,$querystring);
				foreach($r as $_key=>$_v) {
					$querystring = str_replace('{{'.$_key.'}}',$_v,$querystring);
				}
				$this->sql_execute($this->tdb,$querystring);
			}
			//扩展：更新新的newid 到 老数据库，由于原数据存在于多个数据表，需要都写到新的同一张表，而原来的多张表主键会有重复。也可以用作其他用途。
			if($old_table_sql) {
				$querystring = $old_table_sql;
				$querystring = str_replace('{{newid}}',$newid,$querystring);
				foreach($r as $_key=>$_v) {
					$querystring = str_replace('{{'.$_key.'}}',$_v,$querystring);
				}
				$this->sql_execute($this->fdb,$querystring);
			}
		}

		MSG($start.'条:转化完成','?m=data_convert&f=index&v=convert&start='.$start.'&dcid='.$dcid.$this->su());
	}

	/**
	 * 配置字段
	 */
	public function config_field() {
		$dcid = intval($GLOBALS['dcid']);
		$data_convert = $this->db->get_one('data_convert', array('dcid' => $dcid));
		if(isset($GLOBALS['submit'])) {
			echo '<pre>';
		//print_r($GLOBALS);exit;
			$this->db->delete('data_convert_fields', array('dcid' => $dcid));

			foreach($GLOBALS['fields'] as $field_str) {
				$field_arr = explode('.',$field_str);
				$field = $field_arr[1];
				$tablename = $field_arr[0];

				$tmp = $GLOBALS['from_arr_'.$tablename][$field];
				$dbtables = explode('.',$tmp);
				$formdata = array();
				$formdata['dcid'] = $dcid;
				$formdata['from_table'] = $dbtables[0];
				$formdata['from_field'] = $dbtables[1];
				$formdata['to_table'] = $tablename;
				$formdata['to_field'] = $field;
				$formdata['fun'] = $GLOBALS['fun_'.$tablename][$field];
				$formdata['default_value'] = $GLOBALS['default_value_'.$tablename][$field];

				$this->db->insert('data_convert_fields', $formdata);
			}
			MSG('配置成功',HTTP_REFERER);
		} else {
			$this->fdb = new WUZHI_db('mysql_convert_1_from');
			$this->tdb = new WUZHI_db('mysql_convert_1_to');

			$fields = $this->get_fields($this->fdb,$data_convert['from_table']);
			$fields_keys = array_keys($fields);
			$from_arr = array();
			foreach($fields_keys as $field) {
				$from_arr[] = array(
					'field'=>$field,
					'field_type'=>$fields[$field],
					'tablename'=>$data_convert['from_table']
				);
			}


			$fields_to = $this->get_fields($this->tdb,$data_convert['to_table']);
			$fields_to_type = $fields_to;

			$fields_to_keys = array_keys($fields_to);
			$to_arr = array();
			foreach($fields_to_keys as $field) {
				$to_arr[] = array(
					'field'=>$field,
					'field_type'=>$fields_to[$field],
					'tablename'=>$data_convert['to_table']
				);
			}
			if($data_convert['to_table2']) {
				$fields_to_data = $this->get_fields($this->tdb,$data_convert['to_table2']);
				foreach($fields_to_data as $field=>$arr) {
					$fields_to_type[$field] = $arr;
				}
				$fields_to_data_keys = array_keys($fields_to_data);

				foreach($fields_to_data_keys as $field) {
					//if(isset($to_arr[$field])) continue;
					$to_arr[] = array(
						'field'=>$field,
						'field_type'=>$fields_to_data[$field],
						'tablename'=>$data_convert['to_table2']
					);
				}
			}

//print_r($to_arr);
			include $this->template('config_field');
		}

	}
	public function get_fields($mdb,$table) {

		$fields = array();
		$columns = $mdb->query("SHOW COLUMNS FROM $table");
		while ($r = $mdb->fetch_array($columns)){
			$fields[$r['Field']] = $r['Type'];
		}
		return $fields;
	}
	/**
	 * 执行SQL
	 */
	private function sql_execute($db,$sql) {
		$sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					//echo $sql."\r\n";
					$sql = str_replace ( "\n", "", $sql );
					$db->query($sql);
				}
			}
		} else {
			$db->query($sqls);
		}
		return true;
	}

	private function sql_split($sql) {
		$sql=str_replace("\r","\n",$sql);
		$ret=array();
		$num=0;
		foreach(explode(";\n",trim($sql)) as $query)
		{
			$queries=explode("\n",trim($query));
			foreach($queries as $query)
			{
				$ret[$num].=$query[0]=='#'||$query[0].$query[1]=='--'?'':$query;
			}
			$num++;
		}
		return $ret;
	}
}