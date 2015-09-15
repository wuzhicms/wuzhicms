<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 内容搜索
 */
class search{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 公共模型搜索
     */
    public function init() {

        $siteconfigs = $this->siteconfigs;
        $seo_title = '搜索 - '.$siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $keywords = sql_replace($GLOBALS['keywords']);
        $starttime = isset($GLOBALS['starttime']) ? intval($GLOBALS['starttime']) : 0;
        $runtime = '';

        $history_result = array();
        $search_cookie = get_cookie('search_cookie');
        $history_result = explode('||',$search_cookie);

        $models = get_cache('model_content','model');
        $modelid = isset($GLOBALS['modelid']) ? intval($GLOBALS['modelid']) : 0;
        if($keywords) {
            if($starttime) {
                $stime = SYS_TIME-$starttime*86400;
                $where = "`status`=9 AND (`addtime`>$stime AND `title` LIKE '%$keywords%') or (`addtime`>$stime AND `remark` LIKE '%$keywords%')";
            } else {
                $where = "`status`=9 AND `title` LIKE '%$keywords%' or `remark` LIKE '%$keywords%'";
            }
            $page = intval($GLOBALS['page']);

            if($modelid) {
                $tablename = $models[$modelid]['master_table'];
            } else {
                $tablename = 'content_share';
            }
            $result = $this->db->get_list($tablename, $where, '*', 0, 20, $page,'id DESC');
            $result_pages = $this->db->pages;
            $total_number = $this->db->number;

            if($search_cookie) {
                if(!in_array($keywords,$history_result)) {
                    $search_cookie = $keywords."||".$search_cookie;
                }
            } else {
                $search_cookie = $keywords;
            }
            set_cookie('search_cookie',$search_cookie,SYS_TIME+86400*30);
            $_endTime = microtime(true);

            $runtime = $_endTime-$GLOBALS['_startTime'];
            $runtime = sprintf("%.3f",$runtime);

        } else {
            $result = array();
            $page = 0;
            $result_pages = '';
            $total_number = 0;
            $runtime = '0.00001';
        }
        if($search_cookie) {

            if(count($history_result)>10) {
                array_pop($history_result);
                $search_cookie = implode('||',$history_result);
                set_cookie('search_cookie',$search_cookie,SYS_TIME+86400*30);
            }
        }
        include T('content','search',TPLID);
	}
}
?>