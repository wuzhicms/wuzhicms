<?php
/**
 * 获取投稿状态
 */
define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$db = load_class('db');
$result_arr = $db->get_list('tougao', array('status'=>1), '*', 0, 50, 0);
$result = array();
foreach($result_arr as $r) {
	$tmp = array();
	$tmp['id'] = $r['id'];
	$tmp['publisher'] = $r['publisher'];
	$tmp['title'] = $r['title'];
	$tmp['content'] = $r['content'];
	$tmp['addtime'] = $r['addtime'];
	$tmp['updatetime'] = $r['updatetime'];
	$result[] = $tmp;
}
echo json_encode(array('code'=>'100','lists'=>$result),true);