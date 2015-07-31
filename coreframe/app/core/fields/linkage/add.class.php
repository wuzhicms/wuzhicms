<?php exit();?>
<!--这样的注释，会在合成缓存文件的时候删除-->
	private function linkage($config, $value) {
			$field = $config['field'];
			$linkageid = $config['setting']['linkageid'];
			$values[$field] = $GLOBALS['LK'.$linkageid.'_3'];
			$values[$field.'_1'] = $GLOBALS['LK'.$linkageid.'_1'];
			$values[$field.'_2'] = $GLOBALS['LK'.$linkageid.'_2'];
		return $values;
	}
