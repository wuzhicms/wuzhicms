<?php exit();?>
	private function downfiles($config, $value) {
		if(empty($value)) return '';
		$tmp = array();
		foreach($value as $r) {
			$tmp[] = $r;
		}
		return array2string($tmp);
	}
