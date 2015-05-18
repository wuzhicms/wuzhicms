<?php exit();?>
	private function images($config, $value) {
        if(!empty($value)) $value = string2array($value);
        extract($config,EXTR_SKIP);
$str = '<script>
    $(function() {
        $( "#huanjing_ul" ).sortable();
        $( "#huanjing_ul" ).disableSelection();
    });
</script>';
        return $str.'<div class="attaclist">'.$this->form->attachment("jpg|png|gif|bmp",20,"form[$field]",$value,'callback_more_dialog',0).'</div>';
    }