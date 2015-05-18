<?php exit();?>
	private function price_group($config, $value) {
		<!--价格群组字段为组合字段，需要返回数组-->
        $field = $config['field'];
        $values[$field] = $GLOBALS[$field];
        $values[$field.'_old'] = $GLOBALS[$field.'_old'];

		return $values;
	}
