<?php
set_time_limit(0);
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 逐个通过审批，将status设置为9
 */
//Example: php /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin chatroom
//nohup php -f /workspace/wwwroot/project/nvshenyue/coreframe/crontab.php weixin chatroom > chatroomlog.txt 2>&1 &

$db = load_class('db');
while(1) {
    ob_end_clean();
    $r = $db->get_one('chatroom', array('status' => 1),'*', 0, 'id ASC');
    $result = $db->get_list('chatroom', "`status`='7'", '*', 0, 25,0,'id ASC');
    foreach($result as $rs) {
        if($r['id'] && $rs['id']>$r['id']) break;
        $db->update('chatroom', array('status'=>9), array('id' => $rs['id']));
        echo $rs['id']."\r\n";
    }
    echo "running...\r\n";
    sleep(2);
}
