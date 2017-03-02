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

	private function content_group($field, $value) {
		$value = string2array($value);
		return $value;
	}

	private function copyfrom($field, $value){
		if (is_numeric($value)) {
			$r = $this->db->get_one('copyfrom', array('fromid' => $value));
			if ($r['logo']) {
				return '<a href="'.$r['url'].'" target="_blank"><span class="logo_ly"><img src="' . $r['logo'] . '"></span> ' . $r['name'] . '</a>';
			} else {
				return '<a href="'.$r['url'].'" target="_blank">' . $r['name'] . '</a>';
			}
		} elseif (is_string($value)) {
			if (strpos($value, '|') === false) {
				return $value;
			} else {
				$values = explode('|', $value);
				$values[1] = 'http://' . ltrim($values[1], 'http://');
				return '<a href="' . $values[1] . '" target="_blank">' . $values[0] . "</a>";
			}
			return $value;
		}
	}

	private function datetime($field, $value) {
		$setting = $this->fields[$field]['setting'];
		if($setting) extract($setting);
		if($fieldtype=='date' || $fieldtype=='datetime') {
			return $value;
		} else {
			$format_txt = $format;
		}
		if(strlen($format_txt)<6) {
			$isdatetime = 0;
		} else {
			$isdatetime = 1;
		}
		if(!$value) $value = SYS_TIME;
		$value = date($format_txt,$value);
		return $value;
	}

    private function downfile($field, $value) {
        if(empty($value)) return '';
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

    function text_select($field, $value) {
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

	private function title($field, $value) {
		$value = p_htmlentities($value);
		return $value;
	}

	private function video_tudou($field, $value) {
		if($value=='') return array();
		$return_values = array();
		$return_values['data'] = $value;

		//$value = 'http://www.tudou.com/programs/view/F5-QHb0My9Q/';
		preg_match('/view\/([A-Za-z0-9=\-_]+)\//is',$value,$_v);
		if($_v[1]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=0&code='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 0;
			$return_values['code'] = $_v[1];
			$return_values['lcode'] = '';
			return $return_values;
		}

		//$value = 'http://www.tudou.com/albumplay/0At_ddWfzlY/6Kl0I2HOlzQ.html';
		preg_match('/albumplay\/([A-Za-z0-9=\-_]+)\/([A-Za-z0-9=\-_]+)\.html/is',$value,$_v);
		if($_v[2]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=2&code='.$_v[2].'&lcode='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 2;
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[1];
			return $return_values;
		}

		//$value = 'http://www.tudou.com/listplay/YJR-Rdd0nGM/SZb_7cL2E8M/';
		preg_match('/listplay\/([A-Za-z0-9=\-_]+)\/([A-Za-z0-9=\-_]+)\//is',$value,$_v);
		if($_v[2]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=1&code='.$_v[2].'&lcode='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 1;
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[1];
			return $return_values;
		}

		//$value = 'http://www.tudou.com/programs/view/html5embed.action?type=1&code=SkJQ_1zpAMU&lcode=YJR-Rdd0nGM&resourceId=0_';
		$return_values['url'] = $value;
		preg_match('/type=([0-9])\&code=([A-Za-z0-9=\-_]+)\&lcode=([A-Za-z0-9=\-_]+)\&/is',$value,$_v);
		if($_v[1]) {
			$return_values['type'] = $_v[0];
			$return_values['code'] = $_v[1];
			$return_values['lcode'] = $_v[2];
		}

		$value = 'http://www.tudou.com/programs/view/html5embed.action?type=0&code=F5-QHb0My9Q&lcode=&';
		preg_match('/\?type=([0-9])\&code=([A-Za-z0-9=\-_]+)\&lcode=([A-Za-z0-9=\-_]*)\&/is',$value,$_v);
		if($_v[2]) {
			$return_values['type'] = $_v[1];
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[3];
		}

		$return_values['url'] = $value;
		return $return_values;
	}

private function video_youku($field, $value) {
	if($value=='') return array();
	$return_values = array();
	$return_values['data'] = $value;
	//$value = 'http://v.youku.com/v_show/id_XMTUyNDkxMDU2OA==.html?f=27017556&from=y1.2-3.2';
	//$value = '<iframe height=498 width=510 src="http://player.youku.com/embed/XMTUyNDkxMDU2OA==" frameborder=0 allowfullscreen></iframe>';
	//$value = 'http://player.youku.com/player.php/Type/Folder/Fid/27017556/Ob/1/sid/XMTUyNDkxMDU2OA==/v.swf';
	//$value = '<embed src="http://player.youku.com/player.php/Type/Folder/Fid/27017556/Ob/1/sid/XMTUyNDkxMDU2OA==/v.swf" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>';

	preg_match('/v_show\/id_([A-Za-z0-9=]+).html/is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	preg_match('/embed\/([A-Za-z0-9=]+)"/is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	preg_match('/\/sid\/([A-Za-z0-9=]+)\//is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	return $return_values;
}

	private function dymlist($field, $value) {

		return $value;
	}

	private function relation($field, $value) {

		return $value;
	}

} ?>