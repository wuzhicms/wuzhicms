<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 数据操作类，支持读写分离
 *
 * 使用方法：$db = load_class('db');
 */
class WUZHI_db {
    /**
     * @var array 数据库配置
     */
	protected $mysql_config = '';
    /**
     * @var string 当前的数据库配置
     */
	public $db_key = 'default';
    /**
     * @var string 数据表前缀
     */
	public $tablepre = 'wz_';
    /**
     * @var string 数据库名
     */
	public $dbname = '';
    /**
     * @var string 数据库编码，一般为：utf8 、gbk
     */
	public $dbcharset = '';
    /**
     * @var string 分页结果集
     */
	public $pages = '';
    /**
     * @var int 查询结果总数
     */
	public $number = 0;

    /**
     * Class constructor
     *
     * @param string $config_file 配置文件
     */
	public function __construct($config_file = 'mysql_config') {
		$this->mysql_config = get_config($config_file);
		$this->dbname = $this->mysql_config[$this->db_key]['dbname'];
		$this->tablepre = $this->mysql_config[$this->db_key]['tablepre'];
		$this->dbcharset = $this->mysql_config[$this->db_key]['dbcharset'];

		$this->slave_server = isset($this->mysql_config[$this->db_key]['slave_server']) ? $this->mysql_config[$this->db_key]['slave_server'] : '';

		$this->master_db = load_class($this->mysql_config[$this->db_key]['type'],'core',$this->mysql_config[$this->db_key]);
		if($this->slave_server) {
			$slave_server = weight_rand($this->slave_server);
			if($slave_server=='default') {
				$this->read_db = $this->master_db;
			} else {
				$this->read_db = load_class($this->mysql_config[$this->slave_server]['type'],'core',$this->mysql_config[$this->slave_server]);
			}
		} else {
			$this->read_db = $this->master_db;
		}
	}

    /**
     * 数组转化为sql格式
     * @param $data array
     * @return string
     */
	private function array2sql($data) {
		if(empty($data)) return '';
		if(is_array($data)) {
			$sql = '';
			foreach ($data as $key => $val) {
				$val = str_replace("%20", '', $val);
				$val = str_replace("%27", '', $val);
				$val = str_replace("(", '', $val);
				$val = str_replace(")", '', $val);
				$val = str_replace("'", '', $val);
				$sql .= $sql ? " AND `$key` = '$val' " : " `$key` = '$val' ";
			}
			return $sql;
		} else {
			$data = str_replace("%20", '', $data);
			$data = str_replace("%27", '', $data);
			return $data;
		}
	}

    /**
     * 查询多条数据
     * @param $table 数据表名
     * @param array|string $where 条件 ，数组或者字符串 .如：array('id'=>1,'cid'=>1) 或 `id`=1 AND `cid`=1
     * @param string $field 要查询的字段
     * @param int $startid 开始索引，如果是从第二条开始，那么则为1，mysql从0开始索引
     * @param int $pagesize 每页显示数量，如果不分页，则显示为总数
     * @param int $page 当前页
     * @param string $order 排序
     * @param string $group mysql group by 属性
     * @param string $keyfield 以某字段名为结果索引
     * @param string $urlrule url规则
     * @param array $array url规则中的参数名和参数值，二维数组
     * @param int $colspan 分页显示总列数
     * @return array
     */
	final public function get_list($table, $where = '', $field = '*', $startid = 0, $pagesize = 200, $page = 0, $order = '', $group = '', $keyfield = '', $urlrule = '',$array = array(),$colspan = 10) {
		$where = $this->array2sql($where);
		$offset = 0;
        $page = max(intval($page), 1);
        $offset = $pagesize*($page-1)+$startid;
		if($page) {
			$this->number = $this->count_result($table,$where);
			$this->pages = pages($this->number, $page, $pagesize, $urlrule, $array,$colspan);
		}
		if ($page && $this->number == 0) {
			return array();
		} else {
			return $this->read_db->get_list($table, $where, $field, "$offset,$pagesize", $order, $group, $keyfield);
		}
	}

	/**
	 * get list count for custom query sql
	 * @param $sql 			parameterized SQL String
	 * @param $param 		SQL condition map[array]
	 * @return int			result count size
	 * @author jiucai
	 */
	final public function get_page_list_count($sql,$param = array()) {
		return $this->read_db->get_page_list_count($sql,$param);
	}

	/**
	 * get list for custom query sql
	 * @param $sql 			parameterized SQL String
	 * @param $param 		SQL condition map[array]
	 * @param $page 		page number
	 * @param $pagesize 	page size
	 * @return array/null	数据查询结果集,如果不存在，则返回空
	 * @author jiucai
	 */
	final public function get_page_list($sql,$param = array(), $page = 0, $pagesize = 0 ) {
		return $this->read_db->get_page_list($sql,$param, $page, $pagesize);
	}


	/**
	 * 获取单条记录查询
	 * @param $table 		表名称
	 * @param $where 		查询条件
	 * @param $field 		需要查询的字段[多个字段用逗号隔开：例如，field1,field2]
	 * @param $startid 		开始的条数，limit $startid,10 
	 * @param $order 		排序方式	[默认按数据库默认方式排序]
	 * @param $group 		分组方式	[默认为空]
	 * @return array/null	数据查询结果集,如果不存在，则返回空
	 */
	final public function get_one($table, $where = '', $field = '*', $startid = 0, $order = '', $group = '') {
		$where = $this->array2sql($where);
		return $this->read_db->get_one($table, $where, $field, "$startid,1", $order, $group);
	}

	/**
	 * 直接执行sql查询
	 * @param $sql							查询sql语句
	 * @return	boolean/query resource		如果为查询语句，返回资源句柄，否则返回true/false
	 */
	final public function query($sql,$type = '') {
		$sql = str_replace('wz_', $this->tablepre, $sql);
		return $this->master_db->query($sql, $type);
	}
	
	/**
	 * 执行添加记录操作
	 * @param $data 		要增加的数据，参数为数组。数组key为字段值，数组值为数据取值
	 * @param $returnid 是否返回新建ID号
	 * @param $replace_into 是否采用 replace into的方式添加数据
	 * @return boolean
	 */
	final public function insert($table, $data, $returnid = TRUE, $replace_into = FALSE) {
		return $this->master_db->insert($table, $data, $returnid, $replace_into);
	}
	
	/**
	 * 获取最后一次添加记录的主键号
	 * @return int 
	 */
	final public function insert_id() {
		return $this->master_db->insert_id();
	}
	
	/**
	 * 执行更新记录操作
	 * @param $data 		要更新的数据内容，参数可以为数组也可以为字符串，建议数组。
	 * 						为数组时数组key为字段值，数组值为数据取值
	 * @param $where 		更新数据时的条件,可为数组或字符串
	 * @return boolean
	 */
	final public function update($table, $data, $where = '') {
		$where = $this->array2sql($where);
		return $this->master_db->update($table, $data, $where);
	}

	/**
	 * 执行删除记录操作
	 * @param $where 		删除数据条件,不充许为空。
	 * @return boolean
	 */
	final public function delete($table, $where = '') {
		$where = $this->array2sql($where);
		return $this->master_db->delete($table, $where);
	}
	
	/**
	 * 计数，求和等
	 * @param string/array $where 查询条件
	 */
	final public function count($table, $where = '', $field = "COUNT(*) AS num", $startid = 0, $order = '', $group = '') {
		$where = $this->array2sql($where);
		return $this->read_db->get_one($table, $where, $field, "$startid,1", $order, $group, FALSE);
	}

	/**
	 * 计数，求和等
	 * @param string/array $where 查询条件
	 */
	final public function count_result($table, $where = '', $field = "COUNT(*) AS num", $startid = 0, $order = '', $group = '') {
		$r = $this->count($table, $where, $field, $startid, $order, $group);
		return $r['num'];
	}
	/**
	 * mysql_fetch_array() 函数从结果集中取得一行作为关联数组，或数字数组，或二者兼有,
	 * 返回根据从结果集取得的行生成的数组，如果没有更多行则返回 false
	 */
	final public function fetch_array($query) {
		return $this->master_db->fetch_array($query);
	}

	/**
	 * mysql_fetch_row() 函数从结果集中取得一行作为数字数组
	 * @return int
	 */
	final public function fetch_row($query) {
		return $this->read_db->fetch_row($query);
	}

	/**
	 * mysql_fetch_field() 函数从结果集中取得列信息并作为对象返回。
	 * @return int
	 */

	final public function fetch_fields($query) {
		return $this->read_db->fetch_fields($query);
	}

	/**
	 * mysql_affected_rows() 函数返回前一次 MySQL 操作所影响的记录行数
	 * @return int
	 */
	final public function affected_rows($query) {
		return $this->master_db->affected_rows($query);
	}

	/**
	 * mysql_num_rows() 函数返回结果集中行的数目
	 * @return int
	 */
	final public function num_rows($query) {
		return $this->read_db->num_rows($query);
	}
	/**
	 * mysql_num_fields() 函数返回结果集中字段的数
	 */
	final public function num_fields($query) {
		return $this->master_db->num_fields($query);
	}

	/**
	 * mysql_free_result() 函数释放结果内存
	 */
	final public function free_result($query) {
		return $this->master_db->free_result($query);
	}
	
	/**
	 * 返回数据库版本号
	 */
	final public function version() {
		return $this->read_db->version();
	}
}
?>
