<?php
/**
 * 内容输出格式化
 */
class form_format {
    var $modelid;
    var $fields;
    var $formdata;
    var $extdata;//扩展数据，用于额外的参数传递，赋值方法：$form_add->extdata['mykey'] = 'data'
    var $id;//内容id

	function __construct($modelid) {
        $this->db = load_class('db');
        $this->tablepre = $this->db->tablepre;
        $this->modelid = $modelid;
        $this->fields = get_cache('field_'.$modelid,'model');
        $this->extdata = '';
        //TODO 初始化勾子，在程序提交前处理
    }
	function execute($formdata) {
        $this->formdata = $formdata;
		$this->id = $formdata['id'];
		$info = array();
        foreach($formdata as $field=>$value) {
            $field_config = $this->fields[$field];
            $func = $field_config['formtype'];
            $value = $formdata[$field];
            $result = method_exists($this, $func) ? $this->$func($field, $formdata[$field]) : $formdata[$field];
            if($result !== false) {
                $info[$field]['name'] = isset($field_config['name']) ? $field_config['name'] : $field;
                $info[$field]['data'] = $result;
            }
        }

		return $info;
	}
    function set_config($modelid) {
        $this->modelid = $modelid;
        $this->fields = get_cache('field_'.$modelid,'model');
    }

	private function baidumap($field, $value) {
		$value = p_htmlentities($value);
		return $value;
	}

    function box($field, $value) {
        extract($this->fields[$field]['setting']);
        if($outputtype) {
            return $value;
        } else {
            $options = explode("\n",$options);
            foreach($options as $_k) {
                $v = explode("|",$_k);
                $k = trim($v[1]);
                $option[$k] = $v[0];
            }
            $string = '';
            switch($boxtype) {
                case 'radio':
                    $string = $option[$value];
                    break;

                case 'checkbox':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;

                case 'select':
                    $string = $option[$value];
                    break;

                case 'multiple':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;
            }
            return $string;
        }
    }

    function box_sql($field, $value) {
        extract($this->fields[$field]['setting']);
        if($outputtype) {
            return $value;
        } else {
            $options = explode("\n",$options);
            foreach($options as $_k) {
                $v = explode("|",$_k);
                $k = trim($v[1]);
                $option[$k] = $v[0];
            }
            $string = '';
            switch($boxtype) {
                case 'radio':
                    $string = $option[$value];
                    break;

                case 'checkbox':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;

                case 'select':
                    $string = $option[$value];
                    break;

                case 'multiple':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;
            }
            return $string;
        }
    }

    private function copyfrom($field, $value) {
        if(is_numeric($value)) {
            $r = $this->db->get_one('copyfrom',array('fromid'=>$value));
            if(defined('IN_PACKAGE')) {
                if($r['logo']) {
                return '<a href="#/resources/'.$r['name'].'"><span class="logo_ly"><img src="'.$r['logo'].'"></span> '.$r['name'].'</a>';
                } else {
                return '<a href="#/resources/'.$r['name'].'">'.$r['name'].'</a>';
                }
            } else {
                $cid = intval($GLOBALS['cid']);
                $cr = $this->db->get_one('category',array('cid'=>$cid),'siteid');
                if($r['logo']) {
                    return '<a href="/index.php?f=copyfrom&id='.$value.'&siteid='.$cr['siteid'].'" target="_blank"><span class="logo_ly"><img src="'.$r['logo'].'"></span> '.$r['name'].'</a>';
                } else {
                    return '<a href="/index.php?f=copyfrom&id='.$value.'&siteid='.$cr['siteid'].'" target="_blank">'.$r['name'].'</a>';
                }
            }


        } elseif(is_string($value)) {
            if(strpos($value,'|')===false) {
                return $value;
            } else {
                $values = explode('|',$value);
                $values[1] = 'http://'.ltrim($values[1],'http://');
                return '<a href="'.$values[1].'" target="_blank">'.$values[0]."</a>";
            }
            return $value;
        }
    }

    private function downfile($field, $value) {
        $setting = $this->fields[$field]['setting'];
        if($setting['linktype']) {
            if($setting['downloadtype']) {
                return $value;
            } else {
                return private_file($value);
            }
        } else {
            return WEBURL.'index.php?f=down&v=filedown&str='.urlencode(encode($setting['downloadtype'].$value));
        }
    }

	private function images($field, $value) {
		$value = string2array($value);
		return $value;
	}

	private function keyword($field, $value) {
	    if($value == '') return '';
        $value = p_htmlentities($value);
        $tags = explode(',', $value);
		return $tags;
	}

	private function price_group($field, $value) {
		return $value;
	}

	private function title($field, $value) {
		$value = p_htmlentities($value);
		return $value;
	}

	private function relation($field, $value) {

		return $value;
	}

} ?>