<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 保存微信上传的图片信息
 */

class uploadfile{
	private $db;


	function __construct() {
		$this->db = load_class('db');

	}

    public function init() {
        $uid = get_cookie('_uid');
        if(!$uid) exit('0');
        $serverId = $GLOBALS['serverId'];
        $localId = md5($GLOBALS['localId']);
        //$r = $this->db->get_one('weixin_uploadfile', array('uid'=>$uid,'localId' => $localId));
        //if($r) exit('1');
        $formdata = array();
        $formdata['uid'] = $uid;
        $formdata['pageid'] = sql_replace($GLOBALS['pageid']);
        $formdata['localId'] = $localId;
        $formdata['serverId'] = strip_tags($serverId);
        $formdata['addtime'] = SYS_TIME;
        $formdata['ip'] = get_ip();

        $this->db->insert('weixin_uploadfile', $formdata);

        echo '1';
    }
}