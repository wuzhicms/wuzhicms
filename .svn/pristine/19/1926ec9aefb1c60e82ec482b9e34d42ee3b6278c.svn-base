<?php exit();?>
	private function text_select($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        if($boxtype == 'checkbox') {
            if(!is_array($value) || empty($value)) return false;
            array_shift($value);
            $value = ','.implode(',', $value).',';
            return $value;
        } elseif($boxtype == 'multiple') {
            if(is_array($value) && count($value)>0) {
            $value = ','.implode(',', $value).',';
            return $value;
        }
        } else {
            return $value;
        }
	}
