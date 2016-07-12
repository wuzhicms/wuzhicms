<?php exit();?>
<!--这样的注释，会在合成缓存文件的时候删除-->
	private function text($config, $value) {
		<!--config 为当前字段的配置，例如：要获取当前字段的字段名称，使用：$config['field']-->
		if(!$config['setting']['enablehtml']) $value = strip_tags($value);
		return $value;
	}
