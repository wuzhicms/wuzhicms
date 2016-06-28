<?php exit();?>
	private function group($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        $lists = get_cache('group','member');
        foreach($lists as $_k=>$_v) {
        $data[$_k] = $_v['name'];
        }
		return '<input type="hidden" name="form['.$field.']" value="no_value">'.$this->form->checkbox($data,$value,'name="'.$field.'[]" id="'.$field.'"');
	}
