<?php exit();?>
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
