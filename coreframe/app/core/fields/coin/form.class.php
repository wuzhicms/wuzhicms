<?php exit();?>
	private function coin($config, $value) {
		extract($config,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		$type = $ispassword ? 'password' : 'text';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" value="'.$value.'" '.$ext_code.' >';
	}
