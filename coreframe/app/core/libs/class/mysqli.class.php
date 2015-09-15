<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * mysqli操作类
 */
class WUZHI_mysqli {
	var $link;
	var $histories = '';
	var $tablepre = 'wz_';
	var $querynum = 0;
	function __construct($config) {
		$this->tablepre = $config['tablepre'];
		$this->connect($config['dbhost'], $config['username'], $config['password'], $config['dbname'], $config['dbcharset'], $config['pconnect'], $config['tablepre']);
	}



	public function connect($dbhost, $username, $password, $dbname = '', $dbcharset, $pconnect = 0, $tablepre = '') {
		$this->tablepre = $tablepre;
        if(!$this->link = @mysqli_connect($dbhost, $username, $password, $dbname)) {
            $this->halt('Can not connect to MySQL server');
        }

		if($dbcharset) {
			mysqli_query($this->link,"SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary");
		}

		if($this->version() > '5.0.1') {
			mysqli_query($this->link,"SET sql_mode=''");
		}

	}

	public function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysqli_fetch_array($query, $result_type);
	}

	public function get_one($table, $where, $field = '*', $limit = '', $order = '', $group = '', $condition = TRUE) {
		$where = $where ? ' WHERE '.$where: '';
		if($condition) {
			$field = $field == '*' ? '*' : self::safe_filed($field);
		} else {
			$field = $this->escape_string($field);
		}
		$order = $order ? ' ORDER BY '.$order : '';
		$group = $group ? ' GROUP BY '.$group : '';
		$limit = $limit ? ' LIMIT '.$limit : '';

		$sql = 'SELECT '.$field.' FROM `'.$this->tablepre.$table.'`'.$where.$group.$order.$limit;
		$query = $this->query($sql);
		return $this->fetch_array($query);
	}


	// get parameterized sql string
	private function get_param_sql($sql,$param = array()) {
		foreach ($param as $key => $value) {
			$val = "'". $this->escape_string($value). "'";
			//echo 'k=> ' . $key .' v=> ' .$val. '<br/>';
			$sql = str_replace($key, $val, $sql);
		}
		return $sql;
	}

	//get sql resultset count
	public function get_page_list_count($sql,$param = array()) {
		$arr = array();
		$sql = ' select count(1) as num from (' . $this->get_param_sql($sql,$param). ' ) tb_wuzhi_cms';

		//echo 'count SQL:' . $sql . '<br/>';

		$query = $this->query($sql);
		$r = $this->fetch_array($query);

		return $r['num'];
	}

	//get sql resultset detail list
	public function get_page_list($sql,$param = array(), $page = 0, $pagesize = 0 ) {
		$arr = array();
		$sql = $this->get_param_sql($sql,$param);

		if($page > 0 && $pagesize > 0){
			$page = max(intval($page), 1);
			$offset = $pagesize*($page-1);
			$sql = $sql. " limit $pagesize offset $offset ";
		}

		//echo 'SQL:' . $sql . '<br/>';

		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
		return $arr;
	}

	public function get_list($table, $where = '', $field = '*', $limit = '', $order = '', $group = '', $keyfield = '') {
		$arr = array();
		$where = $where ? ' WHERE '.$where: '';
		$field = $field == '*' ? '*' : self::safe_filed($field);
		$order = $order ? ' ORDER BY '.$order : '';
		$group = $group ? ' GROUP BY '.$group : '';
		$limit = $limit ? ' LIMIT '.$limit : '';

		$sql = 'SELECT '.$field.' FROM `'.$this->tablepre.$table.'`'.$where.$group.$order.$limit;
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			if($keyfield) {
				$arr[$data[$keyfield]] = $data;
			} else {
				$arr[] = $data;
			}
		}
		return $arr;
	}

	public function insert($table, $data, $returnid = TRUE, $replace_into = FALSE) {
		$field = array_keys($data);
        $fieldnum = count($field);
		$values = array_values($data);
		array_walk($field, array($this, 'safe_filed'));
		$field = '`'.implode ('`,`', $field).'`';
        $value = '';
        $n = 1;
        foreach($values as $_v) {
            if($fieldnum!=$n) {
                $value .= "'".$this->escape_string($_v)."',";
            } else {
                $value .= "'".$this->escape_string($_v)."'";
            }
            $n++;
        }
		$sql = $replace_into ? 'REPLACE INTO ' : 'INSERT INTO ';
		$sql .= '`'.$this->tablepre.$table.'`('.$field.') VALUES ('.$value.')';
		$query = $this->query($sql);
		return $returnid ? $this->insert_id() : $query;
	}

	public function update($table, $data, $where = '') {
		//UPDATE `wz_admin` SET `roleid`=1,`lastlogintime`=1 WHERE `uid`=1
		$where = $where ? ' WHERE '.$where: '';

		if(is_array($data)) {
			$datas = array();
			foreach ($data AS $key => $value) {
				$datas[] = "`".$key."`='".$this->escape_string($value)."'";
			}

			$setdata = implode(',', array_values($datas));
			//print_r($setdata);exit;
		} else {
			$setdata = $this->escape_string($data);
		}
		$sql = 'UPDATE `'.$this->tablepre.$table.'` SET '.$setdata.' '.$where;

        //echo $sql;

		return $this->query($sql);
	}

	public function delete($table, $where = '') {
		$where = $where ? ' WHERE '.$where: '';
		$sql = 'DELETE FROM `'.$this->tablepre.$table.'`'.$where;
		return $this->query($sql);
	}

	public function escape_string($string) {
        return mysqli_real_escape_string($this->link,$string);
	}

	private static function safe_filed($field, $is_array = TRUE) {
		//filed1,filed2
		if(empty($field)) {
			return '*';
		}
		$d_word = array('select','insert','update','delete');
		$str = '';
		$fields = explode(',', $field);
		foreach ($fields as $key => $value) {
			if(in_array($value, $d_word)) continue;
			$str .= '`'.$value.'`,';
		}
		$str = rtrim($str,',');
		return $str;
	}
	public function query($sql, $type = '', $cachetime = FALSE) {
        //if($_SERVER['REMOTE_ADDR']=='127.0.0.1') echo $sql."<br>";
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysqli_unbuffered_query' : 'mysqli_query';
		if(!($query = $func($this->link,$sql)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		if(defined('SQL_LOG')) {
			if(substr($sql,0,21)!='INSERT INTO `wz_logs`' && substr($sql,0,6)!='SELECT' && substr($sql,0,24)!='DELETE FROM `wz_session`' && substr($sql,0,25)!='REPLACE INTO `wz_session`') {
				error_log(date('Y-m-d H:i:s',SYS_TIME).' '.$sql."\r\n", 3, CACHE_ROOT."sql_log.".CACHE_EXT.'.sql');
			}
		}
		return $query;
	}

	public function affected_rows() {
		return mysqli_affected_rows($this->link);
	}

	public function error() {
		return (($this->link) ? mysqli_error($this->link) : mysql_error());
	}

	public function errno() {
		return intval(($this->link) ? mysqli_errno($this->link) : mysqli_errno());
	}

	public function result($query, $row) {
		$query = @mysqli_result($query, $row);
		return $query;
	}

	public function num_rows($query) {
		$query = mysqli_num_rows($query);
		return $query;
	}

	public function num_fields($query) {
		return mysqli_num_fields($query);
	}

	public function free_result($query) {
		return mysqli_free_result($query);
	}

	public function insert_id() {
		return ($id = mysqli_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	public function fetch_row($query) {
		$query = mysqli_fetch_row($query);
		return $query;
	}

	public function fetch_fields($query) {
		return mysqli_fetch_field($query);
	}

	public function version() {
		return mysqli_get_server_info($this->link);
	}

	public function close() {
		return mysqli_close($this->link);
	}

	public function halt($message = '', $sql = '') {
		MSG('<div style="font-size: 9px;word-break: break-all;height: 150px;overflow: overlay;">[sql_error]'.$message.'<br /><br />'.$sql.'<br />[msg]'.mysqli_error($this->link).'</div>');
	}
}