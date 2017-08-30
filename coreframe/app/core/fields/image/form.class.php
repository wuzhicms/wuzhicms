<?php exit();?>
	private function image($config, $value) {
        extract($config,EXTR_SKIP);
        if(defined('IN_ADMIN')) {
            $show_type = 0;
        } else {
            $show_type = intval($setting['member_show_type']);
        }
        return '<div class="input-group">'.$this->form->attachment($setting['upload_allowext'],1,"form[$field]","$value","callback_thumb_dialog",$show_type,$setting['images_width'],$setting['images_height'],$setting['images_cut'],$setting['is_water'],$setting['is_allow_show_img'],$ext_code,1).'</div>';
    }
