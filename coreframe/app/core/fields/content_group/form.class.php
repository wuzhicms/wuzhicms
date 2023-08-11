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

	$content_group_div = "at_" . $field;
	$default_multiple = '';

	if ($value && is_array($value)) {
		$keys = array_keys($value);

		$search = array();
		foreach($keys as $key) {
			$search[] = '##'.$key.'##';
		}
		$i = 0;
		foreach ($value[$keys[0]] AS $k => $v) {
			if ($i > 0) $content_group_div .= $i;
			$replace = array();
			foreach($keys as $key) {
				$replace[] = $value[$key][$k];
			}
			$tmp_formtext = str_replace($search,$replace,$formtext);
			$default_multiple .= '<li class="list-group-item align-items-center d-flex justify-content-between" id="li_' . $content_group_div . '">' . $tmp_formtext . '<button class="btn btn-default btn-danger btn-xs btn-sm"  onclick="remove_obj(this);">移除</button></li>';
			$i++;
		}
	} else {
		$default_multiple = '<li class="list-group-item align-items-center d-flex justify-content-between" id="li_' . $content_group_div . '">' . preg_replace('/##([A-Za-z]+)##/', '', $formtext) . '</li>';
	}
	$str2 = '<input type="hidden" name="form[' . $field . ']" value="1"><div id="' . $field . '"><ul id="' . $field . '_ul" class="list-group">' . $default_multiple . '</ul></div>';

	return $str . '<div class="content_group w-100" id="' . $content_group_div . '"><textarea id="text_'.$field.'" style="display:none;">'.preg_replace('/##([A-Za-z]+)##/', '', htmlentities(''.$formtext.'<button class="btn btn-default btn-sm btn-danger btn-xs" onclick="remove_obj(this);">移除</button>')).'</textarea>' . $str2 . '<a class="btn mt-2 btn-sm btn-primary" href="javascript:add_newfile(\'' . $field . '\');" style="display: block;"> + 增加</a></div>';
}
