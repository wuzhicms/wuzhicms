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
 * 会员的个人主页
 */
class home {
    private $siteconfigs;
	private $memberinfo;
	private $homeurl;
	private $homeurl2;
	private $tplid = 'default';
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
		$domain = $GLOBALS['domain'];
		if(preg_match('/[^a-z0-9]+/',$domain)) {
			MSG('您要访问的页面不存在');
		}

		$this->memberinfo = $this->db->get_one('member', array('domain' => $domain));
		if(!$this->memberinfo) MSG('您要访问的页面不存在！');

		$this->homeurl = strpos($this->memberinfo['domain'],'://')===false ? WEBURL.LANGUAGE.$this->memberinfo['domain'] : $this->memberinfo['domain'];
		$this->homeurl2 = LANGUAGE=='en' ? '/zh/'.$this->memberinfo['domain'].'/' : '/'.$this->memberinfo['domain'].'/';

	}

    /**
     * 首页
     */
    public function index() {
		$companyid = $this->companyid;
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
		$memberinfo = $this->memberinfo;
		$_uid = get_cookie('_uid');
		//print_r($memberinfo);
		$uid = $memberinfo['uid'];
		$tplid = $this->tplid;
		$homeurl = $this->homeurl;
		$models = get_cache('model_member','model');
		$modelid = $memberinfo['modelid'];
		//	判断是否有模型id参数

//print_r($models);
		$modelids = explode(',',$modelid);
		$is_load = false;
		$datas = array();
		foreach($modelids as $modelid) {
			if($is_load==false) {
				require get_cache_path('member_format','model');
				$form_format = new form_format($modelid);
				$is_load = true;
			}

			$form_format->fields = get_cache('field_'.$modelid,'model');
			if(LANGUAGE=='en') {
				$tmp = $this->db->get_one($models[$modelid]['attr_table'].'_en', array('uid' => $uid));
			} else {
				$tmp = $this->db->get_one($models[$modelid]['attr_table'], array('uid' => $uid));
			}
			if(!empty($tmp)) {
				$tmp = $form_format->execute($tmp);
				$datas = array_merge($tmp,$datas);
			}

		}
		$show_header = $show_footer = 0;
		$tagheader = str_replace('、',',',$datas['tagheader']['data']);
		$tagheader = trim($tagheader);
		$tagheader = trim($tagheader,',');
		if($tagheader) {

			$tagheaders = explode(',',$tagheader);
			$tagheaders = array_map('trim',$tagheaders);

			if(in_array('Header',$tagheaders)) {
				$show_header = 1;
			}
			if(in_array('Footer',$tagheaders)) {
				$show_footer = 1;
			}
		}
		//echo $uid;
		//print_r($datas);

		$request_uri = $this->homeurl2;
		$language_set = 1;
		include T('member_homepage/'.$tplid,'index','iiis-1');
	}
}
?>