<?php exit();?>
	private function powerful($config, $value) {
        extract($config,EXTR_SKIP);
        if(is_array($setting)) extract($setting,EXTR_SKIP);
		$formtext = str_replace('{FIELD_VALUE}',$value,$formtext);
		$formtext = str_replace('{MODELID}',$this->modelid,$formtext);
		preg_match_all('/{FUNC\((.*)\)}/',$formtext,$_match);
		foreach($_match[1] as $key=>$match_func) {
			$string = '';
			$params = explode('~~',$match_func);
			$user_func = $params[0];
			$string = $user_func($params[1]);
			$formtext = str_replace($_match[0][$key],$string,$formtext);
		}
		$id  = $this->id ? $this->id : 0;
		$formtext = str_replace('{ID}',$id,$formtext);
		$errortips = $this->fields[$field]['errortips'];
		return $formtext;
	}
