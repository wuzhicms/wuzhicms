<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
//字段格式化处理函数集合

//结果转换数组中的值
function r2id($str,$arr) {
    return array_search($str,$arr);
}

/**
 * 一串字符中，查找出现的字符
 *
 * @param $str
 * @param $arr
 */
function group_search_string($str,$arr) {
    $tmp = array('no_value');
    foreach($arr as $key=>$value) {
        if(strpos($str,$value)===false) continue;
        $tmp[] = $key;
    }
    return $tmp;
}

/**
 * 从字符串中找出图片下载地址，并下载
 * @param $str
 * @param string $baseurl
 */
function get_image_in_string($str,$baseurl = '') {
    //alt="北京军区医协会大兴亦庄体检中心" src="/update/1380187086l537268028.jpg"
    preg_match('/src=[\'"]?([^\'" ]*)[\'"]?/i', $str, $match_out);
    if($match_out[1]) {
        $img = fillurl($match_out[1],$baseurl);
        $attachment = load_class('attachment','attachment');
        $attachment->set_water_mark(false);
        $newimg = $attachment->get_remote_file($img);
        return $newimg;
    }
}
/**
 * 从字符串中找出图片多组下载地址，并下载
 * @param $str
 * @param string $baseurl
 */

function get_more_image($str,$baseurl = '') {
    preg_match_all('/src=[\'"]?([^\'" ]*)[\'"]?/i', $str, $match_out);
    if(!empty($match_out[1])) {
        $match_out[1] = array_unique($match_out[1]);
        $attachment = load_class('attachment','attachment');
        $attachment->set_water_mark(false);
        $newimg = array();
        foreach($match_out[1] as $_m) {
            $img = fillurl($_m,$baseurl);
            $newimg[]['url'] = $attachment->get_remote_file($img);
        }
        return $newimg;
    }
}