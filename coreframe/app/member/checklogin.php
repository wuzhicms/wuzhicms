<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 检查会员是否登录
 */
class checklogin{
	public function __construct() {
    }

    /**
     * 检查
     */
    public function check() {
        $_uid = get_cookie('_uid');
        if($_uid) {
            exit('1');
        } else {
            exit('0');
        }
    }
}
?>