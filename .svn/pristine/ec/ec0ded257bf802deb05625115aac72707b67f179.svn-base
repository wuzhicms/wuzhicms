<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: jiucai <zhaidw@jiucai.org>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_search {
	private $db;
    private $searchapi;

    private $msg = '';


    function __construct() {
        $this->db = load_class('db');
        $this->searchapi = load_class('searchapi',M);
    }

    public function delete_index() {
        $delete_condition = ' 1=1 ';
        $this->db->delete('search_index',$delete_condition);
        $this->db->delete('search_result',$delete_condition);

    }

    public function create_index() {

        $pagesize= isset($GLOBALS['pagesize']) ? intval($GLOBALS['pagesize']) : 1;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $where = array();
        $page = max($page,1);
        if($page == 1){
            $this->delete_index();
        }
        $sql  = " select  ";
        $sql .= "  gc.id, m.m, gc.modelid, gc.name, gc.remark, gc.sort, m.name as model_name ";
        $sql .= " from ".$this->db->tablepre."search_category gc ";
        $sql .= " left join ".$this->db->tablepre."model m ";
        $sql .= "    on m.modelid = gc.modelid ";
        $sql .= " order by gc.sort asc, gc.id desc";

        //get sql count
        $count  = $this->db->get_page_list_count($sql,$where);
        $pages = pages($count, $page, $pagesize);
        //get sql page list
        $result = $this->db->get_page_list($sql,$where,$page,$pagesize);

        foreach ($result as $row) {

            //TODO:
            // query content
            $data = array();

            $data['m'] = $row['m'];
            $data['keyid'] = $row['modelid'];
            $data['data_id']= '';
            $data['full_title']='';
            $data['data']= '好久没有在家里鼓捣代码了';
            $data['title']= $row['name'];
            $data['remark']= '';
            $data['url']= '';
            $data['thumb']= '';
            $data['updatetime']= gmdate('Y-m-d H:i:s', time() + 3600 * 8);


            $this->searchapi->add($data);

        }


        $this->msg = '索引重建完毕';

        MSG(safe_htm($this->msg));

    }


}