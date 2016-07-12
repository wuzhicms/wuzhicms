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
 * 体检中心
 */
class mec {
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 体检中心列表
     */
    public function listing() {
        $city = $GLOBALS['city'];

        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $glpp = isset($GLOBALS['glpp']) ? intval($GLOBALS['glpp']) : 0;
        $jibie = isset($GLOBALS['jibie']) ? intval($GLOBALS['jibie']) : 0;
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

//RewriteRule ^([a-z]+)/([0-9]+)-([0-9]+)-([0-9_]+)-([0-9]+)-([0-9_]+).html /mec/index.php?v=listing&city=$1&glpp=$2&area=$3&tese=$4&&sort=$5&page=$6
        $sort = isset($GLOBALS['sort']) ? $GLOBALS['sort'] : 0;
        $orderby_arr = array('sort DESC,id DESC','hits DESC','favorite_nums DESC','avg_price DESC','avg_price ASC');
        $orderby = $orderby_arr[$sort];

        $page = isset($GLOBALS['page']) ? $GLOBALS['page'] : 1;
        $page = max($page,1);
        $listurl = '/mec/'.$city.'/'.$glpp.'-'.$area.'-'.$tese.'-'.$sort.'-'.$jibie.'-'.$page.'.html';

        $_POST['page_urlrule'] = '/mec/{$city}/{$glpp}-{$area}-{$tese}-{$sort}-{$jibie}-{$page}.html';
        $page_fields = array();
        $page_fields['glpp'] = $glpp;
        $page_fields['city'] = $city;
        $page_fields['area'] = $area;
        $page_fields['tese'] = $tese;
        $page_fields['jibie'] = $jibie;
        $page_fields['sort'] = 0;
        $_POST['page_fields'] = $page_fields;

        $where = '';
        $where = "`cid`='$cityid'";
        if($glpp) {
            $where .= " AND `glpp`='$glpp'";
        }
        if($jibie) {
            $where .= " AND `jibie`='$jibie'";
        }
        if(isset($GLOBALS['mecname']) && !empty($GLOBALS['mecname'])) {
            $mecname = sql_replace($GLOBALS['mecname']);
            $where .= " AND `title` LIKE '%$mecname%'";
        } else {
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
        }
        include T('content','list-mec',TPLID);
	}
}
?>