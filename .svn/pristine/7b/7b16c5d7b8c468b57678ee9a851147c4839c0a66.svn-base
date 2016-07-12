<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 后台模版选择
 */
function select_template($m) {
    static $_project;
    if(isset($_project[$m])) return $_project[$m];
    $tmp = glob(COREFRAME_ROOT.'templates/*');
    $projects = array();
    foreach($tmp as $project) {
        if(is_dir($project)) {
            $GLOBALS['tplfiles'] = '';
            $dirname = basename($project);
            $projects[$dirname] = globs($project.'/'.$m.'/');
        }
    }
    $_project[$m] = $projects;
    return $projects;
}

/**
 * 递归所有.html文件和目录
 */
function globs($dir) {
    $GLOBALS['tplfiles'] = isset($GLOBALS['tplfiles']) ? $GLOBALS['tplfiles'] : '';
    $project_tmp = glob($dir.'*');
    //$files = array();
    foreach($project_tmp as $_tmp) {
        if(is_dir($_tmp)) {
            if(basename($_tmp)=='mobile' || basename($_tmp)=='package') continue;
            globs($_tmp.'/');
        } else {
            $GLOBALS['tplfiles'][] = str_replace($dir,'',$_tmp);
        }
    }
    return $GLOBALS['tplfiles'];
}
