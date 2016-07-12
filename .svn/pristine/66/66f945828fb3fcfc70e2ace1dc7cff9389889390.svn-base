<?php exit();?>
<!--这样的注释，会在合成缓存文件的时候删除-->
	private function baidumap($config, $value) {
		<!--百度地图字段为组合字段，需要返回数组-->
        $field = $config['field'];
        $values[$field.'_x'] = $GLOBALS[$field.'_x'];
        $values[$field.'_y'] = $GLOBALS[$field.'_y'];
        $values[$field.'_zoom'] = $GLOBALS[$field.'_zoom'];
		return $values;
	}
