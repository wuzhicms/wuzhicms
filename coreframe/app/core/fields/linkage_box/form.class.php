<?php exit();?>
	private function linkage_box($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		$string = '';
		if($value) {
			$where = '';
			$value = trim($value,',');
			$values = explode(',',$value);
			$value = $values[0];
			if($value) {
				$rs = $this->db->get_one('linkage_data', array('lid' => $value));
				$pid = $rs['pid'];
				$where = "`pid` = '$pid'";

				$result = $this->db->get_list('linkage_data', $where, '*', 0, 50, 0, 'sort ASC,lid ASC');
				foreach($result as $r) {
				$checked = '';
				if(in_array($r['lid'],$values)) $checked = 'checked';
					$string .= '<label class="checkbox-inline"><input type="checkbox" name="form['.$field.'][]" value="'.$r['lid'].'" '.$checked.'>'.$r['name'].'</label>';
				}
			} else {
				$string .= '请选择所属区域';
			}

		}
		return '<input type="hidden" name="form['.$field.'][]" value="no_value"><div id="'.$field.'_div" class="col-sm-12 input-group">'.$string.'</div>';
	}
