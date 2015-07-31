<?php exit();?>
<!--这样的注释，会在合成缓存文件的时候删除-->
	private function linkage_box($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
		if(!is_array($value) || empty($value)) return false;
		array_shift($value);
		$value = ','.implode(',', $value).',';
		return $value;
	}
