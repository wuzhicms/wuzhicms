<?php exit();?>
	private function text($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		if(!isset($placeholder)) $placeholder = '';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="'.$placeholder.'" value="'.$value.'" class="form-control" '.$ext_code.' >';
	}
