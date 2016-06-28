<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_message_api {

  
    public function __construct() {
        $this->db = load_class('db');
    }
    public function send_sys($username,$title,$content) {
        $r = $this->db->get_one('member', array('username' => $username),'uid');
        $touid = $r['uid'];

        $formdata = array();
        $formdata['touid'] = $touid;
        $formdata['title'] = $title;
        $formdata['content'] = $content;
        $formdata['msgtype'] = 1;
        $formdata['addtime'] = SYS_TIME;
        $this->db->insert('message', $formdata);
    }
}
?>