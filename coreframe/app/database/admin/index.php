<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: haochuan <haochuan6868@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 数据库管理
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
	 * 数据库导出
	 */
	public function export() {
		$dosubmit = isset($GLOBALS['dosubmit']) ? $GLOBALS['dosubmit'] : '';
		if($dosubmit){
			$sizelimit = isset($GLOBALS['sizelimit']) ? $GLOBALS['sizelimit'] : '';
			$sqlcompat = isset($GLOBALS['sqlcompat']) ? $GLOBALS['sqlcompat'] : '';
			$sqlcharset = isset($GLOBALS['sqlcharset']) ? $GLOBALS['sqlcharset'] : '';
			$tables = isset($GLOBALS['tables']) ? $GLOBALS['tables'] : '';

			$fileid = isset($GLOBALS['fileid']) ? trim($GLOBALS['fileid']) : '';
			$random = isset($GLOBALS['random']) ? trim($GLOBALS['random']) : '';
			$tableid = isset($GLOBALS['tableid']) ? trim($GLOBALS['tableid']) : '';
			$startfrom = isset($GLOBALS['startfrom']) ? trim($GLOBALS['startfrom']) : '';
			$tabletype = isset($GLOBALS['tabletype']) ? trim($GLOBALS['tabletype']) : 'mysql';
			
			$this->export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$fileid,$random,$tableid,$startfrom);
		}else{
			$tbl_show = $this->db->query("SHOW TABLE STATUS");
			while($row = $this->db->fetch_array($tbl_show)) {
				$tables[] = $row;	
			}
			$infos = $this->status($tables);
			include $this->template('export');
		}
	}
	/**
	 * 数据库导入
	 */
	public function import() {
		if(isset($GLOBALS['dosubmit'])){
			$filename = trim($GLOBALS['filename']);
            $fileid = $GLOBALS['fileid'] ? $GLOBALS['fileid'] : 1;

            $newfilename = $filename.'_'.$fileid.'.sql';
            $filepath = CACHE_ROOT.'db_bak/'.CACHE_EXT.'/'.$newfilename;
            if(file_exists($filepath)) {
                $sql = file_get_contents($filepath);
                $this->sql_execute($sql);
                $fileid++;
                MSG($newfilename." 恢复成功","?m=database&f=index&v=import&filename=".$filename."&fileid=".$fileid."&dosubmit=1".$this->su(),100);
            } else {
                MSG("导入成功！","?m=database&f=index&v=import".$this->su());
            }

		} else {
            $sqlfiles = glob(CACHE_ROOT.'db_bak/'.CACHE_EXT.DIRECTORY_SEPARATOR.'*.sql');
            if(is_array($sqlfiles)){
                $datas = array();
                foreach($sqlfiles as $id => $sqlfile){
                    $filename = substr(basename($sqlfile),0,17);
                    $datas[$filename]['filename'] = $filename;
                    $datas[$filename]['filesize'] = isset($datas[$filename]['filesize']) ? $datas[$filename]['filesize'] + filesize($sqlfile) : filesize($sqlfile);
                    $datas[$filename]['volume'] = isset($datas[$filename]['volume']) ? $datas[$filename]['volume'] + 1 : 1;
                    $datas[$filename]['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                }
            }
            include $this->template('import');
        }
	}

	/**
	 * 获取数据表
	 * @param unknown_type 数据表数组
	 * @param unknown_type 表前缀
	 */
	public function status($tables) {
		$wz_cms = array();
		foreach($tables as $table) {
			$row = array('name'=>$table['Name'],'rows'=>$table['Rows'],'size'=>$table['Data_length']+$table['Index_length'],'engine'=>$table['Engine'],'data_free'=>$table['Data_free'],'collation'=>$table['Collation']);
			$wz_cms[] = $row;			
		}
		return array('wz_cmstables'=>$wz_cms);
	}

	/**
	 * 数据库导出方法
	 * 
	 *
	 */
	private function export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$fileid,$random,$tableid,$startfrom) {
		$dumpcharset = $sqlcharset ? $sqlcharset : str_replace('-', '', CHARSET);
		$fileid = ($fileid != '') ? $fileid : 1;
		if($fileid==1 && $tables) {
			if(!isset($tables) || !is_array($tables)) {
				MSG("请选择数据表");
			}
			set_cache('database', $tables,'database');
			$random = random(8);
		} else {
			$tables = get_cache('database','database');
			if($tables == 1) {	
				MSG("请选择数据表");
			}
		}
		$tabledump = '';
		$tableid = ($tableid!= '') ? $tableid - 1 : 0;
		$startfrom = ($startfrom != '') ? intval($startfrom) : 0;
		for($i = $tableid; $i < count($tables) && strlen($tabledump) < $sizelimit * 1000; $i++) {
			global $startrow;
			$offset = 100;
			if(!$startfrom) {
				$tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
				$createtable = $this->db->query("SHOW CREATE TABLE `$tables[$i]` ");
				$create = $this->db->fetch_array($createtable);
				$tabledump .= $create['Create Table'].";\n\n";
				$this->db->free_result($createtable);
				if($this->db->version() > '4.1' && $sqlcharset) {
					$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump);
				}
			}
			$numrows = $offset;
			while(strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
				$sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";
				$query = $this->db->query($sql);
				$numfields = $this->db->num_fields($query);
				$numrows = $this->db->num_rows($query);
				$fields_name = $this->get_fields($tables[$i]);
				$rows = $this->db->query($sql);
				$name = array_keys($fields_name);
				$r = array();
				while ($row = $this->db->fetch_array($query)) {
					$r[] = $row;
					$comma = "";
					$tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
					for($j = 0; $j < $numfields; $j++) {
						$tabledump .= $comma."'".str_replace("\n","\\n", addslashes($row[$name[$j]]))."'";
						$comma = ",";
					}
					$tabledump .= ");\n";
				}
				$this->db->free_result($rows);
				$startfrom += $offset;
			}
			$tabledump .= "\n";
			$startrow = $startfrom;
			$startfrom = 0;
		}
		if(trim($tabledump)) {

			$tabledump = "# wuzhicms bakfile\n# version:wuzhicms\n# time:".date('Y-m-d H:i:s')."\n# type:wuzhicms\n# wuzhicms:http://www.wuzhicms.com\n# --------------------------------------------------------\n\n\n".$tabledump;
			$tableid = $i;
			$filename = $random.'_'.date('Ymd').'_'.$fileid.'.sql';
			$altid = $fileid;
			$fileid++;
			$bakfile_path = CACHE_ROOT.'db_bak/'.CACHE_EXT.'/';
            if(!file_exists($bakfile_path)) {
                mkdir($bakfile_path,0777,true);
            }
			$bakfile = $bakfile_path.$filename;
			file_put_contents($bakfile, $tabledump);
			//@chmod($bakfile, 0777);
			MSG("备份文件".$filename."成功",'?m=database&f=index&v=export&sizelimit='.$sizelimit.'&sqlcompat='.$sqlcompat.'&sqlcharset='.$sqlcharset.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random.'&dosubmit=1'.$this->su());
		} else {
			$bakfile_path = CACHE_ROOT.'db_bak/'.CACHE_EXT.'/';

			file_put_contents($bakfile_path.'index.html',' ');
			set_cache('database','','database');
			MSG("备份成功","?m=database&f=index&v=export".$this->su());
		}
	} 

	/**
	 * 数据库修复、优化
	 */
	public function public_repair() {
		$tables = $GLOBALS['tables'];
		$operation = trim($GLOBALS['operation']);
		if($tables && in_array($operation,array('repair','optimize'))) {
			$this->db->query("$operation TABLE $tables");
			MSG("操作成功！","?m=database&f=index&v=export".$this->su());
		}
	}

	public function get_fields($table) {
		$fields = array();
		$columns = $this->db->query("SHOW COLUMNS FROM $table");
			while ($r = $this->db->fetch_array($columns)){
				$fields[$r['Field']] = $r['Type'];
			}
		return $fields;
	}
	/**
	 * 执行SQL
	 */
 	private function sql_execute($sql) {
	    $sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					//echo $sql."\r\n";
					$sql = str_replace ( "\n", "", $sql );
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}

 	private function sql_split($sql) {
		//$sql=str_replace("\r","\n",$sql);
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