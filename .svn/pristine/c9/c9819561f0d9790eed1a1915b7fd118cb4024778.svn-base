<?php exit();?>
	private function quyu($config, $value) {
		extract($config,EXTR_SKIP);
        $quyulist = $this->db->get_list('quyu', array('pid'=>$this->cid), '*', 0, 100, 0, 'sort ASC');
        $option = key_value($quyulist,'areaid','name');
        $string = $this->form->select($option,$value,"name='form[$field]' class='form-control' style='width:auto;' id='$field' ");
		return $string;
	}
