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
 * 团购
 */
class tuan {
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}
    /**
     * 个人团购首页
     */
    public function gr_index() {
        $tuanindex = 1;
        $city = $GLOBALS['city'];

        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $cid = intval($GLOBALS['cid']);
        $setting_config = get_config('setting_config');
        foreach($categorys as $cid=>$rs) {
            if($rs['catdir']==$city) {
                $cityid = $cid;
                set_cookie('cityname',$rs['name'],SYS_TIME+86400*7);
                set_cookie('cityid',$cityid,SYS_TIME+86400*7);
                $cityname = $rs['name'];
                break;
            }
        }
        $setting_config = get_config('setting_config');
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        if($tese && isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } elseif($tese) {
            $tese_arr = explode('_', $tese);
        } elseif(isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } else {
            $tese_arr = array();
        }
        $price = isset($GLOBALS['price']) ? $GLOBALS['price'] : 0;
        $forgroup = isset($GLOBALS['forgroup']) ? $GLOBALS['forgroup'] : 0;
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        $listurl = 'index.php?f=tuan&v=index&type=1&cityid={$cityid}&cid={$cid}&forgroup={$forgroup}&price={$price}&area={$area}&tese={$tese}&&sort={$sort}&page={$page}';

        $_POST['page_urlrule'] = $listurl;
        $page_fields = array();
        $page_fields['cid'] = $cid;
        $page_fields['pinpai'] = 2;
        $page_fields['cityid'] = $cityid;
        $page_fields['forgroup'] = $forgroup;
        $page_fields['type'] = 1;
        $page_fields['price'] = $price;
        $page_fields['area'] = 5;
        $page_fields['tese'] = $tese;
        $page_fields['sort'] = 0;
        $_POST['page_fields'] = $page_fields;

        include T('content','index-gr-tuan',TPLID);
    }
    /**
     * 个人团购列表
     */
    public function gr_listing() {
        $city = $GLOBALS['city'];

        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $cityid = isset($GLOBALS['cityid']) ? $GLOBALS['cityid'] : get_cookie('cityid');
        $setting_config = get_config('setting_config');

        $price = isset($GLOBALS['price']) ? $GLOBALS['price'] : 0;
        $area = isset($GLOBALS['area']) ? $GLOBALS['area'] : 0;
        $forgroup = isset($GLOBALS['forgroup']) ? $GLOBALS['forgroup'] : 0;
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        if($tese && isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } elseif($tese) {
            $tese_arr = explode('_', $tese);
        } elseif(isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } else {
            $tese_arr = array();
        }

        $sort = isset($GLOBALS['sort']) ? $GLOBALS['sort'] : 0;
        $page = isset($GLOBALS['page']) ? $GLOBALS['page'] : 1;
        $listurl = '/tuan/'.$city.'/'.$cid.'-'.$forgroup.'-'.$price.'-'.$area.'-'.$tese.'-'.$sort.'-'.$page.'.html';

        $_POST['page_urlrule'] = '/tuan/{$city}/{$cid}-{$forgroup}-{$price}-{$area}-{$tese}-{$sort}-{$page}.html';
        $page_fields = array();
        $page_fields['cid'] = $cid;
        $page_fields['city'] = $city;
        $page_fields['forgroup'] = $forgroup;
        $page_fields['price'] = $price;
        $page_fields['area'] = $area;
        $page_fields['tese'] = $tese;
        $page_fields['sort'] = 0;
        $_POST['page_fields'] = $page_fields;

        $where = '';
        if($cid) {
            $where = "`cid`='$cid' AND `type`=1";
        } else {
            $where = "`type`=1";
        }
        $where .= $where ? " AND (`citys` LIKE '%,$cityid,%' OR `citys` LIKE ',0,%')" : "(`citys` LIKE '%,$cityid,%' OR `citys` LIKE ',0,%')";
        if($forgroup) {
            $where .= " AND `forgroup` LIKE '%$forgroup%'";
        }
        if($price) {
            $sqlprice = explode('_',$price);
            $where .= " AND `price`>'$sqlprice[0]'";
            if($sqlprice[1]) $where .= " AND `price`<'$sqlprice[1]'";
        }
        if($area) {
            $where .= " AND `areaid`='$area'";
        }
        if($tese_arr) {
            //$where .= " AND ";
            foreach($tese_arr as $_arr) {
                $where .= " AND `fuwu` LIKE '%,$_arr,%'";
            }
            //$where = substr($where,0,-2);
        }
        //$where = "`forgroup`='$forgroup' AND `citys` LIKE '%,$cityid,%'";
        include T('content','list-gr-tuan',TPLID);
	}
    /**
     * 企业团购首页
     */
    public function qy_index() {
        $tuangouindex = 1;
        $city = $GLOBALS['city'];

        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $cid = intval($GLOBALS['cid']);
        $setting_config = get_config('setting_config');
        foreach($categorys as $cid=>$rs) {
            if($rs['catdir']==$city) {
                $cityid = $cid;
                set_cookie('cityname',$rs['name'],SYS_TIME+86400*7);
                set_cookie('cityid',$cityid,SYS_TIME+86400*7);
                $cityname = $rs['name'];
                break;
            }
        }
        $setting_config = get_config('setting_config');
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        if($tese && isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } elseif($tese) {
            $tese_arr = explode('_', $tese);
        } elseif(isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } else {
            $tese_arr = array();
        }

        $price = isset($GLOBALS['price']) ? $GLOBALS['price'] : 0;
        $forgroup = isset($GLOBALS['forgroup']) ? $GLOBALS['forgroup'] : 0;
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        $listurl = 'index.php?f=tuan&v=index&type=2&cityid={$cityid}&cid={$cid}&forgroup={$forgroup}&price={$price}&area={$area}&tese={$tese}&&sort={$sort}&page={$page}';

        $_POST['page_urlrule'] = $listurl;
        $page_fields = array();
        $page_fields['cid'] = $cid;
        $page_fields['pinpai'] = 2;
        $page_fields['cityid'] = $cityid;
        $page_fields['forgroup'] = $forgroup;
        $page_fields['type'] = 1;
        $page_fields['price'] = $price;
        $page_fields['area'] = 5;
        $page_fields['tese'] = $tese;
        $page_fields['sort'] = 0;
        $_POST['page_fields'] = $page_fields;

        include T('content','index-qy-tuan',TPLID);
    }
    /**
     * 企业团购列表
     */
    public function qy_listing() {
        $city = $GLOBALS['city'];

        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $cityid = isset($GLOBALS['cityid']) ? $GLOBALS['cityid'] : get_cookie('cityid');
        $setting_config = get_config('setting_config');

        $price = isset($GLOBALS['price']) ? $GLOBALS['price'] : 0;
        $area = isset($GLOBALS['area']) ? $GLOBALS['area'] : 0;
        $forgroup = isset($GLOBALS['forgroup']) ? $GLOBALS['forgroup'] : 0;
        $tese = isset($GLOBALS['tese']) ? $GLOBALS['tese'] : 0;
        if($tese && isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } elseif($tese) {
            $tese_arr = explode('_', $tese);
        } elseif(isset($GLOBALS['newtese'])) {
            $tese_arr = $GLOBALS['newtese'];
            $tese = implode('_',$tese_arr);
        } else {
            $tese_arr = array();
        }

        $sort = isset($GLOBALS['sort']) ? $GLOBALS['sort'] : 0;
        $page = isset($GLOBALS['page']) ? $GLOBALS['page'] : 1;
        $listurl = '/tuangou/'.$city.'/'.$cid.'-'.$forgroup.'-'.$price.'-'.$area.'-'.$tese.'-'.$sort.'-'.$page.'.html';

        $_POST['page_urlrule'] = '/tuangou/{$city}/{$cid}-{$forgroup}-{$price}-{$area}-{$tese}-{$sort}-{$page}.html';
        $page_fields = array();
        $page_fields['cid'] = $cid;
        $page_fields['city'] = $city;
        $page_fields['forgroup'] = $forgroup;
        $page_fields['price'] = $price;
        $page_fields['area'] = $area;
        $page_fields['tese'] = $tese;
        $page_fields['sort'] = 0;
        $_POST['page_fields'] = $page_fields;

        $where = '';
        if($cid) {
            $where = "`cid`='$cid' AND `type`=2";
        } else {
            $where = "`type`=2";
        }
        $where .= $where ? " AND (`citys` LIKE '%,$cityid,%' OR `citys` LIKE ',0,%')" : "(`citys` LIKE '%,$cityid,%' OR `citys` LIKE ',0,%')";
        if($forgroup) {
            $where .= " AND `forgroup` LIKE '%$forgroup%'";
        }
        if($price) {
            $sqlprice = explode('_',$price);
            $where .= " AND `price`>'$sqlprice[0]'";
            if($sqlprice[1]) $where .= " AND `price`<'$sqlprice[1]'";
        }
        if($area) {
            $where .= " AND `areaid`='$area'";
        }
        if($tese_arr) {
            //$where .= " AND ";
            foreach($tese_arr as $_arr) {
                $where .= " AND `fuwu` LIKE '%,$_arr,%'";
            }
            //$where = substr($where,0,-2);
        }
        //$where = "`forgroup`='$forgroup' AND `citys` LIKE '%,$cityid,%'";
        include T('content','list-qy-tuan',TPLID);
    }
}
?>