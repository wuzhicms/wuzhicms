<?php exit();?>
	private function linkage($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		if(V=='add') {
		$value = explode(',',$value);
		$values[1] = $value[0];
		$values[2] = $value[1];
		$values[3] = $this->formdata[$field];
		} else {
		$values[1] = $this->formdata[$field.'_1'];
		$values[2] = $this->formdata[$field.'_2'];
		$values[3] = $this->formdata[$field];
		}
		return linkage($linkageid, 'form['.$field.']',1,$ext_code,$values);
	}
