<?php exit();?>
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