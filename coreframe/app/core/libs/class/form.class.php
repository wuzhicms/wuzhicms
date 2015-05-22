<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 表单类
 */
class WUZHI_form {
	public static function editor($name = 'content', $editname = 'content', $value = '', $toolbars = '') {
		if(!defined('IN_ADMIN')) $toolbars = 'basic';
		$str = '';
		$str .= '<script id="'.$editname.'" name="'.$name.'" type="text/plain">'.$value.'</script>';
		if(!defined('UEDITOR')) {
			define('UEDITOR',TRUE);

			//$str .= '<script type="text/javascript">';
			//$str .= 'window.UEDITOR_HOME_URL="'.R.'js/ueditor/";';
			//$str .= '</script>';
			$str .= '<script type="text/javascript" src="'.R.'js/ueditor/ueditor.config.js"></script>';
    		$str .= '<script type="text/javascript" src="'.R.'js/ueditor/ueditor.all.min.js"></script>';
		}
    	
    	$str .= '<script type="text/javascript">';
      
		$str .= 'var ue = UE.getEditor("'.$editname.'", {';
		if($toolbars=='basic') {
	    	$str .= 'toolbars: [';
	   		$str .= "['fullscreen', 'undo', 'redo', 'bold','italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'forecolor', 'backcolor',
             'fontfamily', 'fontsize',
            'justifyleft', 'justifycenter', 'justifyright',
            'link', 'unlink','simpleupload','inserttable']";
	    	$str .= '],';
		}elseif($toolbars=='normal') {
            $str .= 'toolbars: [';
            $str .= "['fullscreen', 'source', 'undo', 'redo',
            'bold', 'italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain',  'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist',
            'rowspacingtop', 'rowspacingbottom', 'lineheight',
             'fontfamily', 'fontsize', 'indent',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'insertvideo', 'music', 'attachment', 'map','|','inserttable', 'deletetable', 'insertparagraphbeforetable','insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols','pagebreak']";
            $str .= '],';
        }
	    $str .= 'autoHeightEnabled: false,';
	    $str .= 'autoFloatEnabled: false';
		$str .= '});';
		$str .= '</script>';
		return $str;
	}
/**
 * 日历控件
 * 
 * @param $name 控件name，id
 * @param $value 选中值
 * @param $datetype 为TRUE时，同时显示时间
 * @param $loadjs 是否重复加载js，防止页面程序加载不规则导致的控件无法显示
 * @param $showweek 是否显示周，使用，true | false
 */
	public static function calendar($name, $value = '', $datetype = FALSE, $loadjs = FALSE, $showweek = 'false') {
		if($value == '0000-00-00 00:00:00') $value = '';
		$id = preg_match("/\[(.*)\]/", $name, $m) ? $m[1] : $name;
		if($datetype) {
			$format = '%Y-%m-%d %H:%M:%S';
			$showtime = 'true';
		} else {
			$format = '%Y-%m-%d';
			$showtime = 'false';
		}
		$str = '';
		$_lang = LANG ==='zh-cn' ? 'cn' : 'en';

		if($loadjs || !defined('CALENDAR_INIT')) {
			define('CALENDAR_INIT', 1);
			$str .= '<link rel="stylesheet" type="text/css" href="'.R.'js/calendar/css/jscal2.css"/>
			<link rel="stylesheet" type="text/css" href="'.R.'js/calendar/css/border-radius.css"/>
			<script type="text/javascript" src="'.R.'js/calendar/jscal2.js"></script>
			<script type="text/javascript" src="'.R.'js/calendar/lang/'.$_lang.'.js"></script>';
		}
		$str .= '<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="date" >&nbsp;';
		$str .= '<script type="text/javascript">
			Calendar.setup({
			weekNumbers: '.$showweek.',
		    inputField : "'.$id.'",
		    trigger    : "'.$id.'",
		    dateFormat: "'.$format.'",
		    showTime: '.$showtime.',
		    minuteStep: 1,
		    onSelect   : function() {this.hide();}
			});
        </script>';
		return $str;
	}

	//文件上传
	public static function upload($insert_file_callback = "insert_file") {
		if(!defined('PUPLOAD_INIT')) {
			define('PUPLOAD_INIT',TRUE);
			$str = '';
			$str .= '<script type="text/javascript" src="'.R.'js/json2.js"></script>';
			$str .= '<script type="text/javascript" src="'.R.'js/html5upload/plupload.full.min.js"></script>';
			$str .= '<script type="text/javascript" src="'.R.'js/html5upload/extension.js"></script>';
		}
		echo $str;
		include T('attachment','upload','default');
		$data = ob_get_contents();
		ob_end_clean();
		return $data;
	}

	 /**
	 * 附件上传
	 *
	 * @author tuzwu
	 * @createtime
	 * @modifytime
	 * @param bool $is_thumb 是否为缩略图,这里需要直接显示缩略图片
	 * @return
	 */
	public static function attachment($ext = 'png|jpg|gif|doc|docx', $limit = 1, $formname = 'file', $default_val = '' ,$callback = 'callback_thumb_dialog', $is_thumb = 0, $width = '', $height = '',$cut = 0)
	{
        if($ext=='') $ext = 'png|jpg|gif|doc|docx';
        $id = preg_match("/\[(.*)\]/", $formname, $m) ? $m[1] : $formname;
		$str = '';
		if(!defined('PUPLOAD_INIT')) 	
		{
			define('PUPLOAD_INIT',TRUE);
			$str = '<script src="'.R.'js/dialog/dialog-plus.js"></script>';
			$str .= '<script type="text/javascript" src="'.R.'js/json2.js"></script>';
			$str .= '<script type="text/javascript" src="'.R.'js/html5upload/plupload.full.min.js"></script>';
			$str .= '<script type="text/javascript" src="'.R.'js/html5upload/extension.js"></script>';
		}
		$limit = $limit ? $limit : 1;
		if($is_thumb) $limit = 1;
		if($limit == 1)
		{

			if($is_thumb)
			{
                $input_type = 'hidden';
				$default_thumb = $default_val ? $default_val : R.'images/upload-thumb.png';
				$thumb_w = $width ? $width : '135';
				$thumb_h = $height ? $height : '113';
				$str .= '<img class="attachment_thumb" id="'.$id.'_thumb" src="'.$default_thumb.'" onclick="img_view(this.src);"  width="'.$thumb_w.'" height="'.$thumb_h.'" />';
			} else {
                $input_type = 'text';
            }

			$str .= '<input type="'.$input_type.'" value="'.$default_val.'" ondblclick="img_view(\'?m=core&f=image_privew&imgurl=\'+this.value);" class="form-control" id="'.$id.'" name="'.$formname.'" size="100">';
		}
		else //多文件上传,需要借助回调生成多个框
		{
			$default_multiple = '';
			if($default_val && is_array($default_val))
			{
				foreach($default_val AS $k=>$v)
				{
					$default_multiple .= '<li id="file_node_'.$k.'"><input type="hidden" name="'.$formname.'['.$k.'][url]" value="'.$v['url'].'"> <img src="'.$v['url'].'" alt="'.$v['alt'].'" onclick="img_view(this.src);"> <textarea name="'.$formname.'['.$k.'][alt]" >'.$v['alt'].'</textarea> <a class="btn btn-danger btn-xs" href="javascript:remove_file('.$k.');">移除</a></li>';
				}
			}
		    $str .= '<div id="'.$id.'"><ul id="'.$id.'_ul">'.$default_multiple.'</ul></div>';
		}
        $token = md5($ext._KEY);
		$up_url = '/index.php'. link_url( array('m'=>'attachment','f'=>'index','v'=>'upload_dialog','callback'=>$callback,'htmlid'=>$id,'_su'=>'','limit'=>$limit,'is_thumb'=>$is_thumb,'width'=>$width,'height'=>$height,'htmlname'=>$formname,'ext'=>$ext,'token'=>$token,'cut'=>$cut) );
		$str .= '<span class="input-group-btn"><button type="button" class="btn btn-white" onclick="openiframe(\''.$up_url.'\',\''.$id.'\',\'loading...\',810,400,'.$limit.')">上传文件</button></span>';
		return $str;
	}

	// select 选项
	public static function select($options = array(), $value = 0, $str = '', $default_option = '') {
		$string = '<select '.$str.'>';
		$default_selected = (empty($value) && $default_option) ? 'selected' : '';
		if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
        if(is_array($options) && count($options) > 0)  {
            foreach($options as $key=>$v) {
                $selected = $key==$value ? 'selected' : '';
                $string .= '<option value="'.$key.'" '.$selected.'>'.$v.'</option>';
            }
        }
		$string .= '</select>';
		return $string;
	}

	//树形下拉选择
	public static function tree_select($options = array(), $value = 0, $str = '', $default_option = '',$disableid = 0) {
		if(!is_array($options)) return '';
        if(empty($options)) {
            $string = '<select '.$str.'>';
            $default_selected = (empty($value) && $default_option) ? 'selected' : '';
            if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
            $string .= '</select>';
            return $string;
        }
        if($value) {
            $options[$value]['selected'] = 'selected';
        }
        $temps = $disableid ? array($disableid) : array();
        foreach($options as $_op) {
            if($_op['cid']==$disableid || in_array($_op['pid'],$temps)) {
                $options[$_op['cid']]['disable'] = 'disabled';
                $temps[$_op['cid']] = $_op['cid'];
            } else {
                $options[$_op['cid']]['disable'] = '';
            }
        }

		$string = '<select '.$str.'>';
		$default_selected = (empty($value) && $default_option) ? 'selected' : '';
		if($default_option) $string .= "<option value='' $default_selected>$default_option</option>";
        $tree = load_class('tree','core',$options);
        $str = "<option value=\$id \$selected \$disable>\$spacer\$name</option>";
        $string .= $tree->create(0,$str);
		$string .= '</select>';
		return $string;
	}

    public static function templates($m, $value = '',$str = '',$fix = '') {
        $tems = select_template($m);
        $string = '';
        $string .= '<select '.$str.'>';
        $string .= '<option value="">默认</option>';
        foreach($tems as $project=>$tpls) {
			if(!is_array($tpls)) continue;
            foreach($tpls as $tpl) {
                $selected = '';
                $v = $project.':'.substr($tpl,0,-5);
                if($value==$v) $selected = 'selected';
                $string .= '<option '.$selected.' value="'.$v.'">'.$project.':'.$tpl."</option>";
            }
        }
        $string .= '</select>';

        return $string;
    }

    public static function radio($options = array(), $value = 0, $str = '') {
        $string = '';
        foreach($options as $key=>$v) {
            $checked = $key==$value ? 'checked' : '';
            $string .= ' <label style="padding-right:10px;"><input type="radio" '.$str.' value="'.$key.'" '.$checked.'> '.$v.'</label>';
        }
        return $string;
    }
    public static function checkbox($array = array(), $value = '', $str = '', $default = '',$field = '') {
        $string = '';
        $value = trim($value);
        if($value != '') $value = strpos($value, ',') ? explode(',', $value) : array($value);
        if($default) $string .= '<input type="hidden" '.$str.' value="no_value">';
        $i = 1;
        foreach($array as $key=>$v) {
            $key = trim($key);
            $checked = ($value && in_array($key, $value)) ? 'checked' : '';
            $string .= '<label style="padding-right:10px;"><input type="checkbox" '.$str.' id="'.$field.'_'.$i.'" '.$checked.' value="'.p_htmlspecialchars($key).'"> '.p_htmlspecialchars($v)."</label>";
            $i++;
        }
        return $string;
    }

}