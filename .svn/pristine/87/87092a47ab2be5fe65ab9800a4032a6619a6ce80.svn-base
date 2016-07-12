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

$versions = '';
/**
 * 手动升级用户,通过修改版本号,挨个升级即可.
 * 比如:之前是:2.1.0版本,$versions填写2.1.0,
 * 然后执行:http://mydomain/upgrade/
 * 当前升级版本有:2.1.0 ~ 2.1.2 ~ 2.1.4 ~ 3.0.0 ~ 3.0.2 ~ 3.0.3
 * 依次升级
 */

//$versions = '3.0.0';


if($versions=='') $versions = VERSION;
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
$vers = explode('.',$versions);

$packdir = WWW_ROOT.'upgrade/'.$vers[0].'.'.$vers[1].'/'.$vers[2];
$sqlfile = $packdir.'/sql.sql';
$upgradefile = $packdir.'/upgrade.php';
if(!is_writable($sqlfile)) {
	exit('请设置文件权限为可写:'.$sqlfile);
}
if(!is_writable($upgradefile)) {
	exit('请设置文件权限为可写:'.$upgradefile);
}
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