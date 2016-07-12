<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 订单内容查询
 */
class WUZHI_order_api {
	public function __construct() {
        $this->db = load_class('db');
	}
    public function get($keyid = '') {
        if($keyid) {
            $ids = explode('-',$keyid);
            $cid = $ids[0];
            $id = $ids[1];
        } else {
            if(!isset($GLOBALS['id']) || !isset($GLOBALS['cid'])) return false;
            $id = intval($GLOBALS['id']);
            $cid = intval($GLOBALS['cid']);
        }

        $category = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        $modelid = $category['modelid'];
        $master_table = $models[$modelid]['master_table'];
        $r = $this->db->get_one($master_table,array('id'=>$id));
        if($r) {
            $r['form_fields'] = array('id','cid');
            $r['keyid'] = $r['cid'].'-'.$r['id'];
            if($models[$modelid]['attr_table']) {
                $r2 = $this->db->get_one($models[$modelid]['attr_table'],array('id'=>$id));
                if($r2) $r = array_merge($r,$r2);
            }
            return $r;
        } else {
            return false;
        }
    }
    public function surplus($cid,$id) {
        $category = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        $modelid = $category['modelid'];
        $master_table = $models[$modelid]['master_table'];
        $this->db->update($master_table, "`surplus`=(`surplus`-1)", array('id' => $id));
    }
}