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
 * 下载
 */
class down{
    private $siteconfigs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
	}

    /**
     * 下载文件
     */
    public function d() {
        if(isset($GLOBALS['s']) && !empty($GLOBALS['s'])) {
            $file = decode($GLOBALS['s']);
            if (strpos($file, 'wZ:') !== false) {
                $file = str_replace('wZ:',ATTACHMENT_ROOT,$file);
                echo $file;
                download($file);
            } elseif(preg_match('/^http:|https:|ftp:/',$file)) {
                //远程地址下载
                header("Location:".$file);
            }
        }
    }

    /**
     * 新窗口打开下载
     */
    public function filedown() {
        $downfile = decode($GLOBALS['str']);
        $downloadtype = intval(substr($downfile,0,1));
        $downfile = substr($downfile,1);
        if(!$downloadtype) {
            $downfile = private_file($downfile);
        }
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
        $siteconfigs = $this->siteconfigs;
        $categorys = get_cache('category','content');
        //查询数据
        if($cid && $id) {
            $category = get_cache('category_'.$cid,'content');
            $models = get_cache('model_content','model');

            $model_r = $models[$category['modelid']];
            $master_table = $model_r['master_table'];
            $data = $this->db->get_one($master_table,array('id'=>$id));
            if(!$data || $data['status']!=9) MSG('信息不存在或者未通过审核！');
            if($model_r['attr_table']) {
                $attr_table = $model_r['attr_table'];
                if($data['modelid']) {
                    $modelid = $data['modelid'];
                    $attr_table = $models[$modelid]['attr_table'];
                }
                $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
                $data = array_merge($data,$attrdata);
            }

            require get_cache_path('content_format','model');
            $form_format = new form_format($model_r['modelid']);
            $data = $form_format->execute($data);
            foreach($data as $_key=>$_value) {
                if($_key=='downfile') continue;
                $$_key = $_value['data'];
            }
			$_groupid = get_cookie('_groupid');

			if(!empty($groups)) {
				$groups_arr = explode(',',$groups);
				if(!in_array($_groupid,$groups_arr)) {
					MSG('您所在到会员组没有下载权限');
				}
			}
            $seo_title = $title.'下载_'.$siteconfigs['sitename'];
        } else {
            $seo_title = '文件下载_'.$siteconfigs['sitename'];
        }

        include T('content','download',TPLID);
    }
}
?>