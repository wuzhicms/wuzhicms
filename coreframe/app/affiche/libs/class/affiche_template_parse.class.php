<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 系统公告模版，标签解析
 */
class WUZHI_affiche_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
    public function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 系统公告列表标签
     *
     * @param $c
     * @return array
     */
    public function listing($c) {
        $where = $c['status'];
        $order = isset($c['order']) ? $c['order'] : 'id DESC';
        $result = $this->db->get_list('affiche', $where, '*', $c['start'], $c['pagesize'], $c['page'],$order);
        if(!empty($result)) {
            foreach($result as $key=>$rs) {
                $result[$key]['url'] = WEBURL.'index.php?m=affiche&f=index&v=show&&id='.$rs['id'];
            }
        }
        if($c['page']) {
            $this->pages = $this->db->pages;
        }
        return $result;
	}
}