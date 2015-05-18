<?php exit();?>
private function block($filed, $value) {
    if($value=='1') {
        $posids = array();
        $value = $GLOBALS['form']['block'];
        $block_api = load_class('block_api','content');
        foreach($value as $r) {
            if(is_numeric($r)) $posids[] = $r;
        }
        $textcontent = array();
        foreach($this->fields AS $_key=>$_value) {
            if($_value['to_block']) {
                $textcontent[$_key] = $this->formdata[$_key];
            }
        }
        $block_api->update($this->id.'-'.$this->cid, $posids, $textcontent,$this->cid);
    }
}
