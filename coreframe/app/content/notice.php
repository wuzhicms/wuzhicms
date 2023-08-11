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
 * 通知单
 */
class notice{
    private $siteconfigs;
	public function __construct() {
        $this->db = load_class('db');
        $this->siteid = $_GET['siteid'] ? $_GET['siteid'] : 1;
		$this->siteconfigs = get_cache('siteconfigs_'.$this->siteid);
	}
    /**
     * 内容页面
     * url规则 /index.php?v=show&cid=24&id=79
     */
    public function init() {
        $siteid = $this->siteid;
        $siteconfigs = $this->siteconfigs;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $cid = intval($GLOBALS['cid']);

        $categorys = get_cache('category','content');
		$models = get_cache('model_content','model');
		$master_table = 'content_share';

        $master_table_other = $master_table;
        
        $data = $this->db->get_one($master_table,array('id'=>$id));
        if(!$data || $data['status']!=9) MSG('信息不存在或者未通过审核！');
        if(!$cid) {
            $category = get_cache('category_'.$data['cid'],'content');
            $model_r = $models[$category['modelid']];
        } elseif($data['modelid']) {
			$model_r = $models[$data['modelid']];
		}

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

        include T('content','notice');
    }

}
?>