<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');
load_function('content', 'content');
/**
 * 升级SQL
 */
class upgrade
{
    public function __construct()
    {
        $this->db = load_class('db');
    }

    public function updateScheme()
    {
        $this->sql_execute();
        $this->auto_execute();
        return true;
    }

    protected function sql_execute()
    {
        $sqlfile = dirname(__FILE__).'/sql.sql';

        if (!file_exists($sqlfile)) {
            return false;
        }
        $sql = file_get_contents($sqlfile);

        $sql = preg_replace("/ENGINE=(InnoDB|MyISAM|MEMORY) DEFAULT CHARSET=([^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8", $sql);
        if ($this->db->tablepre != 'wz_') {
            $sql = str_replace('`wz_', '`'.$this->db->tablepre, $sql);
        }

        $sql          = str_replace("\r", "\n", $sql);
        $ret          = array();
        $num          = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries   = explode("\n", trim($query));
            $queries   = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-') {
                    $ret[$num] .= $query;
                }
            }
            $num++;
        }

        if (is_array($ret)) {
            foreach ($ret as $sql) {
                if (trim($sql) != '') {
                    $this->db->query($sql);
                }
            }
        } else {
            $this->db->query($ret);
        }
        return true;
    }

    /**
     * 执行每次升级的外部php文件
     */
	protected function auto_execute()
	{
		$db = $this->db;
		$currentdir = dirname(__FILE__);
		if(file_exists($currentdir.'/auto_execute.php')) {
			include $currentdir.'/auto_execute.php';
		}
	}
}
