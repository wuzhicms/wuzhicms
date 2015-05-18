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
        $template = $GLOBALS['template'];
        include T('dianping',$template);
    }
}