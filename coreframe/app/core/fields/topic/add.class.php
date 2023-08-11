<?php exit();?>
	private function topic($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        return $value;
	}
