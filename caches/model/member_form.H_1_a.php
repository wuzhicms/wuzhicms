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

	private function baidumap($config, $value) {
        extract($config,EXTR_SKIP);
        if(!isset($style)) $style = '';
        $x = isset($this->formdata[$field.'_x']) ? $this->formdata[$field.'_x'] : '';
        $y = isset($this->formdata[$field.'_y']) ? $this->formdata[$field.'_y'] : '';
        $zoom = isset($this->formdata[$field.'_zoom']) ? $this->formdata[$field.'_zoom'] : '';
		$str = '<input type="hidden" name="form['.$field.']" value="1"> X 坐标：<input type="text" name="'.$field.'_x" id="'.$field.'_x" value="'.$x.'"> Y 坐标：<input type="text" name="'.$field.'_y" id="'.$field.'_y"  value="'.$y.'"> 层级：<input type="text" name="'.$field.'_zoom" id="'.$field.'_zoom"  value="'.$zoom.'">';
        $str .= '<span class="input-group-btn"><button class="btn btn-white" type="button" onclick="baidumap(\''.$field.'\');">打开地图标注</button></span>';
		return $str;
	}

	private function block($config, $value) {
        extract($config,EXTR_SKIP);
        $siteid = SITEID;
        if(defined('IN_ADMIN')) {
                $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        } else {
                $_lang = LANGUAGE;
        }
        $where = "`siteid`='$siteid' AND `lang`='".$_lang."' AND `type`=1 AND `modelid` IN(0,".$this->modelid.")";
        $result = $this->db->get_list('block',$where, 'blockid,name', 0, 100);
        $option = key_value($result,'blockid','name');
        $values = '';
        if($value) {
                $keyid = $this->formdata['id'].'-'.$this->formdata['cid'].'-'.$_lang;
                $block_data = $this->db->get_list('block_data',array('keyid'=>$keyid), '*', 0, 100);
                if(!empty($block_data)) {
                        $option_value = array_keys($option);
                        foreach($block_data as $rs) {

                                if(in_array($rs['blockid'],$option_value)) {
                                        $values[] = $rs['blockid'];
                                }
                        }
                        if($values) $values = implode(',',$values);
                }
        }
        $string = $this->form->checkbox($option,$values,"name='form[$field][]' $ext_code",1,$field);
        return $string;
	}

	private function box($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
        $boxtype = isset($boxtype) ? $boxtype : 'select';
		if($value=='') $value = $defaultvalue;
		$options = explode("\n",$options);
		foreach($options as $_k) {
			$v = explode("|",$_k);
			$k = trim($v[1]);
			$option[$k] = $v[0];
		}
		$values = explode(',',$value);
		$value = array();
		foreach($values as $_k) {
			if($_k != '') $value[] = $_k;
		}
		$value = implode(',',$value);
		switch($boxtype) {
			case 'radio':
				$string = $this->form->radio($option,$value,"name='form[$field]' $ext_code",$field);
			break;

			case 'checkbox':
				$string = $this->form->checkbox($option,$value,"name='form[$field][]' $ext_code",1,$field);
			break;

			case 'select':
				$string = $this->form->select($option,$value,"name='form[$field]' class='form-control' style='width:auto;' id='$field' $ext_code");
			break;

			case 'multiple':
				$string = $this->form->select($option,$value,"name='form[$field][]' id='$field ' size=2 multiple='multiple' style='height:60px;' $ext_code");
			break;
		}
		return $string;
	}

    private function box_sql($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        $boxtype = isset($boxtype) ? $boxtype : 'select';
        if($value=='') $value = $defaultvalue;
        $option = array();
        if($boxtype=='select') {
            $option[] = '请选择 ...';
        }
        preg_match_all('/\$([a-z0-9_]+)/',$sql,$_sqls);
        if(!empty($_sqls)) {
            foreach($_sqls[0] as $_k=>$_sql) {
                $_field = $_sqls[1][$_k];
                if(!$GLOBALS[$_field]) {
                    $GLOBALS[$_field] = $this->formdata[$_field];
                }
                $sql = str_replace($_sql,$GLOBALS[$_field],$sql);
            }
        }
        $res = $this->db->query($sql);
        while($r = $this->db->fetch_array($res)) {
            $option[$r[$field_value]] = $r[$field_name];
        }


        $values = explode(',',$value);
        $value = array();
        foreach($values as $_k) {
            if($_k != '') $value[] = $_k;
        }
        $value = implode(',',$value);
        switch($boxtype) {
            case 'radio'://radio($options = array(), $value = 0, $str = '')
                if($field=='type' && isset($GLOBALS['type']) && $GLOBALS['type']==2) {
                    $value = 2;
                }
                $string = $this->form->radio($option,$value,"name='form[$field]' $ext_code",$field);
                break;

            case 'checkbox':
                $string = $this->form->checkbox($option,$value,"name='form[$field][]' $ext_code",1,$field);
                break;

            case 'select':

                $string = $this->form->select($option,$value,"name='form[$field]' class='form-control' style='width:auto;' id='$field' $ext_code");
                break;

            case 'multiple':
                $string = $this->form->select($option,$value,"name='form[$field][]' id='$field ' size=2 multiple='multiple' style='height:60px;' $ext_code");
                break;
        }
        return $string;
    }

	private function cid($config, $value) {
		if(!$value) $value = $this->cid;
        extract($config,EXTR_SKIP);
		return '<input type="hidden" name="form['.$field.']" value="'.$value.'">'.$this->extdata['catname'];
	}

	private function coin($config, $value) {
		extract($config,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" value="'.$value.'" '.$ext_code.' >';
	}

private function content_group($config, $value){
	if (!empty($value)) $value = string2array($value);
	extract($config, EXTR_SKIP);
	$formtext = $setting['formtext'];
	$str = '<script>
	$(function() {
		$( "#' . $field . '_ul" ).sortable();
		$( "#' . $field . '_ul" ).disableSelection();
	});
</script>';

	$attaclist_div = "at_" . $field;
	$default_multiple = '';

	if ($value && is_array($value)) {
		$keys = array_keys($value);

		$search = array();
		foreach($keys as $key) {
			$search[] = '##'.$key.'##';
		}
		$i = 0;
		foreach ($value[$keys[0]] AS $k => $v) {
			if ($i > 0) $attaclist_div .= $i;
			$replace = array();
			foreach($keys as $key) {
				$replace[] = $value[$key][$k];
			}
			$tmp_formtext = str_replace($search,$replace,$formtext);
			$default_multiple .= '<li id="li_' . $attaclist_div . '"><button class="btn btn-default btn-xs remove_file"  onclick="remove_obj(this);">移除</button>' . $tmp_formtext . '</li>';
			$i++;
		}
	} else {
		$default_multiple = '<li id="li_' . $attaclist_div . '">' . preg_replace('/##([a-z]+)##/', '', $formtext) . '</li>';
	}
	$str2 = '<input type="hidden" name="form[' . $field . ']" value="1"> <div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';

	return $str . '<div class="attaclist" id="' . $attaclist_div . '"><textarea id="text_'.$field.'" style="display:none;">'.preg_replace('/##([a-z]+)##/', '', htmlentities('<button class="btn btn-default btn-xs remove_file"  onclick="remove_obj(this);">移除</button>'.$formtext)).'</textarea>' . $str2 . '<a class="btn btn-primary" href="javascript:add_newfile(\'' . $field . '\');" style="display: block;"> + 增加</a></div>';
}
	private function copyfrom($config, $value) {
        extract($config,EXTR_SKIP);
		$copyfrom_array = $this->db->get_list('copyfrom', '', '*', 0, 1000);
        $copyfrom_array = key_value($copyfrom_array,'fromid','name');
        $holder = '演示站点|www.wuzhicms.com';
		return "<div class='col-sm-4 input-group pull-left'><input type='text' id='$field' name='form[$field]' placeholder='$holder' value='$value' class='form-control input-text'></div><div class='col-sm-4'>".$this->form->select($copyfrom_array,$value,"name='{$field}_data' class='form-control' onchange='change_value(\"$field\",this.value)'","选择已有来源")."</div>";
	}

	private function datetime($config, $value) {
        extract($config,EXTR_SKIP);
        if(is_array($setting)) extract($setting,EXTR_SKIP);
		$isdatetime = 0;
		$timesystem = 0;
		if($fieldtype=='int') {
			if(!$value) $value = SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			if($format == 'Y-m-d Ah:i:s') $format_txt = 'Y-m-d h:i:s';
			$value = date($format_txt,$value);
			
			$isdatetime = strlen($format) > 6 ? 1 : 0;
			if($format == 'Y-m-d Ah:i:s') {
				
				$timesystem = 0;
			} else {
				$timesystem = 1;
			}			
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
			$timesystem = 1;
		} elseif($fieldtype=='datetime_a') {
			$isdatetime = 1;
			$timesystem = 0;
		}
		if($value=='0000-00-00') $value = '';
		return $this->form->calendar("form[$field]",$value,$isdatetime,1,$timesystem,$ext_code);
	}

	private function downfile($config, $value) {
        extract($config,EXTR_SKIP);
        return '<div class="input-group">'.$this->form->attachment($setting['upload_allowext'],1,"form[$field]","$value",'callback_thumb_dialog',0).'</div>';
    }

    private function editor($config, $value) {
        $value = p_htmlentities($value);
        extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
        if($minlength>0) {
            $validform = 'datatype="*" nullmsg="请输入'.$name.'" errormsg="'.$name.'不能为空"';
        } else {
            $validform = '';
        }
        if($value && $editor_type=='ckeditor') {
            $value = str_replace('_wuzhicms_page_tag_','<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>',$value);
        }
        if($toolbar=='textarea') {
            return '<textarea name="form['.$field.']" id="'.$field.'" class="form-control" rows="3" boxid="'.$field.'" '.$validform.'>'.$value.'</textarea>';
        } else {
            $style = '';
            if($GLOBALS['editor_type']=='ewebeditor') {
                $style = ' style="display:none;"';
            }
            return '<textarea name="form['.$field.']" id="'.$field.'" boxid="'.$field.'" '.$validform.$style.'>'.$value.'</textarea>'.$this->form->editor($field,$field,'',$toolbar,$editor_type,1);
        }
    }

	private function group($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        $lists = get_cache('group','member');
        foreach($lists as $_k=>$_v) {
        $data[$_k] = $_v['name'];
        }
		return '<input type="hidden" name="form['.$field.']" value="no_value">'.$this->form->checkbox($data,$value,'name="'.$field.'[]" id="'.$field.'"');
	}

	private function image($config, $value) {
        extract($config,EXTR_SKIP);
        if(defined('IN_ADMIN')) {
            $show_type = 0;
        } else {
            $show_type = intval($setting['member_show_type']);
        }
        return '<div class="input-group">'.$this->form->attachment($setting['upload_allowext'],1,"form[$field]","$value","callback_thumb_dialog",$show_type,$setting['images_width'],$setting['images_height'],$setting['images_cut'],$setting['is_water'],$setting['is_allow_show_img'],$ext_code,1).'</div>';
    }

private function images($config, $value){
	if (!empty($value)) $value = string2array($value);
	extract($config, EXTR_SKIP);
	$str = '<script>
	$(function() {
		$( "#'.$field.'_ul" ).sortable();
		$( "#'.$field.'_ul" ).disableSelection();
	});
</script>';
	$default_multiple = '';
	if ($value && is_array($value)) {
		foreach ($value AS $k => $v) {
			$default_multiple .= '<li id="file_node_' . $k . '"><input type="hidden" name="form[' . $field . '][' . $k . '][url]" value="' . $v['url'] . '"> <img src="' . $v['url'] . '" alt="' . $v['alt'] . '" onclick="img_view(this.src);"> <textarea name="form[' . $field . '][' . $k . '][alt]" >' . $v['alt'] . '</textarea> <a class="btn btn-danger btn-xs" href="javascript:remove_file(' . $k . ');">移除</a></li>';
		}
	}
	$str2 = '<div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';

	return $str . '<div class="attaclist">' . $str2 . $this->form->attachment("jpg|png|gif|bmp", 20, "form[$field]", $value, 'callback_images2', 0,true) . '</div>';
}
	private function keyword($config, $value) {
         extract($config,EXTR_SKIP);
         if(is_array($setting)) extract($setting,EXTR_SKIP);
		if(!$value && isset($defaultvalue)) $value = $defaultvalue;
		$str = '';
		if(!defined('TAGS_JS'))
		{
			define('TAGS_JS',true);
			$str .= '<script src="'.R.'js/jquery.tagsinput.js"></script><script src="'.R.'js/jquery-ui-1.10.1.custom.min.js"></script>';
		}
		$str .= '<script type="text/javascript">
		$(function(){	
			$(".'.$field.'").tagsInput({
			width: "100%",
			minChars:2,
			autocomplete_url:"/index.php?m=tags&f=index&v=ajax_auto_complete",
			autocomplete:{selectFirst:true,width:"100px",autoFill:true}
			});
		})</script>';
		return $str."<input type='text' name='form[$field]' id='$field' value='$value' placeholder='输入关键词后，请回车' {$ext_code} class='input-text form-control contentkeyword ".$field."'>";
	}

	private function linkage($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		if(V=='add') {
		$value = explode(',',$value);
		$values[1] = $value[0];
		$values[2] = $value[1];
		$values[3] = $this->formdata[$field];
		} else {
		$values[1] = $this->formdata[$field.'_1'];
		$values[2] = $this->formdata[$field.'_2'];
		$values[3] = $this->formdata[$field];
		}
		return linkage($linkageid, 'form['.$field.']',1,$ext_code,$values);
	}

	private function linkage_box($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		$string = '';
		if($value) {
			$where = '';
			$value = trim($value,',');
			$values = explode(',',$value);
			$value = $values[0];
			if($value) {
				$rs = $this->db->get_one('linkage_data', array('lid' => $value));
				$pid = $rs['pid'];
				$where = "`pid` = '$pid'";

				$result = $this->db->get_list('linkage_data', $where, '*', 0, 50, 0, 'sort ASC,lid ASC');
				foreach($result as $r) {
				$checked = '';
				if(in_array($r['lid'],$values)) $checked = 'checked';
					$string .= '<label class="checkbox-inline"><input type="checkbox" name="form['.$field.'][]" value="'.$r['lid'].'" '.$checked.'>'.$r['name'].'</label>';
				}
			} else {
				$string .= '请选择所属区域';
			}

		}
		return '<input type="hidden" name="form['.$field.'][]" value="no_value"><div id="'.$field.'_div" class="col-sm-12 input-group">'.$string.'</div>';
	}

	private function number($config, $value) {
		extract($config,EXTR_SKIP);
		if(is_string($setting)) {
			$setting = string2array($setting);
		}
		$size = $setting['size'];
		if($value=='') $value = $setting['defaultvalue'];
		return "<input type='text' name='form[$field]' id='$field' value='$value' class='input-text' size='$size' {$ext_code}>";
	}

	private function point($config, $value) {
		extract($config,EXTR_SKIP);
		return '<input type="text" name="form['.$field.']" id="'.$field.'" value="'.$value.'" class="form-control" style="width: 80px;" > <span style="margin: 8px;display: inline-block;">积分</span>';
	}

	private function powerful($config, $value) {
        extract($config,EXTR_SKIP);
        if(is_array($setting)) extract($setting,EXTR_SKIP);
		$formtext = str_replace('{FIELD_VALUE}',$value,$formtext);
		$formtext = str_replace('{MODELID}',$this->modelid,$formtext);
		preg_match_all('/{FUNC\((.*)\)}/',$formtext,$_match);
		foreach($_match[1] as $key=>$match_func) {
			$string = '';
			$params = explode('~~',$match_func);
			$user_func = $params[0];
			$string = $user_func($params[1]);
			$formtext = str_replace($_match[0][$key],$string,$formtext);
		}
		$id  = $this->id ? $this->id : 0;
		$formtext = str_replace('{ID}',$id,$formtext);
		$errortips = $this->fields[$field]['errortips'];
		return $formtext;
	}

	private function price_group($config, $value) {
        extract($config,EXTR_SKIP);
        if(!isset($style)) $style = '';
        $price = isset($this->formdata[$field]) ? $this->formdata[$field] : '';
        $price_old = isset($this->formdata[$field.'_old']) ? $this->formdata[$field.'_old'] : '';
		$str = '<input type="hidden" name="form['.$field.']" value="1">';
if($GLOBALS['type']==1) {
$str .= '原价：<input type="text" name="'.$field.'_old" id="'.$field.'_old" value="'.$price_old.'"> 现价：<input type="text" name="'.$field.'" id="'.$field.'"  value="'.$price.'">';

} else {
$price_old2 = isset($this->formdata['price_old2']) ? $this->formdata['price_old2'] : '';
$price_old3 = isset($this->formdata['price_old3']) ? $this->formdata['price_old3'] : '';
$price_old4 = isset($this->formdata['price_old4']) ? $this->formdata['price_old4'] : '';
$price2 = isset($this->formdata['price2']) ? $this->formdata['price2'] : '';
$price3 = isset($this->formdata['price3']) ? $this->formdata['price3'] : '';
$price4 = isset($this->formdata['price4']) ? $this->formdata['price4'] : '';
$str .= '<table class="table"><th>人数规模</th><th>原价（单位：元）</th><th>现价（单位：元）</th></tr><tbody><tr><td>10-20人</td><td><input type="text" name="'.$field.'_old" id="'.$field.'_old" value="'.$price_old.'"></td><td><input type="text" name="'.$field.'" id="'.$field.'" value="'.$price.'"></td></tr>
    <tr><td>20-50人</td><td><input type="text" name="form['.$field.'_old2]" id="'.$field.'_old2" value="'.$price_old2.'"></td><td><input type="text" name="form['.$field.'2]" id="'.$field.'2" value="'.$price2.'"></td></tr>
    <tr><td>50-100人</td><td><input type="text" name="form['.$field.'_old3]" id="'.$field.'_old3" value="'.$price_old3.'"></td><td><input type="text" name="form['.$field.'3]" id="'.$field.'3" value="'.$price3.'"></td></tr>
    <tr><td>100人以上</td><td><input type="text" name="form['.$field.'_old4]" id="'.$field.'_old4" value="'.$price_old4.'"></td><td><input type="text" name="form['.$field.'4]" id="'.$field.'4" value="'.$price4.'"></td></tr>
    </tbody></table>';

}
return $str;
	}

	private function slider($config, $value) {
		extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		return '
        <div class="slider-info">
            最小值:
            <span class="slider-info" id="'.$field.'-min-amount">'.$value.'</span>
            <input type="hidden" name="form['.$field.']" id="'.$field.'-name" value="'.$value.'">
        </div>
        <div id="'.$field.'" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 0%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
<script type="text/javascript">
    $(function() {
        $("#'.$field.'").slider({
            range: "min",
            value: '.$value.',
            min: '.$minlength.',
            max: '.$maxlength.',
            slide: function (event, ui) {
                $("#'.$field.'-min-amount").text("" + ui.value);
                $("#'.$field.'-name").val(ui.value);
            }
        });
        $("#'.$field.'-min-amount").text("" + $("#'.$field.'").slider("value"));
    });
</script>
    ';
	}

	private function template($config, $value) {
    if($value=='') {
        $siteid = get_cookie('siteid');
        $models = get_cache('model_content','model');
        $template_set = unserialize($models[$this->modelid]['template_set']);
        $value = $template_set[$siteid];
    }
        extract($config,EXTR_SKIP);
		return $this->form->templates('content',$value,'name="form['.$field.']" id="'.$field.'" class="form-control" style="width:auto;"','show');
	}

	private function text($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		if(!isset($placeholder)) $placeholder = '';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="'.$placeholder.'" value="'.$value.'" class="form-control" '.$ext_code.' >';
	}

	private function text_select($config, $value) {

		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
        $boxtype = isset($boxtype) ? $boxtype : 'select';
		if($value=='') $value = $defaultvalue;
		$options = explode("\n",$options);
		foreach($options as $_k) {
			$v = explode("|",$_k);
			$k = trim($v[1]);
			$option[$k] = $v[0];
		}
		$values = explode(',',$value);
		$value = array();
		foreach($values as $_k) {
			if($_k != '') $value[] = $_k;
		}
		$value = implode(',',$value);
		switch($boxtype) {
			case 'select':
				$string = $this->form->select($option,$value,"name='attr_$field' class='form-control' style='width:auto;' id='$field' $ext_code");
			break;
		}

		return '<div class="col-sm-4 text-left"><input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="'.$placeholder.'" value="'.$value.'" class="form-control" ></div>
'.$string;
	}

	private function textarea($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
        if(!$value) $value = $defaultvalue;
    return '<textarea name="form['.$field.']" class="form-control" cols="60" rows="3" '.$ext_code.'>'.$value.'</textarea>';
	}

private function title($config, $value) {
extract($config,EXTR_SKIP);
if(!isset($style)) $style = '';
$title_css = isset($this->formdata['css']) ? $this->formdata['css'] : '';
$str = '<input type="text" style="color:#'.$title_css.'" name="form['.$field.']" id="'.$field.'" maxlength="'.$maxlength.'" value="'.$value.'" class="form-control" datatype="*'.$minlength.'-'.$maxlength.'"  nullmsg="请输入标题" errormsg="标题至少'.$minlength.'个字符,最多'.$maxlength.'个字符！" onBlur="$.post(\'api.php?op=get_keywords&number=3&sid=\'+Math.random()*5, {data:$(\'#title\').val()}, function(data){if(data && $(\'#keywords\').val()==\'\') $(\'#keywords\').val(data); })" />';
$str .= '<span class="input-group-btn"><input type="hidden" id="title_css" name="title_css" value="'.$title_css.'"><img id="title_color" src="'.R.'js/colorpicker/picker.png" height="30" hx="#c00"></span><span class="input-group-btn"><button class="btn btn-white" type="button" onclick="check_title();">重复检测</button></span>';

return $str;
}

	private function url($config, $value) {
		$size = isset($size) ? $size : 25;
        $route = isset($this->formdata['route']) ? $this->formdata['route'] : 0;
        if($route==1) {
            $def_type = '加密链接';
        } elseif($route==2) {
            $def_type = '外部链接';
        } elseif($route==3) {
            $def_type = '自定义';
        } else {
            $def_type = '默认链接';
        }
if($this->extdata['type']==0 || $this->extdata['type']==3) {
    return '<div class="input-group" style="max-width: 500px;">
    <input type="text" name="url" id="url" value="'.$value.'" size="'.$size.'" maxlength="255" class="form-control" placeholder="可自定义：如，wuzhicms-example'.POSTFIX.'" onBlur="fillurl(this,this.value)">
    <div class="input-group-btn">
        <input type="hidden" value="'.$route.'" id="route_type" name="form[route]">
        <button tabindex="-1" data-toggle="dropdown" aria-expanded="false" class="btn btn-white" type="button" id="def_type">'.$def_type.'</button>
        <button tabindex="-1" data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
            <span class="caret"></span>
        </button>
        <ul role="menu" class="dropdown-menu pull-right">
            <li><a href="javascript:;" onclick="change_route(\'默认链接\',0);">默认链接</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" onclick="change_route(\'加密链接\',1);">加密链接：例如，A4818GL100253B0H'.POSTFIX.'</a></li>
            <li><a href="javascript:;" onclick="change_route(\'外部链接\',2);">外部链接</a></li>
            <li><a href="javascript:;" onclick="change_route(\'自定义\',3);">自定义：例如，wuzhicms-example'.POSTFIX.'</a></li>
        </ul>
    </div>
</div>';
} else {
return '<div style="max-width: 400px;" title="单网页链接地址：请修改该栏目页URL规则">
    <input type="hidden" value="'.$route.'" id="route_type" name="form[route]">
    <input type="text" name="url" id="url" value="'.$value.'" size="'.$size.'" maxlength="255" class="form-control" placeholder="可自定义：如，wuzhicms-example'.POSTFIX.'" onBlur="fillurl(this,this.value)" readonly>
</div>';
}

	}

	private function video_tudou($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;

		if(!isset($placeholder)) $placeholder = '';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="播放页地址/转发地址均可" value="'.$value.'" class="form-control" '.$ext_code.' >';
	}

	private function video_youku($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;

		if(!isset($placeholder)) $placeholder = '';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="播放页地址/转发地址均可" value="'.$value.'" class="form-control" '.$ext_code.' >';
	}

} ?>