<?php exit();?>
	private function downfiles($field, $value) {
		if(empty($value)) return '';
		$values = string2array($value);
		$setting = $this->fields[$field]['setting'];
		if($setting['linktype']) {
			if($setting['downloadtype']) {
				return $values;
			} else {
				foreach($values as $k=>$v) {
					$values[$k]['url'] = private_file($v['url']);
				}
				return $values;
			}
		} else {
			foreach($values as $k=>$v) {
				$values[$k] = WEBURL.'index.php?f=down&v=filedown&str='.urlencode(encode($setting['downloadtype'].$v['url']));
			}
			return $values;
		}
	}
