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
        $this->siteconfigs = get_cache('siteconfigs_1');
        $this->db = load_class('db');
        $this->open_es_search = 1;//是否开启es搜索
	}

    /**
     * 公共模型搜索
     */
    public function init() {
        $this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;

        $siteconfigs = $this->siteconfigs;
        $seo_title = '搜索 - '.$siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $keywords = trim(sql_replace($GLOBALS['keywords']));
        $starttime = isset($GLOBALS['starttime']) ? intval($GLOBALS['starttime']) : 0;
        $runtime = '';

        $history_result = array();
        $search_cookie = get_cookie('search_cookie');
        $history_result = explode('||',$search_cookie);

        $models = get_cache('model_content','model');
        $modelid = isset($GLOBALS['modelid']) ? intval($GLOBALS['modelid']) : 0;
        $searchtype = isset($GLOBALS['searchtype']) ? intval($GLOBALS['searchtype']) : 0;
        $search_typename = '全站';
        if($modelid) {
            $search_typename = $models[$modelid]['name'];
        }

        if($keywords) {
            $stime      = SYS_TIME-$starttime*86400;
            $page       = intval($GLOBALS['page']);
            $parameter  = $GLOBALS['parameter'];
            $pagesize   = 20;

            if($this->open_es_search) {
                //es 搜索
                $es_client = load_class('es_client');
                if ($parameter == 'zcfg')
                        $es_client->index = 'zcfg';
                $datas = $es_client->search($keywords,$page,$pagesize);
                $result = [];
                $total_number = $datas['total']['value'];
                if($total_number>0) {
                    foreach ($datas['hits'] as $data) {
                        $result[] = $data['_source'];
                    }
                }
                $result_pages = pages($total_number, $page, $pagesize);
            } else {
                if($starttime) {
                    $where = "`status`=9 AND (`addtime`>$stime AND `title` LIKE '%$keywords%') or (`addtime`>$stime AND `remark` LIKE '%$keywords%')";
                } else {
                    $where = "`status`=9 AND (`title` LIKE '%$keywords%' or `remark` LIKE '%$keywords%')";
                }
                if($modelid) {
                    $tablename = $models[$modelid]['master_table'];
                    if($tablename=='') MSG('参数错误!');
                    if($tablename=='content_share') {
                        $where = "`modelid`='$modelid' AND ".$where;
                    }
                } else {
                    $tablename = 'content_share';
                }
                //if(LANGUAGE=='en') $tablename .= '_en';

                $result = $this->db->get_list($tablename, $where, '*', 0, 20, $page,'id DESC');
                $result_pages = $this->db->pages;
                $total_number = $this->db->number;
            }


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
        $request_uri = $_SERVER["REQUEST_URI"];
        if(ENABLE_SITES) {
            if($keywords=='') {
                include T('content','search',TPLID.'-'.$this->siteid);
            } else {
                include T('content','search_result',TPLID.'-'.$this->siteid);
            }
        } else {
            /*if($keywords=='') {
                include T('content','search',TPLID);
            } else {
                include T('content','search_result',TPLID);
            }*/
            include T('content','search',TPLID);
        }

	}
}
?>