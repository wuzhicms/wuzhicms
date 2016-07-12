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
        $this->siteconfigs = get_cache('siteconfigs');
    }
	public function init() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = '留言板_'.$siteconfigs['sitename'];
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        load_function('content','content');
        load_function('common','member');
        include T('guestbook','index');
	}
    public function contact() {
        $_username = get_cookie('_username');
        if(isset($GLOBALS['submit'])) {
            checkcode($GLOBALS['checkcode']);
            $model_r = $this->db->get_one('model',array('m'=>'guestbook'));
            $formdata = '';
            require get_cache_path('guestbook_add','model');
            $form_add = new form_add($model_r['modelid']);
            $formdata = $form_add->execute($GLOBALS['form']);
            $formdata['master_data']['publisher'] = $_username;
            $formdata['master_data']['addtime'] = SYS_TIME;
            $formdata['master_data']['ip'] = get_ip();
            $formdata['master_data']['status'] = 9;
            $this->db->insert($formdata['master_table'],$formdata['master_data']);
            //执行更新
            require get_cache_path('guestbook_update','model');
            $form_update = new form_update($model_r['modelid']);
            $form_update->execute($formdata);
            MSG('您的留言已提交，我们将尽快给您回复',HTTP_REFERER,3000);
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