<?php exit();?>
	private function number($config, $value) {
		extract($config,EXTR_SKIP);
		if(is_string($setting)) {
			$setting = string2array($setting);
		}
		$size = $setting['size'];
		if($value=='') $value = $setting['defaultvalue'];
		return "<input type='text' name='form[$field]' id='$field' value='$value' class='input-text' size='$size' {$ext_code}>";
	}
