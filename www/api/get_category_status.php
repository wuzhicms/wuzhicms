<?php
/**
 * 获取所属栏目是否为同一个模型
 */
define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$db = load_class('db');
$oldcid = intval($GLOBALS['oldcid']);
$cid = intval($GLOBALS['cid']);
$oldr = $db->get_one('category',array('cid' => $oldcid),'modelid');
$newr = $db->get_one('category',array('cid' => $cid),'modelid');
if($oldr['modelid']==$newr['modelid']) {
	$datas['status'] = 1;
	$where = "`pid`=$cid";
	$result = $db->get_list('category', $where, '*', 0, 20, 0, 'sort ASC,cid ASC');
	$data['haschild'] = 0;
	if(!empty($result)) {
		$datas['haschild'] = 1;
	}
	$datas['categorys'] = $result;
	echo json_encode($datas,true);
} else {
	$datas['status'] = 0;
	echo json_encode($datas,true);
}
