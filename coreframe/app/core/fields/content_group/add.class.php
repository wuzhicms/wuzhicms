<?php exit();?>
	private function content_group($config, $value) {
		$field = $config['field'];
			if(!empty($GLOBALS[$field])) {
			return array2string($GLOBALS[$field]);
		}
	}
