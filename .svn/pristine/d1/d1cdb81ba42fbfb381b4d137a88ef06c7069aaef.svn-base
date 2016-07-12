<?php exit();?>
	private function template($config, $value) {
    if($value=='') {
        $siteid = get_cookie('siteid');
        $models = get_cache('model_content','model');
        $template_set = unserialize($models[$this->modelid]['template_set']);
        $value = $template_set[$siteid];
    }
        extract($config,EXTR_SKIP);
		return $this->form->templates('content',$value,'name="form['.$field.']" id="'.$field.'" class="form-control" style="width:auto;"','show');
	}
