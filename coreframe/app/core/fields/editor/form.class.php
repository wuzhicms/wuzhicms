<?php exit();?>
    private function editor($config, $value) {
        $value = p_htmlentities($value);
        extract($config,EXTR_SKIP);
        if($setting) extract($setting,EXTR_SKIP);
        if($minlength>0) {
            $validform = 'datatype="*" nullmsg="请输入'.$name.'" errormsg="'.$name.'不能为空"';
        } else {
            $validform = '';
        }
        if($value && $editor_type=='ckeditor') {
            $value = str_replace('_wuzhicms_page_tag_','<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>',$value);
        }
        if($toolbar=='textarea') {
            return '<textarea name="form['.$field.']" id="'.$field.'" class="form-control" rows="3" boxid="'.$field.'" '.$validform.'>'.$value.'</textarea>';
        } else {
            $style = '';
            if($GLOBALS['editor_type']=='ewebeditor') {
                $style = ' style="display:none;"';
            }
            return '<textarea name="form['.$field.']" id="'.$field.'" boxid="'.$field.'" '.$validform.$style.'>'.$value.'</textarea>'.$this->form->editor($field,$field,'',$toolbar,$editor_type,1);
        }
    }
