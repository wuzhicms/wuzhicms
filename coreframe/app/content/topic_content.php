<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 相关内容显示
 */
class topic_content{
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    public function manage() {
        $where = '';
        $cid = intval($GLOBALS['cid']);
		if(isset($GLOBALS['submit'])) {
			$tid = intval($GLOBALS['form']['tid']);
			if($tid==0) {
				MSG('<script>var dialog = top.dialog.get(window);dialog.close("0~").remove();</script>');
			}
			$kid2 = $GLOBALS['form']['kid2'];
			$formdata = array();
			$formdata['tid'] = $tid;
			$formdata['kid2'] = $kid2;
			$topic_data = $this->db->get_one('topic', array('tid' => $tid));
			$kind_data = $this->db->get_one('kind', array('kid' => $topic_data['kid']));
			$kind_data2 = $this->db->get_one('kind', array('kid' => $kid2));

			$formdata['kid1'] = $kind_data['kid'];
			$formdata['kid1name'] = $kind_data['name'];
			$formdata['kid2name'] = $kind_data2['name'];

			$tcid = $this->db->insert('topic_content', $formdata);

			$string = $tcid.'~【'.$kind_data['name'];
			if($kid2) $string .= ' - '.$kind_data2['name'];
			$string .= '】'.$topic_data['name'];
			MSG('<script>var dialog = top.dialog.get(window);dialog.close("'.$string.'").remove();</script>');
		} else {
			$show_dialog = 1;
			$form = load_class('form');
			$siteid = get_cookie('siteid');
			$result = $this->db->get_list('topic', array('status'=>9,'upgrade_status'=>9), '*', 0, 100, 0, 'tid DESC');
			$options = key_value($result,'tid','name');
			//print_r($options);
			//array_unshift($options,'请选择');
			include T('content','topic_content_manage');
		}

    }

}