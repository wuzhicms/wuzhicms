<?php exit();?>
	private function datetime($field, $value) {
		$setting = $this->fields[$field]['setting'];
		if($setting) extract($setting);
		if($fieldtype=='date' || $fieldtype=='datetime') {
			return $value;
		} else {
			$format_txt = $format;
		}
		if(strlen($format_txt)<6) {
			$isdatetime = 0;
		} else {
			$isdatetime = 1;
		}
		if(!$value) $value = SYS_TIME;
		$value = date($format_txt,$value);
		return $value;
	}
