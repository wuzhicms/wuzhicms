<?php exit();?>
	private function link_content($config, $value) {
		extract($config,EXTR_SKIP);
        $models = get_cache('model_content','model');
        $mastertable = $models[$setting['modelid']]['master_table'];
        if($setting['enable']) {
            $where = array('status'=>9,'glpp'=>intval($GLOBALS['cid']));
        } else {
            $where = array('status'=>9);
        }
        $quyulist = $this->db->get_list($mastertable, $where, '*', 0, 100, 0, 'sort DESC');
        $option = key_value($quyulist,'id','title');
        $areaid = $this->formdata['areaid'];
        $fuwuid = $this->formdata['fuwu'];
        $string = $this->form->select($option,$value,"name='form[$field]' class='form-control' style='width:auto;' id='$field' onchange='getareaid(this.value)'",'请选择体检分院')."<input id='areaid' value='$areaid' name='form[areaid]' type='text'><input id='fuwuid' value='$fuwuid' name='form[fuwu]' type='text'>";
		return $string;
	}
