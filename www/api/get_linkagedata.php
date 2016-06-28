<?php
define('WWW_ROOT',substr(dirname(__FILE__), 0, -4).'/');
require '../configs/web_config.php';
require COREFRAME_ROOT.'core.php';
$lid = intval($GLOBALS['lid']);
if($lid==0) {
	echo json_encode(array('code'=>'-1'),true);
	exit;
}
$db = load_class('db');
if(isset($GLOBALS['getone'])) {
	$result = $db->get_one('linkage_data', array('lid'=>$lid));
	if(!$result) {
		$result = array();
	}
} else {
	$result = $db->get_list('linkage_data', array('pid'=>$lid), '*', 0, 100, 0, 'sort ASC,lid ASC');
	if(!$result) {
		$result = array();
	}
}
echo json_encode(array('code'=>'100','lists'=>$result),true);