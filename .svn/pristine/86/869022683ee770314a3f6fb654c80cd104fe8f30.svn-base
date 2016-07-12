<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 设置web_config
 * @param $key 配置项
 * @param $value 值
 * @return string
 */
function set_web_config($key,$value) {
    if($key=='') return '-1';
    if(is_writable(WWW_ROOT.'configs/web_config.php')) {

        $res = file_get_contents(WWW_ROOT.'configs/web_config.php');
        //define('SUPPORT_MOBILE',1);//0，不支持移动页面，1，自动识别，动态，伪静态下可用，静态页面通过
        $res = preg_replace("/define\('$key',([0-9])\);/is","define('$key',$value);",$res);
        file_put_contents(WWW_ROOT.'configs/web_config.php',$res);
    } else {
        MSG("文件不可写：".WWW_ROOT.'configs/web_config.php');
    }
}

/**
 * 后台列表标题样颜色
 * @param $css
 * @return array
 */
function style($css) {
    if(empty($css)) {
        return array('color'=>'','font-weight'=>'','font-size'=>'');
    }
    $css = explode(';',$css);
    foreach($css as $cs) {
        $arr = explode(':',$cs);
        $style[$arr[0]] = $arr[1];
    }
    return $style;
}
