<?php exit();?>
	private function video_tudou($config, $value) {
		extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;

		if(!isset($placeholder)) $placeholder = '';
		return '<input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="播放页地址/转发地址均可" value="'.$value.'" class="form-control" '.$ext_code.' >';
	}
