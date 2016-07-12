<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 刷新微信 access_token 有效期目前为2个小时,需定时刷新，重复获取将导致上次获取的access_token失效。
 */
//Example: php /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin token

load_function('weixin','weixin');
$token = make_token();
print_r($token);
