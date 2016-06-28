<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容超时自动失效
 */
//Example: php /workspace/wwwroot/project/cheyouwang/coreframe/crontab.php order doit
/*
/Applications/XAMPP/bin/php-5.4.31 /workspace/wwwroot/project/wuzhicms_v2/coreframe/crontab.php order doit
*/

$db = load_class('db');

//24小时
$posttime = SYS_TIME-86400;
$where = "`status`=6 AND `addtime`<$posttime";
$db->update('pay', array('status'=>4), $where);
echo "ok \r\n";