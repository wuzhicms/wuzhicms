<?php exit();?>
	private function block($config, $value) {
        extract($config,EXTR_SKIP);
        $where = "`type`=1 AND `modelid` IN(0,".$this->modelid.")";
        $result = $this->db->get_list('block',$where, 'blockid,name', 0, 100);
        $option = key_value($result,'blockid','name');
        $values = '';
        if($value) {
                $keyid = $this->formdata['id'].'-'.$this->formdata['cid'];
                $block_data = $this->db->get_list('block_data',array('keyid'=>$keyid), '*', 0, 100);
                if(!empty($block_data)) {
                        $option_value = array_keys($option);
                        foreach($block_data as $rs) {

                                if(in_array($rs['blockid'],$option_value)) {
                                        $values[] = $rs['blockid'];
                                }
                        }
                        $values = implode(',',$values);
                }
        }
        $string = $this->form->checkbox($option,$values,"name='form[$field][]' $ext_code",1,$field);
        return $string;
	}
