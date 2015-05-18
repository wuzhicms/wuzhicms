<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容模版，标签解析
 */
class WUZHI_dianping_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
    public function __construct() {
        $this->db = load_class('db');
    }
    /**
     * 列表标签
     *
     * @param $c
     * @return array
     */
    public function listing($c) {
        if(!isset($c['keyid'])) return array();
        if(isset($c['urlrule'])) {
            $urlrule = $c['urlrule'];
        } else {
            $urlrule = 'javascript:dp_page({$page});';
        }
        $rule_arr = array('page'=>$c['page']);
        $result = $this->db->get_list('dianping', array('keyid'=>$c['keyid']), '*', $c['start'], $c['pagesize'], $c['page'],'id DESC','','',$urlrule,$rule_arr);
        $groups = get_cache('group','member');
        $newdata = array();
        foreach($result as $rs) {
            if($rs['uid']) {
                $r = $this->db->get_one('member', array('uid' => $rs['uid']));
                $rs['username'] = $r['username'];
                $rs['groupid'] = $r['groupid'];
                $rs['groupname'] = $groups[$r['groupid']]['name'];
            }
            $newdata[] = $rs;
        }
        if($c['page']) {
            $this->pages = $this->db->pages;
            $this->number = $this->db->number;
        }
        return $newdata;
	}
}