<?php exit();?>
	private function datetime($config, $value) {
        extract($config,EXTR_SKIP);
        if(is_array($setting)) extract($setting,EXTR_SKIP);
		$isdatetime = 0;
		$timesystem = 0;
		if($fieldtype=='int') {
			if(!$value) $value = SYS_TIME;
			$format_txt = $format == 'm-d' ? 'm-d' : $format;
			if($format == 'Y-m-d Ah:i:s') $format_txt = 'Y-m-d h:i:s';
			$value = date($format_txt,$value);
			
			$isdatetime = strlen($format) > 6 ? 1 : 0;
			if($format == 'Y-m-d Ah:i:s') {
				
				$timesystem = 0;
			} else {
				$timesystem = 1;
			}			
		} elseif($fieldtype=='datetime') {
			$isdatetime = 1;
			$timesystem = 1;
		} elseif($fieldtype=='datetime_a') {
			$isdatetime = 1;
			$timesystem = 0;
		}
		if($value=='0000-00-00') $value = '';
		return $this->form->calendar("form[$field]",$value,$isdatetime,1,$timesystem,$ext_code);
	}
