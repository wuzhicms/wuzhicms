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
class WUZHI_link_template_parse {
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
        if(!isset($c['kid'])) return array();
        $kid = intval($c['kid']);
        if($kid) {
            $where = '`kid`='.$kid;
        } else {
            $where = '';
        }
        $order = isset($c['order']) ? $c['order'] : 'sort ASC';
        $result = $this->db->get_list('link', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        return $result;
	}
}