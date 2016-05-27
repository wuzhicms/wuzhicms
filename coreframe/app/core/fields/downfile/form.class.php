<?php exit();?>
	private function downfile($config, $value) {
        extract($config,EXTR_SKIP);
        return '<div class="input-group">'.$this->form->attachment($setting['upload_allowext'],1,"form[$field]","$value",'callback_thumb_dialog',0).'</div>';
    }
