<?php exit();?>
	private function baidumap($config, $value) {
        extract($config,EXTR_SKIP);
        if(!isset($style)) $style = '';
        $x = isset($this->formdata[$field.'_x']) ? $this->formdata[$field.'_x'] : '';
        $y = isset($this->formdata[$field.'_y']) ? $this->formdata[$field.'_y'] : '';
        $zoom = isset($this->formdata[$field.'_zoom']) ? $this->formdata[$field.'_zoom'] : '';
		$str = '<input type="hidden" name="form['.$field.']" value="1"> X 坐标：<input type="text" name="'.$field.'_x" id="'.$field.'_x" value="'.$x.'"> Y 坐标：<input type="text" name="'.$field.'_y" id="'.$field.'_y"  value="'.$y.'"> 层级：<input type="text" name="'.$field.'_zoom" id="'.$field.'_zoom"  value="'.$zoom.'">';
        $str .= '<span class="input-group-btn"><button class="btn btn-white" type="button" onclick="baidumap(\''.$field.'\');">打开地图标注</button></span>';
		return $str;
	}
