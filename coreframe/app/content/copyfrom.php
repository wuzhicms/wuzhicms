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
 * 来源内容聚合
 */
class copyfrom{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     *
     */
    public function init()
    {
        $id = intval($GLOBALS['id']);
        $siteid = intval($GLOBALS['siteid']);
        $res = $this->db->get_one('copyfrom', array('fromid' => $id));
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $cids = array();
        foreach($categorys as $cid=>$r) {
            if($r['siteid']==$siteid) {
                $cids[] = $cid;
            }
        }
        if(!empty($cids)) {
            $cids = implode(',',$cids);
            $where = "`copyfrom`='".$res['fromid']."' AND `status`=9 AND `cid` IN ($cids)";
            $rs = $this->db->get_list('content_share', array('copyfrom'=>$id), '*', 0, 20, 0, 'id DESC');
        } else {
            MSG('参数错误');
        }

        $rs = $this->db->get_list('content_share', $where, '*', 0, 100, 0, 'id DESC');
        include T('content', 'copyfrom', TPLID);
    }
}
?>