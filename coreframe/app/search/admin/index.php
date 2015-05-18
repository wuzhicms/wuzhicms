<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: jiucai <zhaidw@jiucai.org>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');

class index extends WUZHI_admin {
	private $db;

	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 *
	 */
	public function listing() {

        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$pagesize = 10;

        //$where = array(':m'=>'search \' or \'1\'=\'1' );
        $where = array();

		//echo 'where str: '. $where[':m'].'<br/>';
        $page = max($page,1);

        //$result = $this->db->get_list('global_config', $where, '*', 0, 20,$page,'sort asc, id asc');

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

		include $this->template('search_listing');
	}


    public function model_list(){

        $resultJson = array();

        $resultList = $this->get_model_list();

        foreach ( $resultList as $key => $value ) {
            foreach($value as $k => $v){
                $resultJson[$key][$k] = urlencode ( $v );
            }

        }
        echo urldecode ( json_encode ( $resultJson ) );



        exit();

    }


    private function get_model_list(){

        $selectm = isset($GLOBALS['selectm']) ? trim($GLOBALS['selectm']) : 'content';

        $where = array(':m'=> $selectm );

        //print_r($where);

        $sql  = " select  ";
        $sql .= "  modelid, ifnull(name,'') as name ";
        $sql .= " from ".$this->db->tablepre."model ";
        $sql .= " where 1=1 ";

        //echo 'selectm: '. $selectm. '<br/>';

        //if('' != $selectm){
            $sql .= " and m = :m ";
        //}

        $sql .= " order by name asc";

        //echo $sql;


        return $this->db->get_page_list($sql, $where);

    }


    private function get_module_list(){

        $sql  = " select  ";
        $sql .= "  m ";
        $sql .= " from ".$this->db->tablepre."setting ";
        $sql .= " where keyid='has_model' and data='1' order by m ";

        return $this->db->get_page_list($sql);

    }



	/**
	 *
	 */
	public function add() {

        if(isset($GLOBALS['submit'])) {

            $formdata = array();
            $formdata['m'] =  $GLOBALS['form']['selectm'];
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['modelid'] = $GLOBALS['form']['modelid'];
            $formdata['remark'] = $GLOBALS['form']['remark'];



            $this->db->insert('search_category', $formdata);


            MSG(L('operation_success'));
        }else{

            $result = array('name' => '', 'modelid' => '', 'remark' => '', 'm' => '');

            $module_list = $this->get_module_list();
            $model_list = $this->get_model_list();

            $v = 'add';
            $sid='';

            include $this->template('search_detail');

        }
	}
	/**
	 *
	 */
	public function edit() {
        if(isset($GLOBALS['submit'])) {


            $formdata = array();
            $formdata['m'] = $GLOBALS['form']['selectm'];
            $formdata['name'] = $GLOBALS['form']['name'];
            $formdata['modelid'] = $GLOBALS['form']['modelid'];
            $formdata['remark'] = $GLOBALS['form']['remark'];


            $sid = isset($GLOBALS['sid']) ? intval($GLOBALS['sid']) : 0;
            $where = array('id'=> $sid);

            $this->db->update('search_category', $formdata, $where);

            MSG(L('operation_success'));
        }else{
            $v = 'edit';
            $sid = isset($GLOBALS['sid']) ? intval($GLOBALS['sid']) : 0;
            $where = array('id'=> $sid);

            $result = $this->db->get_one('search_category', $where);


            $module_list = $this->get_module_list();
            $model_list = $this->get_model_list();

            include $this->template('search_detail');

        }
	}
	/**
	 *
	 */
	public function del() {

        $sid = isset($GLOBALS['sid']) ? intval($GLOBALS['sid']) : 0;
        $where = array('id'=> $sid);

        $result = $this->db->delete('search_category', $where);

        MSG(L('operation_success'));

	}
}