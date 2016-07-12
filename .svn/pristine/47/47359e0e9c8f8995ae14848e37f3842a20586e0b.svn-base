<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: jiucai <zhaidw@jiucai.org>
// +----------------------------------------------------------------------
class WUZHI_searchapi {
	private $db;
    private $segment;

	public function __construct() {
        $this->db = load_class('db');
        $this->segment = load_class('segment',M);
	}
    public function add($data) {
        //data=array('data_id'=>'c1','title'=>'标题','imageurl'=>'http://a.jpg','contenturl'=>'http://www.q.com','updatetime'=>'1111111','remark'=>'简介','data'=>'这个是查询的结果')
        //insert
        $formdata = array();
        $data_key = $this->segment($data['data']);
        $formdata['id'] = $this->db->insert('search_index',array('m'=>$data['m'],'keyid'=>$data['keyid'],'data_id'=>$data['data_id'],'full_title'=>$data['full_title'],'data_key'=>$data_key,'updatetime'=>$data['updatetime']));
        $formdata['title'] = $data['title'];
        $formdata['remark'] = $data['remark'];
        $formdata['url'] = $data['url'];
        $formdata['thumb'] = $data['thumb'];
        $formdata['updatetime'] = $data['updatetime'];
        $this->db->insert('search_result',$formdata);
        return $formdata['id'];
    }
	public function update($data) {
        if($r = $this->db->get_one('search_index',array('keyid'=>$data['keyid'],'data_id'=>$data['data_id']))) {
            $formdata = array();
            $data_key = $this->segment($data['data']);
            $this->db->update('search_index',array('m'=>$data['m'],'full_title'=>$data['full_title'],'data_key'=>$data_key,'updatetime'=>$data['updatetime']),array('keyid'=>$data['keyid'],'data_id'=>$data['data_id']));
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
        $keywords = $this->segment->split_result($data);
        return $keywords;
    }

}