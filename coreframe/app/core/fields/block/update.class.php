<?php exit();?>
private function block($filed, $value) {
    $block_api = load_class('block_api','content');
    $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
    if($value=='1') {
        $posids = array();
        $value = $GLOBALS['form']['block'];
        foreach($value as $r) {
            if(is_numeric($r)) $posids[] = $r;
        }
        $textcontent = array();
        foreach($this->fields AS $_key=>$_value) {
            if($_value['to_block']) {
                $textcontent[$_key] = $this->formdata[$_key];
            }
        }

        $block_api->update($this->id.'-'.$this->cid.'-'.$_lang, $posids, $textcontent,$this->cid);
    } else {
        $block_api->delete($this->id.'-'.$this->cid.'-'.$_lang);
    }
}
