<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

load_function('common','attachment');
/**
 * 附件上传
 */
class imagecut {
    function __construct()
    {
        $this->db = load_class('db');
        $this->userkeys = get_cookie('userkeys');
        if(empty($this->userkeys)) {
            $this->userkeys = substr(md5(uniqid()),5,8);
            set_cookie('userkeys',$this->userkeys);
        }
    }

    function init() {
		if(isset($GLOBALS['imgBase64'])) {
			$_username = get_cookie('_username');

			$wz_name = get_cookie('username');
			if($wz_name!='') {
				$_username = $wz_name;
			}
			$ext = $GLOBALS['ext'];
			$token = $GLOBALS['token'];
			if($ext=='' || md5($ext._KEY)!=$token) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "token验证失败，不允许上传文件"}, "id" : "id"}');
			}
			if($_username!='') {
				$mr = $this->db->get_one('member', array('username' => $_username),'uid');
				if(!$mr) {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
				}
			} else {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Not allow guest upload."}, "id" : "id"}');
			}

			$base64 = $GLOBALS['imgBase64'];
			$base64_body = substr(strstr($base64,','),1);
			$img = base64_decode($base64_body);
			$filepath = date('Y/m/d/');
			$path_root = ATTACHMENT_ROOT.$filepath;
			if(!file_exists($path_root)){
				mkdir($path_root,0777,true);
			}
			$rand_str = random_string('diy', 6,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
			$files = date('YmdHis').$rand_str.'.jpg';			file_put_contents($path_root.$files, $img);
			die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.ATTACHMENT_URL.$filepath.$files.'", "id" : "1", "filename" : "name" }');

		} else {
			if(!empty($GLOBALS['imgurl'])) {
				$imgurl = urldecode($GLOBALS['imgurl']);
			}
			include T('attachment','imagecut');
		}
	}

}
?>