<?php exit();?>
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