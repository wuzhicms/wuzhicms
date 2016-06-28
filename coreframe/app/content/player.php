<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 新窗口播放
 */
class player{
	private $siteconfigs;
	public function __construct() {
		$this->siteconfigs = get_cache('siteconfigs');
		$this->db = load_class('db');
		$this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;
	}

	public function youku() {
		//站点信息
		$siteid = $this->siteid;
		$siteconfigs = $this->siteconfigs;
		//栏目信息
		$categorys = get_cache('category','content');
		$title = urldecode($GLOBALS['title']);
		$title = strip_tags($title);
		$play_code = $GLOBALS['code'];
		$cid = intval($GLOBALS['cid']);
		$id = intval($GLOBALS['id']);
		//print_r($GLOBALS['token']);
		$token = md5($play_code.$cid.$id._KEY);
		if($token!=$GLOBALS['token']) MSG('视频不存在!');
		
		include T('content','player_youku',TPLID);
	}

	public function tudou() {
		//站点信息
		$siteid = $this->siteid;
		$siteconfigs = $this->siteconfigs;
		//栏目信息
		$categorys = get_cache('category','content');
		$title = urldecode($GLOBALS['title']);
		$title = strip_tags($title);
		
		$play_type = intval($GLOBALS['type']);
		$play_code = $GLOBALS['code'];
		$play_lcode = $GLOBALS['lcode'];

		$cid = intval($GLOBALS['cid']);
		$id = intval($GLOBALS['id']);
		//print_r($GLOBALS['token']);
		$token = md5($play_code.$cid.$id._KEY);
		if($token!=$GLOBALS['token']) MSG('视频不存在!');

		include T('content','player_tudou',TPLID);
	}
}
?>