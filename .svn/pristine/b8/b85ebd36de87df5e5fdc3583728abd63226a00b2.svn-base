<?php
class form_add {
	var $modelid;
	var $fields;
	var $formdata;
	var $extdata;//扩展数据，用于额外的参数传递，赋值方法：$form_add->extdata['mykey'] = 'data'
	var $display_error = TRUE;//是否直接显示错误提醒

	function __construct($modelid) {
		$this->db = load_class('db');
		$this->tablepre = $this->db->tablepre;
		$this->modelid = $modelid;
		$this->fields = get_cache('field_'.$modelid,'model');
		$this->extdata = '';
		$this->hook = load_class('hook');
    }

	public function execute($formdata) {
		$this->hook->run_hook('form_add',$formdata,array('modelid'=>$this->modelid));
		$this->formdata = $formdata;
		$info = array();
		foreach($formdata as $field=>$value) {
			if($this->check_field($field)===FALSE) continue;
			$field_config = $this->fields[$field];
			$name = $field_config['name'];
			$minlength = $field_config['minlength'];
			$maxlength = $field_config['maxlength'];
			$pattern = $field_config['pattern'];
			$errortips = $field_config['errortips'];
			if(empty($errortips)) $errortips = $name.' '.L('not meet the conditions');
			$length = empty($value) ? 0 : (is_string($value) ? mb_strlen($value,CHARSET) : count($value));

			if($minlength && ($length < $minlength)) {
				if(!$this->display_error) {
					return false;
				} else {
					MSG($name.' '.L('min length error').' '.$minlength.L('characters'));
				}
			}

			if($maxlength && ($length > $maxlength)) {
				if(!$this->display_error) {
					$value = strcut($value,$maxlength,'');
				} else {
					MSG($name.' '.L('max length error').' '.$maxlength.L('characters'));
				}
			} elseif($maxlength) {
				$value = mb_substr($value,0,$maxlength,CHARSET);
			}
			if($pattern && $length && !preg_match($pattern, $value) && !$display_error) MSG($errortips);
           // $this->db->table = $field_config['master_field'] ? $field_config['master_table'] : $field_config['attr_table'];
			$func = $field_config['formtype'];
			//在field_config 必须包含的键值：field
			if(method_exists($this, $func)) $value = $this->$func($field_config, $value);
            if(is_string($value) || is_numeric($value)) {
                if($field_config['master_field']) {
                    $info['master_data'][$field] = $value;
                } else {
                    $info['attr_data'][$field] = $value;
                }
            } elseif(is_array($value) && $value[0]!='no_value') {
                if($field_config['master_field']) {
                    foreach($value as $_field=>$_value) {
                        $info['master_data'][$_field] = $_value;
                    }
                } else {
                    foreach($value as $_field=>$_value) {
                        $info['attr_data'][$_field] = $_value;
                    }
                }
            }
            $info['master_table'] = $field_config['master_table'];
            $info['attr_table'] = $field_config['attr_table'];
		}
		return $info;
	}
	private function check_field($field){
		//page_type 分页方式／max_string 每页最大字符
		if(!isset($this->fields[$field]) && value_exists($field,'id,max_string,page_type,route')) return FALSE;
		if(defined('IN_ADMIN')) {
			if(value_exists($_SESSION['role'], $this->fields[$field]['unsetroles'])) return FALSE;
		} else {
			$gid = get_cookie('gid');
			if(value_exists($gid, $this->fields[$field]['unsetgids'])) return FALSE;
		}
	}
}exit();?>