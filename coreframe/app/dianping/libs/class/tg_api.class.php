<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 体检中心
 */
class WUZHI_tg_api {
	public function __construct() {
        $this->db = load_class('db');
	}

    /**
     * 获取mec
     *
     * @param $id 内容id
     */
    public function get($id) {
        $order_card = $this->db->get_one('order_card', array('cardid' => $id));
        if(!$order_card) MSG('无法点评该信息！');
        $r = $this->db->get_one('tuangou', array('id' => $order_card['id']));
        return $r;
    }
}