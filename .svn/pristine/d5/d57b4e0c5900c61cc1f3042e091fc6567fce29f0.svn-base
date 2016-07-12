<?php exit();?>
	private function datetime($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
		if($fieldtype=='int') {
			$value = strtotime($value);
		}
		return $value;
	}
