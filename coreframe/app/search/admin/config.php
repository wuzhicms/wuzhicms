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

//encode gbk
class config extends WUZHI_admin {
	private $db;

    private $fulltextenble;
    private $relationenble;
    private $suggestenable;


    private $sphinxenable;
    private $sphinxhost;
    private $sphinxport;

    private $table = '';

	function __construct() {
		$this->db = load_class('db');
        $this->table = "search_config";
	}

/**
init sql:

insert into wz_global_config (sort,m,name,config_key,config_val)
values
(1,'search_config','是否启用全站搜索','fulltextenble','0'),
(2,'search_config','是否启用相关搜索','relationenble','0'),
(3,'search_config','是否启用建议搜索','suggestenable','0');
 *
 *
 */
	public function index() {


        $this->base_config();
        $this->full_index();

        $fulltextenble = $this->fulltextenble;
        $relationenble = $this->relationenble;
        $suggestenable = $this->suggestenable;

        $sphinxenable = $this->sphinxenable;
        $sphinxhost = $this->sphinxhost;
        $sphinxport = $this->sphinxport;

        include $this->template('config');

	}

    private function base_config(){

        $where = " config_key in ('fulltextenble', 'relationenble', 'suggestenable') ";

        $sql  = " select  ";
        $sql .= " config_key, config_val ";
        $sql .= " from ".$this->db->tablepre.$this->table;
        $sql .= " where ";
        $sql .= $where;

        $result = $this->db->get_page_list($sql);



        if(isset($result) && is_array($result)){
            foreach($result as $r){

                if('fulltextenble' == $r['config_key']){
                    $this->fulltextenble = $r['config_val'];
                }

                if('relationenble' == $r['config_key']){
                    $this->relationenble = $r['config_val'];
                }
                if('suggestenable' == $r['config_key']){
                    $this->suggestenable = $r['config_val'];
                }

            }
        }


    }

    private function full_index(){



        $where = " config_key in ('sphinxenable', 'sphinxhost', 'sphinxport') ";

        $sql  = " select  ";
        $sql .= "  config_key, config_val ";
        $sql .= " from ".$this->db->tablepre.$this->table;
        $sql .= " where ";
        $sql .= $where;


        $result = $this->db->get_page_list($sql);

        if(isset($result) && is_array($result)){
            foreach($result as $r){

                if('sphinxenable' == $r['config_key']){
                    $this->sphinxenable = $r['config_val'];
                }

                if('sphinxhost' == $r['config_key']){
                    $this->sphinxhost = $r['config_val'];
                }
                if('sphinxport' == $r['config_key']){
                    $this->sphinxport = $r['config_val'];
                }

            }
        }


    }


    /**
     *
     */
    public function save() {
        $where = array();

        $fulltextenble = remove_xss($GLOBALS['cfg']['fulltextenble']);
        $relationenble = remove_xss($GLOBALS['cfg']['relationenble']);
        $suggestenable = remove_xss($GLOBALS['cfg']['suggestenable']);



        $where['config_key'] = 'fulltextenble';
        $result = $this->db->update($this->table,array('config_val' => $fulltextenble), $where);

        $where['config_key'] = 'relationenble';
        $result = $this->db->update($this->table,array('config_val' => $relationenble), $where);


        $where['config_key'] = 'suggestenable';
        $result = $this->db->update($this->table,array('config_val' => $suggestenable), $where);

        $sphinxenable = remove_xss($GLOBALS['cfg']['sphinxenable']);
        $sphinxhost   = remove_xss($GLOBALS['cfg']['sphinxhost']);
        $sphinxport   = remove_xss($GLOBALS['cfg']['sphinxport']);



        $where['config_key'] = 'sphinxenable';
        $result = $this->db->update($this->table, array('config_val' => $sphinxenable), $where);

        $where['config_key'] = 'sphinxhost';
        $result = $this->db->update($this->table,array('config_val' => $sphinxhost), $where);

        $where['config_key'] = 'sphinxport';
        $result = $this->db->update($this->table,array('config_val' => $sphinxport), $where);



        MSG(L('operation success'));


    }



    public function test() {


        $sphinxhost   = remove_xss($GLOBALS['sphinxhost']);
        $sphinxport   = remove_xss($GLOBALS['sphinxport']);


        $sphinxhost = !empty($sphinxhost) ? $sphinxhost : exit('-1');
        $sphinxport = !empty($sphinxport) ? intval($sphinxport) : exit('-2');
        $fp = @fsockopen($sphinxhost, $sphinxport, $errno, $errstr , 2);
        if (!$fp) {
            exit($errno.':'.$errstr);
        } else {
            exit('1');
        }
    }


}