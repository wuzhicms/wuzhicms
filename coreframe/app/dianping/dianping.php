<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class dianping {
 	function __construct() {
        $this->db = load_class('db');
    }

    public function show() {
        $keyid = $GLOBALS['keyid'];
        if(!preg_match('/^([a-z]{1,}[a-z0-9]+)/',$keyid)) MSG('keyid参数错误');
        load_function('common','member');
        //$dianping_array = array(1=>'很差',2=>'差',3=>'一般',4=>'好',5=>'很好');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        if(!preg_match('/([a-z0-9_\-])/',$GLOBALS['template'])) exit('模板错误');
        $total = $this->db->count_result('dianping',array('keyid'=>$keyid));
        $count_1 = $this->db->count_result('dianping',array('keyid'=>$keyid,'field1'=>1));
        $count_2 = $this->db->count_result('dianping',array('keyid'=>$keyid,'field1'=>2));
        $count_3 = $this->db->count_result('dianping',array('keyid'=>$keyid,'field1'=>3));
        $count_4 = $this->db->count_result('dianping',array('keyid'=>$keyid,'field1'=>4));
        $count_5 = $this->db->count_result('dianping',array('keyid'=>$keyid,'field1'=>5));
        $id = intval($GLOBALS['id']);
        $key = substr($keyid,0,3);
        $dianping_api = load_class($key.'_api','dianping');
        $data = $dianping_api->get($id);
        $template = $GLOBALS['template'];
        include T('dianping',$template);
    }
}