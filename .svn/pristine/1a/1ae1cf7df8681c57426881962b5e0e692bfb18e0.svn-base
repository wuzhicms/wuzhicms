<?php exit();?>
	private function text_select($config, $value) {

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
			case 'select':
				$string = $this->form->select($option,$value,"name='attr_$field' class='form-control' style='width:auto;' id='$field' $ext_code");
			break;
		}

		return '<div class="col-sm-4 text-left"><input type="text" name="form['.$field.']" id="'.$field.'" size="'.$size.'" placeholder="'.$placeholder.'" value="'.$value.'" class="form-control" ></div>
'.$string;
	}
