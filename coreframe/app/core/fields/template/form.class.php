<?php exit();?>
	private function template($config, $value) {
        extract($config,EXTR_SKIP);
		return $this->form->templates('content',$value,'name="form['.$field.']" id="'.$field.'" class="form-control" style="width:auto;"','show');
	}
