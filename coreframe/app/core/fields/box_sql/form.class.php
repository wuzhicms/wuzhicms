<?php exit();?>
    private function box_sql($config, $value) {
        extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
        $boxtype = isset($boxtype) ? $boxtype : 'select';
        if($value=='') $value = $defaultvalue;
        $option = array();
        if($boxtype=='select') {
            $option[] = '请选择 ...';
        }
        $res = $this->db->query($sql);
        while($r = $this->db->fetch_array($res)) {
            $option[$r[$field_value]] = $r[$field_name];
        }


        $values = explode(',',$value);
        $value = array();
        foreach($values as $_k) {
            if($_k != '') $value[] = $_k;
        }
        $value = implode(',',$value);
        switch($boxtype) {
            case 'radio'://radio($options = array(), $value = 0, $str = '')
                if($field=='type' && isset($GLOBALS['type']) && $GLOBALS['type']==2) {
                    $value = 2;
                }
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
