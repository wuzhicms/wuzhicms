<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 采集内容
 */
//Example: php /workspace/wwwroot/wuzhicms_v2/coreframe/crontab.php order doit
/*
/Applications/XAMPP/bin/php-5.4.31 /workspace/wwwroot/project/wuzhicms_v2/coreframe/crontab.php order doit
*/

$db=load_class('db');

//2->3
//72小时，失效
$posttime = SYS_TIME-86400*3;
$where = "`status`=2 AND `post_time`<$posttime";
$db->update('order_goods', array('status'=>3), $where);
exit('ok');