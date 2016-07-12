<?php exit();?>
	private function copyfrom($config, $value) {
        extract($config,EXTR_SKIP);
		$copyfrom_array = $this->db->get_list('copyfrom', '', '*', 0, 1000);
        $copyfrom_array = key_value($copyfrom_array,'fromid','name');
        $holder = '演示站点|www.wuzhicms.com';
		return "<div class='col-sm-4 input-group pull-left'><input type='text' id='$field' name='form[$field]' placeholder='$holder' value='$value' class='form-control input-text'></div><div class='col-sm-4'>".$this->form->select($copyfrom_array,$value,"name='{$field}_data' class='form-control' onchange='change_value(\"$field\",this.value)'","选择已有来源")."</div>";
	}
