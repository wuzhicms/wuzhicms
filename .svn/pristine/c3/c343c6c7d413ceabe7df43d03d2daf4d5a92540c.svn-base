<?php exit();?>
	private function box($config, $value) {
		extract($config,EXTR_SKIP);
		extract($setting,EXTR_SKIP);
        $boxtype = isset($boxtype) ? $boxtype : 'select';
		if($value=='') $value = $defaultvalue;
		$options = explode("\n",$options);
		foreach($options as $_k) {
			$v = explode("|",$_k);
			$k = trim($v[1]);
			$option[$k] = $v[0];
		}
		$values = explode(',',$value);
		$value = array();
		foreach($values as $_k) {
			if($_k != '') $value[] = $_k;
		}
		$value = implode(',',$value);
		switch($boxtype) {
			case 'radio':
				$string = $this->form->radio($option,$value,"name='form[$field]' $ext_code",$field);
			break;

			case 'checkbox':
				$string = $this->form->checkbox($option,$value,"name='form[$field][]' $ext_code",1,$field);
			break;

			case 'select':
				$string = $this->form->select($option,$value,"name='form[$field]' class='form-control' style='width:auto;' id='$field' $ext_code");
			break;

			case 'multiple':
				$string = $this->form->select($option,$value,"name='form[$field][]' id='$field ' size=2 multiple='multiple' style='height:60px;' $ext_code");
			break;
		}
		return $string;
	}
