<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 网站首页
 */
class json{
    private $siteconfigs;
    public  $childs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
        $this->categorys = get_cache('category','content');

    }

    /**
     * 栏目列表
     */
    public function listing() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        $category = get_cache('category_'.$cid,'content');
        //分页初始化
        $page = max(intval($GLOBALS['page']),1);
        $pagesize = isset($GLOBALS['pagesize']) ? intval($GLOBALS['pagesize']) : 20;
        $model_r = get_cache('model_content','model');
        $master_table = $model_r[$category['modelid']]['master_table'];
        if($category['type']==1) {
            $r = $this->db->get_one($master_table,array('cid'=>$cid));
            if($r) {
                extract($r,EXTR_SKIP);
                if($attr_table = $model_r[$category['modelid']]['attr_table']) {
                    $r = $this->db->get_one($attr_table,array('id'=>$id));
                    json_encode($r);
                }
            }
        } else {
            if($category['child']) {
                $this->childs = '';
                $this->get_child($cid);
                $cids = implode(',',$this->childs);
                $where = '`cid` IN ('.$cids.') AND `status`=9';
            } else {
                $where = "`cid`='$cid' AND `status`=9";
            }

            $result = $this->db->get_list($master_table, $where, '*', 0, $pagesize, $page,'sort DESC,id DESC');
            if(empty($result)) {
                echo json_encode('finish');
                exit();
            }
            foreach($result as $key=>$rs) {
                $result[$key]['catname'] = $this->categorys[$rs['cid']]['name'];
                $result[$key]['updatetime'] = date('Y-m-d',$rs['updatetime']);
            }
            if(strtolower(CHARSET)=='gbk') {
                $result = array_iconv('gbk','utf-8',$result);
            }
            echo json_encode($result);
        }
    }
    private function get_child($k_id) {
        foreach($this->categorys as $id => $value) {
            if($value['pid'] == $k_id) {
                $this->childs[] = $id;
                $this->get_child($id);
            }
        }
    }

}
?>