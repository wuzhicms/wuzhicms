<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 栏目缓存更新
 */
class WUZHI_category_cache{
    public function __construct() {
    }
    /**
     * 更新内容模块栏目缓存
     * @return bool
     */
    public function cache_all() {
        $db = load_class('db');
        $result = $db->get_list('category', array('keyid'=>'content'), '*', 0, 10000,0,'sort ASC,cid ASC');
        //所有内容模块栏目缓存，仅缓存name，url，cid，pid，child
        $all = array();
        foreach($result as $v) {
            $tmp = array();
            $tmp['name'] = $v['name'];
            $tmp['pid'] = $v['pid'];
            $tmp['child'] = $v['child'];
            $tmp['modelid'] = $v['modelid'];
            $tmp['ismenu'] = $v['ismenu'];
            $tmp['catdir'] = $v['catdir'];
            $tmp['url'] = $v['url'];
            $tmp['showloop'] = $v['showloop'];
            $tmp['type'] = $v['type'];
            $tmp['showhtml'] = $v['showhtml'];
            $tmp['listhtml'] = $v['listhtml'];
            //$tmp['language'] = $v['language'];
            $tmp['siteid'] = $v['siteid'];
            $tmp['icon'] = $v['icon'];
            if($v['domain']) $tmp['domain'] = $v['domain'];
            $all[$v['cid']] = $tmp;
            set_cache('category_'.$v['cid'],$v,'content');

        }
        set_cache('category',$all,'content');
        return true;
	}

}