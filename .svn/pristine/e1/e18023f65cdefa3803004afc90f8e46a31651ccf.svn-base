<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 模型缓存
 */
class WUZHI_cache_model {
	/**
	 * 获取字段列表
	 * @param $m 模块名
	 * @param bool $unique 是否为唯一值
	 * @return array
	 */
    public function get_fields($m, $unique = TRUE) {
        static $_system_field;
        if(empty($_system_field)) {
            $sysfield_list = glob(COREFRAME_ROOT.'app/core/fields/*',GLOB_ONLYDIR);
            foreach ($sysfield_list as $filename) {
                $_system_field[] = basename($filename);
            }
        }

        $modulefield_list = glob(COREFRAME_ROOT.'app/'.$m.'/fields/*',GLOB_ONLYDIR);
        if(!empty($modulefield_list)) {
            foreach ($modulefield_list as $filename) {
                $module_field[] = basename($filename);
            }
        }
        $fields = '';
        if($unique) {
            if(empty($module_field)) {
                return $_system_field;
            } else {
                return array_merge($_system_field,$module_field);
            }
        } else {
            if(empty($module_field)) {
                return array('system_field'=>$_system_field,'module_field'=>'');
            } else {
                return array('system_field'=>$_system_field,'module_field'=>$module_field);
            }
        }
    }
	/**
	 * 获取字段详情
	 * @param $m 模块名
	 * @return array
	 */
    public function get_fields_info($m) {
        $fields = $this->get_fields($m,FALSE);
        //print_r($fields);exit;
        $filed_info = array();
        if(!empty($fields['module_field'])) {
            foreach ($fields['module_field'] AS $value) {
                $config = include COREFRAME_ROOT.'app/'.$m.'/fields/'.$value.'/config.php';
                $config['module_field'] = 1;
                $filed_info[$value] = $config;
            }
        }

        foreach ($fields['system_field'] as $value) {
            if($fields['module_field'] && in_array($value, $fields['module_field'])) continue;
            $config = include COREFRAME_ROOT.'app/core/fields/'.$value.'/config.php';
            $config['system_field'] = 1;
            $filed_info[$value] = $config;
        }
        return $filed_info;
    }
	/**
	 * 生成指定模块表单缓存
	 * @param $m 模块名
	 * @return bool
	 */
    public function cache_form($m) {
        $fields = $this->get_fields($m);
        //form,format,update
        $class_name = array('add','form','format','update');
        foreach($class_name AS $_name) {
            if(file_exists(COREFRAME_ROOT.'app/'.$m.'/fields/'.$_name.'.class.php')) {
                $formdata = file_get_contents(COREFRAME_ROOT.'app/'.$m.'/fields/'.$_name.'.class.php');
            } else {
                $formdata = file_get_contents(COREFRAME_ROOT.'app/core/fields/'.$_name.'.class.php');
            }
            foreach ($fields as $field) {
                if(file_exists(COREFRAME_ROOT.'app/'.$m.'/fields/'.$field.'/'.$_name.'.class.php')) {
                    $formdata .= file_get_contents(COREFRAME_ROOT.'app/'.$m.'/fields/'.$field.'/'.$_name.'.class.php');
                } elseif(file_exists(COREFRAME_ROOT.'app/core/fields/'.$field.'/'.$_name.'.class.php')) {
                    $formdata .= file_get_contents(COREFRAME_ROOT.'app/core/fields/'.$field.'/'.$_name.'.class.php');
                }
            }
            $formdata = str_replace('}exit();?>','',$formdata);
            $formdata = str_replace('<?php exit();?>','',$formdata);
            $formdata = preg_replace("/<!--(.*)-->/",'',$formdata);
            //$formdata = str_replace("\t", '', $formdata);
            //$formdata = str_replace("  ", '', $formdata);
            //$formdata = str_replace("\r\n", ' ', $formdata);
            $formdata .= "\r\n} ?>";
            set_cache($m.'_'.$_name,$formdata,'model');
        }
        return TRUE;
    }
	/**
	 * 更新字段缓存
	 * @return bool
	 */
    public function cache_field() {
        //多个不同的模块用模型功能，模型可能会有很多，需要分批更新
        //每次取100条，然后分批更新
        //每个模块只能有一个共享模型, 在模型数据不存在该模型，而是在添加共享模型的时候，通过共享模型db_share.sql来完成字段的添加
        //共享模型的主表是通过开发人员开发时候完成添加。

        $db = load_class('db');
        $total = $db->count_result('model');
        $tatalpage = ceil($total/100);
        for($i=0;$i<$tatalpage;$i++) {
            //get_list($table, $where = '', $field = '*', $startid = 0, $pagesize = 20,
            $startid = $i * 100;
            $result = $db->get_list('model', '', '*', $startid, 100,0,'modelid ASC');
            $model_arr = array();
            foreach ($result as $r) {
                $model_arr[$r['m']][$r['modelid']] = $r;
                $field_result = $db->get_list('model_field',array('modelid'=>$r['modelid'],'disabled'=>0), '*', 0, 100,0,'sort ASC');
                //创建一个新数组，写入缓存
                $new_arr = array();
                if(!empty($field_result)) {
                    foreach($field_result as $_key=>$_var) {
                        $_var['master_table'] = $r['master_table'];
                        $_var['attr_table'] = $r['attr_table'];
                        $_var['setting'] = $_var['setting'] ? unserialize($_var['setting']) : '';
                        $new_arr[$_var['field']] = $_var;
                    }
                    set_cache('field_'.$r['modelid'],$new_arr,'model');
                }
            }
            foreach($model_arr as $m=>$data) {
                set_cache('model_'.$m,$data,'model');
            }
        }
        return TRUE;
    }

	/**
	 * 缓存所有模型，要缓存的模块在配置文件：/www/configs/model_config.php
	 * @return bool
	 */
    public function cache_all() {
        $model_config = get_config('model_config');
        // $cache_model = load_class('cache_model');
        foreach($model_config as $m) {
            $this->cache_form($m);
        }
        //更新字段缓存
        $this->cache_field();
        return TRUE;
    }
}
?>