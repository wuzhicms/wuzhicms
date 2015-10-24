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
 * 生成静态文件
 */
class WUZHI_html {
    public $category;//当前栏目配置信息
    public $categorys;//当前模块所有栏目
    public function __construct($category = '') {
        $this->category = $category;
        $this->siteconfigs = get_cache('siteconfigs');
        $this->urlclass = load_class('url','content');
    }

    public function set_category($category) {
        $this->category = $category;
    }
    public function set_categorys($categorys = '') {
        if($categorys=='') {
            $this->categorys = get_cache('category','content');
        } else {
            $this->categorys = $categorys;
        }
    }
    public function load_formatcache() {
        require get_cache_path('content_format','model');
        $this->form_format = new form_format($this->category['modelid']);
    }
    public function listing($file,$page) {
        $siteconfigs = $this->siteconfigs;
        $categorys = $this->categorys;
        $category = $this->category;
        $cid = $category['cid'];
        $seo_title = $category['seo_title'] ? $category['seo_title'] : $category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = $category['seo_keywords'];
        $seo_description = $category['seo_description'];
        $elasticid = elasticid($cid);
        //分页初始化
        $page = max($page,1);
        $urlrule = $this->category['listurl'];
        $urlrules = explode('|',$urlrule);
        $urlrule = WWW_PATH.$urlrules[0].'|'.WWW_PATH.$urlrules[1];

        $GLOBALS['catdir'] = $this->category['catdir'];
        $GLOBALS['categorydir'] = $this->category['parentdir'];

        if($category['child']) {
            $_template = $category['category_template'];
        } else {
            $_template = $category['list_template'];
        }
        if(empty($_template))  $_template = TPLID.':list';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $model_r = get_cache('model_content','model');
        $master_table = $model_r[$category['modelid']]['master_table'];
        if($category['type']==1) {
            $db = load_class('db');
            $r = $db->get_one($master_table,array('cid'=>$cid));
            if($r) {
                extract($r,EXTR_SKIP);
                if($attr_table = $model_r[$category['modelid']]['attr_table']) {
                    $r = $db->get_one($attr_table,array('id'=>$id));
                    extract($r,EXTR_SKIP);
                }
            }
        }
        $sub_categorys = sub_categorys($cid);
        ob_start();
        include T('content',$_template,$project_css);
        return $this->write($file);
    }
    public function show($data,$num = 1, $current_page = 1,$file_root = '',$model_r = '') {
        $id = $data['id'];
        $previous_page = $data['previous_page'];
        $next_page = $data['next_page'];
        unset($data['previous_page'],$data['next_page']);
        $siteconfigs = $this->siteconfigs;
        $categorys = $this->categorys;
        $category = $this->category;
        $cid = $category['cid'];

        $urlrule = $this->category['showurl'];
        $urlrules = explode('|',$urlrule);
        $urlrule = WWW_PATH.$urlrules[0].'|'.WWW_PATH.$urlrules[1];
        $year = date('Y',$data['addtime']);
        $variables = array('year'=>$year,'cid'=>$cid,'id'=>$data['id']);

        $GLOBALS['catdir'] = $this->category['catdir'];
        $GLOBALS['categorydir'] = $this->category['parentdir'];

        if($data['modelid']) {
            $this->form_format->modelid = $data['modelid'];
            $this->form_format->fields = get_cache('field_'.$data['modelid'],'model');
        }
        $format_data = $this->form_format->execute($data);
        foreach($format_data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
        $seo_title = $title.'_'.$category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = !empty($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        $elasticid = elasticid($cid);

        if(isset($template) && $template) {
            $_template = $template;
        } elseif($category['show_template']) {
            $_template = $category['show_template'];
        } elseif(isset($model_r['template'])) {
            $_template = TPLID.':'.$model_r['template'];
        } else {
            $_template = TPLID.':show';
        }
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $addtime = $data['addtime'];

        $page = 1;
        //手动分页
        $CONTENT_POS = strpos($content, '_wuzhicms_page_tag_');
        if(!empty($content) && $CONTENT_POS !== false) {
            $contents = array_filter(explode('_wuzhicms_page_tag_', $content));
            $pagetotal = count($contents);
            foreach($contents as $cons) {

                $urls = $this->urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>$page,'route'=>$data['route']));
                $file_root = $urls['root'];
                $content = $cons;
                $content_pages = pages($pagetotal, $page, 1, $urlrule, $variables,10);
                $tmp_year = date('Y',$addtime);
                $tmp_month = date('m',$addtime);
                $tmp_day = date('d',$addtime);
                $content_pages = pages($pagetotal,$page,1,$urlrule,array('categorydir'=>$category['parentdir'],'year'=>$tmp_year,'month'=>$tmp_month,'day'=>$tmp_day,'catdir'=>$category['catdir'],'cid'=>$cid,'id'=>$id));
                //写入
                ob_start();
                include T('content',$_template,$project_css);
                $this->write($file_root);
                $page++;
                ob_end_clean();
            }
        } else {
            if($file_root=='') {
                $urls = $this->urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$data['addtime'],'page'=>1,'route'=>$data['route']));
                $file_root = $urls['root'];
            }
            ob_start();
            include T('content',$_template,$project_css);
            return $this->write($file_root);
        }
    }
    public function index() {
        $isindex = 1;
        $siteconfigs = $this->siteconfigs;
        if(empty($this->categorys)) $this->set_categorys();
        $categorys = $this->categorys;
        $GLOBALS['catdir'] = '';
        $GLOBALS['categorydir'] = '';
        $seo_title = $siteconfigs['sitename'];
        $seo_keywords = $siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        ob_start();
        include T('content','index',TPLID);
        $file = WWW_ROOT.'index'.POSTFIX;
        return $this->write($file);
    }
    private function write($file) {
        if($file=='') MSG(L('filename').'为空');
        $data = ob_get_contents();
        ob_clean();
        $dir = dirname($file);
        if(!is_dir($dir)) {
            mkdir($dir, 0777,1);
        }
        $strlen = file_put_contents($file, $data);
        if(!is_writable($file)) {
            $file = str_replace(WWW_ROOT,'',$file);
            MSG(L('file').'：'.$file.'<br>'.L('not_writable'));
        }
        return $strlen;
    }
}