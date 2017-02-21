<?php
/**
 * 表单创建类
*/
class form_build {
	var $modelid;
	var $fields;
	var $formdata;
	var $extdata;//扩展数据，用于额外的参数传递，赋值方法：$form_add->extdata['mykey'] = 'data'
	var $id;//当为编辑状态时，存在id
	var $validform;//js validform验证类
	var $cid;//栏目id
	var $form;//form类

    function __construct($modelid) {
		$this->db = load_class('db');
		$this->tablepre = $this->db->tablepre;
		$this->modelid = $modelid;
		$this->fields = get_cache('field_'.$modelid,'model');
		$this->extdata = '';
        $this->form = load_class('form');
    }

	public function execute($formdata = array(),$modelid = '',$set_language = '') {
		if($modelid) {
			$tmp = $tmp2 = array();
			if($set_language) {
				foreach($this->fields as $field=>$r) {
					$r['name'] = $r['name'].'['.$set_language.']';
					$r['field'] = $field.'_'.$set_language;
					$tmp[$field.'_'.$set_language] = $r;
				}
				if(!empty($formdata)) {
					$formdata_tmp = $formdata;
					$formdata = array();
					foreach ($formdata_tmp as $field => $data) {
						$formdata[$field . '_' . $modelid . '_' . $set_language] = $data;
					}
				}
			} else {
				foreach($this->fields as $field=>$r) {
					$r['field'] = $field.'_'.$modelid;
					$tmp[$r['field']] = $r;
				}
				if(!empty($formdata)) {
					$formdata_tmp = $formdata;
					$formdata = array();
					foreach($formdata_tmp as $field=>$data) {
						$formdata[$field.'_'.$modelid] = $data;
					}
				}
			}

			$this->fields = $tmp;

		}
		//if($set_language) print_r($formdata);
		$this->formdata = $formdata;
        $this->id = $this->formdata['id'] ? $this->formdata['id'] : 0;
        $info = array();
		foreach($this->fields as $field=>$field_config) {
            $value = '';
			if($this->check_field($field)===FALSE) continue;
            if(!empty($formdata)) $value = $formdata[$field];
			$func = $field_config['formtype'];
			//在field_config 必须包含的键值：field
			if(method_exists($this, $func)) $value = $this->$func($field_config, $value);
			if($value !== FALSE) {
				$star = $field_config['minlength'] || $field_config['pattern'] ? 1 : 0;
				$location = $field_config['location'];
				$info[$location][$field] = array('name'=>$field_config['name'],'field'=>$field, 'remark'=>$field_config['remark'], 'form'=>$value, 'star'=>$star,'powerful_field'=>$field_config['powerful_field'],'formtype'=>$field_config['formtype'],'ban_contribute'=>$field_config['ban_contribute'],'master_field'=>$field_config['master_field']);
			}
		}
		//如果表单没不分左侧和右侧，那么需要合并数据为一个二维数组
		return $info;
	}

	private function check_field($field){
		//page_type 分页方式／max_string 每页最大字符
		if(!isset($this->fields[$field]) || value_exists($field,'max_string,page_type')) return FALSE;
		if(defined('IN_ADMIN')) {
			if(value_exists($_SESSION['role'], $this->fields[$field]['unsetroles'])) return FALSE;
		} else {
			$gid = get_cookie('gid');
			if(value_exists($gid, $this->fields[$field]['unsetgids'])) return FALSE;
		}
	}
}exit();?>