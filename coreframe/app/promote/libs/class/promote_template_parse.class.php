<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 广告模版，标签解析
 */
class WUZHI_promote_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
	public $childs = '';//子栏目
    public function __construct() {
        $this->db = load_class('db');
        $this->categorys = get_cache('category','content');
    }

    /**
     * 广告列表
     * @param $c
     */
    public function listing($c) {
        $order = isset($c['order']) ? $c['order'] : 'sort DESC,id DESC';
        $pid = isset($c['pid']) ? intval($c['pid']) : 0;
        $siteid = isset($c['siteid']) ? intval($c['siteid']) : 1;
        $keyid = isset($c['keyid']) ? strip_tags($c['keyid']) : '';
        if($pid) {
            $where = array('pid' => $pid,'siteid'=>$siteid);
        } elseif($keyid) {
            $where = array('keyid' => $keyid);
        } else {//cid为空时，为调用全部排行
            $where = '';
        }
        $result = $this->db->get_list('promote', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        return $result;
    }


}