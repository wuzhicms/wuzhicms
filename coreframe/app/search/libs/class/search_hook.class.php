<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 钩子
 */

class WUZHI_search_hook {
	function __construct() {
		$this->db = load_class('db');
		$this->search_api = load_class('search_api','search');
	}
	function run_hook($hookid,$data = '',$attend = array()) {
		switch ($hookid) {
			case 'form_update':
				if($data['status']!=9) return '';
				$formdata = array();
				$formdata['title'] = $data['title'];
				$formdata['remark'] = $data['remark'];
				$formdata['url'] = $data['url'];
				$formdata['thumb'] = $data['thumb'];
				$formdata['updatetime'] = $data['updatetime'];
				$formdata['m'] = 'content';
				$formdata['keyid'] = $data['cid'];
				$formdata['data_id'] = $data['id'];
				$formdata['full_title'] = $formdata['title'].' '.$data['keywords'];//可以需要模糊查询的关键词都放到这里面
				$formdata['tags_data'] = $data['bq'];
				$formdata['data_key'] = '';//需要进入全文索引的字段组合到一起.

				$this->search_api->update($formdata);

				break;
		}
	}
}