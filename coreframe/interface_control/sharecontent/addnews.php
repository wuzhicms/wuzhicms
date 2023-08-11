<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2016 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
//添加共享内容
//放到专题管理

defined('INTERFACE_CONTROL') or exit('Undefined INTERFACE_CONTROL');
$channelid = intval($GLOBALS['channelid']);
if(!$channelid) exit_json(array('code'=>101));

//验证token
$server_sharecontent = get_config('server_sharecontent');
$__token = $GLOBALS['__token'];
$__key = $GLOBALS['__key'];
$md5token = md5($__key.$channelid.$server_sharecontent[$channelid]['secretkey']);
if($__key>SYS_TIME+300 || $__key<SYS_TIME-300) {
	echo json_encode(array('code'=>102,'msg'=>'token expire'));
}
if($md5token!=$__token) {
	exit_json(array('code'=>103,'message'=>'token error'));
}

$sharedb = new WUZHI_db('server_mysql_share');

$formdata = array();
$formdata['channelname'] = $server_sharecontent[$channelid]['channelname'];
$formdata['channelid'] = $channelid;
$formdata['id'] = intval($GLOBALS['id']);
$formdata['cid'] = intval($GLOBALS['cid']);
$formdata['catname'] = sql_replace($GLOBALS['catname']);
$formdata['title'] = safe_htm($GLOBALS['title']);
$formdata['thumb'] = $GLOBALS['thumb'];
$formdata['keywords'] = $GLOBALS['keywords'];
$formdata['remark'] = $GLOBALS['remark'];
$formdata['url'] = $GLOBALS['url'];
$formdata['url'] = $GLOBALS['url'];
$formdata['modelid'] = $GLOBALS['modelid'];
$formdata['publisher'] = $GLOBALS['publisher'];
$formdata['addtime'] = $GLOBALS['addtime'];
$formdata['updatetime'] = $GLOBALS['updatetime'];

$sid = $sharedb->insert('share_item', $formdata);
$sharedb->insert('share_item_data', array('sid'=>$sid,'content'=>$GLOBALS['content']));

exit_json(array('code' => 200, 'message' => 'add success'));