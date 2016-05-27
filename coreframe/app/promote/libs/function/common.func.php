<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 生成动态广告链接地址
 */
function stat_url($pid,$id) {
    return WEBURL.'index.php?m=promote&v=stat&pid='.$pid.'&id='.$id;
}