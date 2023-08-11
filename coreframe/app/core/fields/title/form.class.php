<?php exit();?>
private function title($config, $value) {
extract($config,EXTR_SKIP);
if(!isset($style)) $style = '';
$title_css = isset($this->formdata['css']) ? $this->formdata['css'] : '';
$str = '<input type="text" style="color:#'.$title_css.'" name="form['.$field.']" id="'.$field.'" maxlength="'.$maxlength.'" value="'.$value.'" class="form-control" datatype="*'.$minlength.'-'.$maxlength.'"  nullmsg="请输入标题" errormsg="标题至少'.$minlength.'个字符,最多'.$maxlength.'个字符！" onBlur="$.post(\'api.php?op=get_keywords&number=3&sid=\'+Math.random()*5, {data:$(\'#title\').val()}, function(data){if(data && $(\'#keywords\').val()==\'\') $(\'#keywords\').val(data); })" />';
$str .= '<span class="input-group-text bg-white p-0 rounded-0"><input type="hidden" id="title_css" name="title_css" value="'.$title_css.'"><img id="title_color" src="'.R.'libs/colorpicker/picker.png" hx="#c00"></span><span class="input-group-text bg-white p-0 rounded-0"><button class="border-0 btn btn-light shadow-none small" type="button" onclick="check_title();">重复检测</button></span><span class="input-group-text bg-white p-0 rounded-0"><button class="border-0 btn btn-light shadow-none small" type="button" onclick="check_charsize(\''.$field.'\');">字数</button></span>';

return $str;
}
