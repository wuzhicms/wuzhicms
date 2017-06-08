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
 * 网站首页
 */
class index{
    private $siteconfigs;
	public function __construct() {
        $this->db = load_class('db');
        $this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;
		$this->siteconfigs = get_cache('siteconfigs_'.$this->siteid);
	}

    /**
     * 网站首页
     */
    public function init() {
        $isindex = 1;
        $siteconfigs = $this->siteconfigs;
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');

        $_uid = get_cookie('_uid');
		//城市分站信息
        $city = get_cookie('city');
        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : $city ? $city : 'xa';
		$city_config = get_config('city_config');
		$cityid = $city_config[$city]['cityid'];
		$cityname = $city_config[$city]['cityname'];

        $cookie_city = $_COOKIE[COOKIE_PRE.'city_key'];
        if($cookie_city && in_array($cookie_city,$city_config)) {
            set_cookie('city',$cookie_city);
            $city = $cookie_city;
        }

        if(ENABLE_SITES) {
            $siteid = intval($_GET['siteid']);
            if(!$siteid) $siteid = 1;
            $tplid = TPLID.'-'.$siteid;
        } else {
            $tplid = TPLID;
        }
        $language_set = 1;
        include T('content','index',$tplid);
	}

    /**
     * 内容页面
     * url规则 /index.php?v=show&cid=24&id=79
     */
    public function show() {
        $siteid = $this->siteid;
        $siteconfigs = $this->siteconfigs;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $cid = intval($GLOBALS['cid']);

        $categorys = get_cache('category','content');
        //查询数据
        if($cid) {
            $category = get_cache('category_'.$cid,'content');
            $models = get_cache('model_content','model');
            if(!$category) MSG(L('parameter_error'));
            $model_r = $models[$category['modelid']];
            if(!$model_r) MSG(L('parameter_error'));

            $master_table = $model_r['master_table'];
        } else {
            $models = get_cache('model_content','model');
            $master_table = 'content_share';
        }
        $master_table_other = $master_table;
        
        $data = $this->db->get_one($master_table,array('id'=>$id));
        if(!$data || $data['status']!=9) MSG('信息不存在或者未通过审核！');
        if(!$cid) {
            $category = get_cache('category_'.$data['cid'],'content');
            $model_r = $models[$category['modelid']];
        } elseif($data['modelid']) {
			$model_r = $models[$data['modelid']];
		}
        $_uid = get_cookie('_uid');
        //城市分站信息
        $city = get_cookie('city');
        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : $city ? $city : 'xa';
        $city_config = get_config('city_config');
        $cityid = $city_config[$city]['cityid'];
        $cityname = $city_config[$city]['cityname'];

        if($model_r['attr_table']) {
            $attr_table = $model_r['attr_table'];
            if($data['modelid']) {
                $modelid = $data['modelid'];
                $attr_table = $models[$modelid]['attr_table'];
            } else {
                $modelid = $model_r['modelid'];
            }
            $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
            if(!$attrdata) MSG('从表数据不存在');
            $data = array_merge($data,$attrdata);
        } else {
            $modelid = $model_r['modelid'];
        }
        $data_r = $data;
        $urlrule = $category['showurl'];
        if($category['showhtml']) {
            $urlrules = explode('|',$urlrule);
            $urlrule = WWW_PATH.$urlrules[0].'|'.WWW_PATH.$urlrules[1];
        }
        require get_cache_path('content_format','model');
        $form_format = new form_format($modelid);
        $data = $form_format->execute($data);

        foreach($data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
        //权限检查
		$access_authority = true;
        $_groupid = $GLOBALS['_groupid'];
        if(!empty($groups)) {
            $groups_arr = explode(',',$groups);
            if(!in_array($_groupid,$groups_arr)) {
            	//栏目访问权限和内容访问权限-提醒模式
				if(!$this->siteconfigs['access_authority']) {
					MSG('您没有访问该内容的权限');
				} else {
					$access_authority = false;
				}
            }
        } else {
            $priv_data = $this->db->get_one('member_group_priv', array('groupid' => $_groupid,'value'=>$cid,'priv'=>'view'));

            if(!$priv_data) {
				if(!$this->siteconfigs['access_authority']) {
					MSG('您没有访问该内容的权限');
				} else {
					$access_authority = false;
				}
            }
        }
        //end 权限检查

        if($template) {
			$_template = $template;
		} elseif($model_r['template'] && $category['modelid']!=$modelid) {
			$_template = $model_r['template'];
        } elseif($category['show_template']) {
            $_template = $category['show_template'];
        } elseif($model_r['template']) {
            $_template = TPLID.':'.$model_r['template'];
        } else {
            $_template = TPLID.':show';
        }
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        if($siteid!=1) {
            $project_css = TPLID.'-'.$siteid;
        }
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $original_addtime = $data_r['addtime'];

        $elasticid = elasticid($cid);
        $seo_title = $title.'_'.$category['name'].'_'.$siteconfigs['sitename'];

        $seo_keywords = !empty($keywords) && is_array($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        //上一页
        $previous_page = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
        //下一页
        $next_page = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
        //手动分页
        $CONTENT_POS = strpos($content, '_wuzhicms_page_tag_');
        if(!empty($content) && $CONTENT_POS !== false) {
            $page = max($GLOBALS['page'],1);
            $contents = array_filter(explode('_wuzhicms_page_tag_', $content));
            $pagetotal = count($contents);
            $content = $contents[$page-1];
            $tmp_year = date('Y',$original_addtime);
            $tmp_month = date('m',$original_addtime);
            $tmp_day = date('d',$original_addtime);
            $content_pages = pages($pagetotal,$page,1,$category['showurl'],array('year'=>$tmp_year,'month'=>$tmp_month,'day'=>$tmp_day,'catdir'=>$category['catdir'],'cid'=>$cid,'id'=>$id));
        } else {
            $content_pages = '';
        }
        $top_categoryid = getcategoryid($cid);
        $top_category = $categorys[$top_categoryid];
        include T('content',$_template,$project_css);
    }

    /**
     * 栏目列表
     */
    public function listing() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        //站点信息
        $siteconfigs = $this->siteconfigs;
        //栏目信息
        $categorys = get_cache('category','content');
        $category = get_cache('category_'.$cid,'content');
        if(empty($category)) MSG('栏目不存在');

        //权限检查
        $_groupid = $GLOBALS['_groupid'];
        $priv_data = $this->db->get_one('member_group_priv', array('groupid' => $_groupid,'value'=>$cid,'priv'=>'listview'));

        if(!$priv_data) {
			//栏目访问权限和内容访问权限-提醒模式
			if(!$this->siteconfigs['access_authority']) {
				MSG('您没有访问该内容的权限');
			} else {
				$access_authority = false;
			}
        }
        //end 权限检查

        $city = get_cookie('city');
        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : $city=='' ? 'xa' : $city;
        $cookie_city = $_COOKIE[COOKIE_PRE.'city_key'];
        $city_config = get_config('city_config');
        $cityid = $city_config[$city]['cityid'];
        $cityname = $city_config[$city]['cityname'];


        //分页初始化
        $page = max(intval($GLOBALS['page']),1);
        //分页规则
        $urlrule = '';
        $urlrule = WWW_PATH.$category['listurl'];
        if($category['child']) {
            $_template = $category['category_template'];
        } else {
            $_template = $category['list_template'];
        }
        if(ENABLE_SITES) {
            $siteid = intval($_GET['siteid']);
            if(!$siteid) $siteid = 1;
            $tplid = TPLID.'-'.$siteid;
        } else {
            $tplid = TPLID;
        }
        if(empty($_template))  $_template = $tplid.':list';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $seo_title = $category['seo_title'] ? $category['seo_title'] : $category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = $category['seo_keywords'];
        $seo_description = $category['seo_description'];
        $elasticid = elasticid($cid);
        $model_r = get_cache('model_content','model');
        $master_table = $model_r[$category['modelid']]['master_table'];
        if($category['type']==1) {
            $r = $this->db->get_one($master_table,array('cid'=>$cid));
            if($r) {
                extract($r,EXTR_SKIP);
                if($attr_table = $model_r[$category['modelid']]['attr_table']) {
                    $r = $this->db->get_one($attr_table,array('id'=>$id));
                    extract($r,EXTR_SKIP);
                }
            }
        }

        $sub_categorys = sub_categorys($elasticid);
	$modelid = $category['modelid'];
	$type_field = array();
        $language_set = 1;
        $top_categoryid = getcategoryid($cid);
        $top_category = $categorys[$top_categoryid];
        include T('content',$_template,$project_css);
    }
}
?>