<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 数据库处理
 */
function sql_execute(&$db,$sql) {
    $sqls = sql_split($sql,$db->dbcharset,$db->tablepre);
	if(is_array($sqls)) {
		foreach($sqls as $sql) {
			if(trim($sql) != '') {
				$db->query($sql);
			}
		}
		return TRUE;
	} else {
		return $db->query($sqls);
	}
}

function sql_split($sql,$dbcharset,$tablepre) {
	$sql = str_replace('ENGINE=MyISAM DEFAULT CHARSET=gbk;', 'ENGINE=MyISAM DEFAULT CHARSET='.$dbcharset.';', $sql);
	$sql = str_replace('wuzhicms_', $tablepre, $sql);
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unset($sql);
	foreach($queriesarray as $query)
	{
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		$queries = array_filter($queries);
		foreach($queries as $query)
		{
			$str1 = substr($query, 0, 1);
			if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
		}
		$num++;
	}
	return $ret;
}