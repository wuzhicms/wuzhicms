<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

/**
 * 自驾游
 */
class WUZHI_zjy_api {
    public $db_tablename = 'tour';//TODO 必须修改
    public $filed_array = array('avg_field1','avg_field2','avg_field3');
	public function __construct() {
        $this->db = load_class('db');
	}
    public function get($id) {
        $r = $this->db->get_one($this->db_tablename, array('id' => $id));
        return $r;
    }
}