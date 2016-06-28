<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: jiucai <zhaidw@jiucai.org>
// +----------------------------------------------------------------------
class WUZHI_search_api {
	private $db;
    private $segment;

	public function __construct() {
        $this->db = load_class('db');
	}
    public function add($data) {
        //insert
        $formdata = array();
        $data_key = '';
        $formdata['id'] = $this->db->insert('search_index',array('m'=>$data['m'],'keyid'=>$data['keyid'],'data_id'=>$data['data_id'],'full_title'=>$data['full_title'],'tags_data'=>$data['tags_data'],'data_key'=>$data_key,'index_time'=>SYS_TIME));
        $formdata['title'] = $data['title'];
        $formdata['remark'] = $data['remark'];
        $formdata['url'] = $data['url'];
        $formdata['thumb'] = $data['thumb'];
        $formdata['updatetime'] = $data['updatetime'];
        $this->db->insert('search_result',$formdata);
        return $formdata['id'];
    }
	public function update($data) {
        $data['tags_data'] = str_replace(',',' ',trim($data['tags_data'],','));
        if($r = $this->db->get_one('search_index',array('m'=>$data['m'],'keyid'=>$data['keyid'],'data_id'=>$data['data_id']))) {
            $formdata = array();
            $data_key = '';
            $this->db->update('search_index',array('m'=>$data['m'],'full_title'=>$data['full_title'],'tags_data'=>$data['tags_data'],'data_key'=>$data_key,'index_time'=>SYS_TIME),array('id'=>$r['id']));
            $formdata['title'] = $data['title'];
            $formdata['remark'] = $data['remark'];
            $formdata['url'] = $data['url'];
            $formdata['thumb'] = $data['thumb'];
            $formdata['updatetime'] = $data['updatetime'];
            $this->db->update('search_result',$formdata,array('id'=>$r['id']));
        } else {
            $this->add($data);
        }
    }

    /**
     * 分词
     * @param $data
     */
    private function segment($data) {

        return '';
    }

}