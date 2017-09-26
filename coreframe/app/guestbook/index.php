<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
class index {
 	function __construct() {
        $this->db = load_class('db');
        $this->siteconfigs = get_cache('siteconfigs_1');
    }

	public function init() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = '留言板_'.$siteconfigs['sitename'];
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        load_function('content','content');
        load_function('common','member');

        $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
        $fields = get_cache('field_'.$model_r['modelid'],'model');
        $area_array_tmp = $fields['area']['setting']['options'];
        $area_array_tmp = explode("\r\n",$area_array_tmp);
        $area_array =array();
        foreach($area_array_tmp as $area) {
            $areas = explode('|',$area);
            $area_array[$areas[0]] = $areas[1];
        }
        $area = isset($GLOBALS['area']) ? sql_replace($GLOBALS['area']) : '';

        $category_array_tmp = $fields['category']['setting']['options'];
        $category_array_tmp = explode("\r\n",$category_array_tmp);
        $category_array =array();
        foreach($category_array_tmp as $category) {
            $categorys = explode('|',$category);
            $category_array[$categorys[0]] = $categorys[1];
        }

        $category = isset($GLOBALS['category']) ? sql_replace($GLOBALS['category']) : '';

        $status  = array(1=>'未审核',7=>'办理中',8=>'已回复',9=>'未回复',10=>'已完结');
        $type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : 0;
        $conditions = isset($GLOBALS['conditions']) ? intval($GLOBALS['conditions']) : 0;
        switch($type) {
            case 0://全部=>只要通过审核就是
                $where = '`status` IN(7,8,9,10)';
                break;
            case 7: //办理中=>通过审核，未回复，已回复
                $where = '`status` IN(7,8,9)';
                break;
            case 8://已回复=>办理中,审核通过，已回复，但未完结的。
                $where = '`status`=8';
                break;
            case 9://未回复=>通过审核，没有回复
                $where = '`status`=9';
                break;
            case 10://已完结=>通过审核，已回复。办理完成
                $where = '`status`=10';
                break;
        }

        if(isset($GLOBALS['keywords'])) {
            $keywords = sql_replace($GLOBALS['keywords']);
            if($conditions) {
                $keywords = intval($keywords);
                $where .= " AND `id`='$keywords'";
            } else {
                $where .= " AND (`title` LIKE '%$keywords%' OR `content` LIKE '%$keywords%')";
            }

        }
        if($area) {
            $where .= " AND `area`='$area'";
        }
        if($category) {
            $where .= " AND `category`='$category'";
        }
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $guestbook_result = $this->db->get_list('guestbook', $where, '*', 0, 5,$page,'id DESC');
        $guestbook_pages = $this->db->pages;
        $total = $this->db->number;

        include T('guestbook','index');
	}

    public function contact() {
        $_username = get_cookie('_username');
        $model_r = $this->db->get_one('model',array('m'=>'guestbook'));

        $fields = get_cache('field_'.$model_r['modelid'],'model');
        $area_array_tmp = $fields['area']['setting']['options'];
        $area_array_tmp = explode("\r\n",$area_array_tmp);
        $area_array =array();
        foreach($area_array_tmp as $area) {
            $areas = explode('|',$area);
            $area_array[$areas[0]] = $areas[1];
        }
        $area = isset($GLOBALS['area']) ? sql_replace($GLOBALS['area']) : '';

        $category_array_tmp = $fields['category']['setting']['options'];
        $category_array_tmp = explode("\r\n",$category_array_tmp);
        $category_array =array();
        foreach($category_array_tmp as $category) {
            $categorys = explode('|',$category);
            $category_array[$categorys[0]] = $categorys[1];
        }

        $category = isset($GLOBALS['category']) ? sql_replace($GLOBALS['category']) : '';
        if(isset($GLOBALS['submit'])) {
            //checkcode($GLOBALS['checkcode']);
            if($GLOBALS['checkbox']==1){$model_r = $this->db->get_one('model',array('m'=>'guestbook'));
                $formdata = '';
                require get_cache_path('guestbook_add','model');
                $form_add = new form_add($model_r['modelid']);
                $formdata = $form_add->execute($GLOBALS['form']);
                $formdata['master_data']['publisher'] = $_username;
                $formdata['master_data']['addtime'] = SYS_TIME;
                $formdata['master_data']['ip'] = get_ip();
                $formdata['master_data']['status'] = 1;
                $this->db->insert($formdata['master_table'],$formdata['master_data']);
                //执行更新
                require get_cache_path('guestbook_update','model');
                $form_update = new form_update($model_r['modelid']);
                $form_update->execute($formdata);
                $r=$this->db->get_one('guestbook',array('addtime' =>$formdata['master_data']['addtime']));
                MSG("您的留言已提交，我们将尽快给您回复,您的帖子查询码为'$r[id]'",HTTP_REFERER,6000);}
            else{MSG('没有选择同意协议不能进行留言',HTTP_REFERER,3000);}

        } else {
            $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
            require get_cache_path('guestbook_form','model');
            $form_build = new form_build($model_r['modelid']);

            $formdata = $form_build->execute();
            $field_list = '';
            if(is_array($formdata['0'])) {
                foreach($formdata['0'] as $field=>$info) {
                    if($info['powerful_field']) continue;
                    if($info['formtype']=='powerful_field') {
                        foreach($formdata['0'] as $_fm=>$_fm_value) {
                            if($_fm_value['powerful_field']) {
                                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                            }
                        }
                        foreach($formdata['1'] as $_fm=>$_fm_value) {
                            if($_fm_value['powerful_field']) {
                                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                            }
                        }
                    }
                    $field_list[] = $info;
                }
            }
            include T('guestbook','contact');
        }

    }
    public function show() {
        load_function('common','member');
        $siteconfigs = $this->siteconfigs;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $categorys = get_cache('category','content');
        //查询数据
        $models = get_cache('model_guestbook','model');
        $model_r = $models[15];
        $master_table = $model_r['master_table'];
        $data = $this->db->get_one($master_table,array('id'=>$id));

        $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
        $fields = get_cache('field_'.$model_r['modelid'],'model');
        $area_array_tmp = $fields['area']['setting']['options'];
        $area_array_tmp = explode("\r\n",$area_array_tmp);
        $area_array =array();
        foreach($area_array_tmp as $area) {
            $areas = explode('|',$area);
            $area_array[$areas[0]] = $areas[1];
        }
        $area = isset($GLOBALS['area']) ? sql_replace($GLOBALS['area']) : '';
        $category_array_tmp = $fields['category']['setting']['options'];
        $category_array_tmp = explode("\r\n",$category_array_tmp);
        $category_array =array();
        foreach($category_array_tmp as $category) {
            $categorys = explode('|',$category);
            $category_array[$categorys[0]] = $categorys[1];
        }

        $category = isset($GLOBALS['category']) ? sql_replace($GLOBALS['category']) : '';
        $conditions = isset($GLOBALS['conditions']) ? intval($GLOBALS['conditions']) : 0;
        if(isset($GLOBALS['keywords'])) {
            $keywords = sql_replace($GLOBALS['keywords']);
            if($conditions) {
                $keywords = intval($keywords);
                $where .= " AND `id`='$keywords'";
            } else {
                $where .= " AND (`title` LIKE '%$keywords%' OR `content` LIKE '%$keywords%')";
            }

        }
        if($area) {
            $where .= " AND `area`='$area'";
        }
        if($category) {
            $where .= " AND `category`='$category'";
        }
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $guestbook_result = $this->db->get_list('guestbook', $where, '*', 0, 5,$page,'id DESC');

        require get_cache_path('content_format','model');
        $form_format = new form_format($model_r['modelid']);
        $data = $form_format->execute($data);

        foreach($data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
        $_template = TPLID.':show';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $seo_title = $title.'_'.$siteconfigs['sitename'];
        $seo_keywords = !empty($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        $this->db->update($master_table, "`hits`=(`hits`+1)", array('id' => $id));
        include T('guestbook','show');
    }
}