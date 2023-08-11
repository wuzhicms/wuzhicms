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


	private function baidumap($config, $value) {
		
        $field = $config['field'];
        $values[$field.'_x'] = $GLOBALS[$field.'_x'];
        $values[$field.'_y'] = $GLOBALS[$field.'_y'];
        $values[$field.'_zoom'] = $GLOBALS[$field.'_zoom'];
		return $values;
	}

	private function block($config, $value) {
		$number = count($value);
        $value = $number==1 ? '0' : '1';
		return $value;
	}

	private function box($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        if($boxtype == 'checkbox') {
            if(!is_array($value) || empty($value)) return false;
            array_shift($value);
            $value = ','.implode(',', $value).',';
            return $value;
        } elseif($boxtype == 'multiple') {
            if(is_array($value) && count($value)>0) {
            $value = ','.implode(',', $value).',';
            return $value;
        }
        } else {
            return $value;
        }
	}

	private function box_sql($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        if($boxtype == 'checkbox') {
            if(!is_array($value) || empty($value)) return false;
            array_shift($value);
            $value = ','.implode(',', $value).',';
            return $value;
        } elseif($boxtype == 'multiple') {
            if(is_array($value) && count($value)>0) {
            $value = ','.implode(',', $value).',';
            return $value;
        }
        } else {
            return $value;
        }
	}

	private function content_group($config, $value) {
		$field = $config['field'];
			if(!empty($GLOBALS[$field])) {
			return array2string($GLOBALS[$field]);
		}
	}

	private function copyfrom($config, $value) {
		return $value;
	}

	private function datetime($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
		if($fieldtype=='int') {
			$value = strtotime($value);
		}
		return $value;
	}

	private function downfile($field, $value) {
		return trim($value);
	}

	private function downfiles($config, $value) {
		if(empty($value)) return '';
		$tmp = array();
		foreach($value as $r) {
			$tmp[] = $r;
		}
		return array2string($tmp);
	}

	private function editor($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		if($value && $editor_type=='ckeditor') {
			$value = str_replace('<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>','_wuzhicms_page_tag_',$value);
		}
		/*远程图片加载*/
		$enablesaveimage = $setting['enablesaveimage'];
		if(isset($_POST['spider_img'])) $enablesaveimage = 1;
		if($enablesaveimage) {
			$watermark_enable = intval($setting['watermark_enable']);
			$attachment = load_class('attachment','attachment');
			$value = $attachment->save_remote($value,$watermark_enable);
		}
		return $value;
	}
	private function group($config, $value) {
        extract($config,EXTR_SKIP);
		$datas = '';
		if(!empty($GLOBALS[$field]) && is_array($GLOBALS[$field])) {
			$datas = implode(',',$GLOBALS[$field]);
		}
		return $datas;
	}

	private function image($field, $value) {
		$value = remove_xss(str_replace(array("'",'"','(',')'),'',$value));
		return trim($value);
	}

	private function images($config, $value) {
        return array2string($value);
	}


	private function keyword($config, $value) {
		$value = strip_tags($value);
         if(strpos($value,',')===false) {
            return str_replace(' ',',',$value);
         } else {
            return $value;
         }
	}


	private function linkage($config, $value) {
			$field = $config['field'];
			$linkageid = $config['setting']['linkageid'];
			$values[$field] = $GLOBALS['LK'.$linkageid.'_3'];
			$values[$field.'_1'] = $GLOBALS['LK'.$linkageid.'_1'];
			$values[$field.'_2'] = $GLOBALS['LK'.$linkageid.'_2'];
		return $values;
	}


	private function linkage_box($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
		if(!is_array($value) || empty($value)) return false;
		array_shift($value);
		$value = ','.implode(',', $value).',';
		return $value;
	}


	private function text($config, $value) {
		
		if(!$config['setting']['enablehtml']) $value = strip_tags($value);
		return $value;
	}

	private function text_select($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        if($boxtype == 'checkbox') {
            if(!is_array($value) || empty($value)) return false;
            array_shift($value);
            $value = ','.implode(',', $value).',';
            return $value;
        } elseif($boxtype == 'multiple') {
            if(is_array($value) && count($value)>0) {
            $value = ','.implode(',', $value).',';
            return $value;
        }
        } else {
            return $value;
        }
	}


	private function textarea($config, $value) {
		
if(!$config['setting']['enablehtml']) $value = strip_tags($value);
		return $value;
	}

	private function topic($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        return $value;
	}

} ?>