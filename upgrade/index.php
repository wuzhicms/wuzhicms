<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 升级程序
 */

//检测PHP环境
if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');
//定义当前的网站物理路径
define('WWW_ROOT',substr(dirname(__FILE__),0,-7));

require WWW_ROOT.'configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$db = load_class('db');

function sql_execute($sql) {
	global $db;
	$sql = preg_replace("/ENGINE=(InnoDB|MyISAM|MEMORY) DEFAULT CHARSET=([^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8",$sql);
	if($db->tablepre != 'wz_') $sql = str_replace('`wz_', '`'.$db->tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query) {
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}

	if(is_array($ret)) {
		foreach($ret as $sql) {
			if(trim($sql) != '') {
				$db->query($sql);
			}
		}
	} else {
		$db->query($ret);
	}
	return true;
}

$vers = explode('.',VERSION);
$packdir = WWW_ROOT.'upgrade/'.$vers[0].'.'.$vers[1].'/'.$vers[2];
$sqlfile = $packdir.'/sql.sql';
$upgradefile = $packdir.'/upgrade.php';
if(file_exists($sqlfile)) {
	$sql = file_get_contents($sqlfile);
	sql_execute($sql);
	unlink($sqlfile);
}
if(file_exists($upgradefile)) {
	include $upgradefile;
	unlink($upgradefile);
}
echo '升级成功';
?>