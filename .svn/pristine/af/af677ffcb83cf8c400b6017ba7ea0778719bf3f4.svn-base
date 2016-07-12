<?php exit();?>
	private function price_group($config, $value) {
        extract($config,EXTR_SKIP);
        if(!isset($style)) $style = '';
        $price = isset($this->formdata[$field]) ? $this->formdata[$field] : '';
        $price_old = isset($this->formdata[$field.'_old']) ? $this->formdata[$field.'_old'] : '';
		$str = '<input type="hidden" name="form['.$field.']" value="1">';
if($GLOBALS['type']==1) {
$str .= '原价：<input type="text" name="'.$field.'_old" id="'.$field.'_old" value="'.$price_old.'"> 现价：<input type="text" name="'.$field.'" id="'.$field.'"  value="'.$price.'">';

} else {
$price_old2 = isset($this->formdata['price_old2']) ? $this->formdata['price_old2'] : '';
$price_old3 = isset($this->formdata['price_old3']) ? $this->formdata['price_old3'] : '';
$price_old4 = isset($this->formdata['price_old4']) ? $this->formdata['price_old4'] : '';
$price2 = isset($this->formdata['price2']) ? $this->formdata['price2'] : '';
$price3 = isset($this->formdata['price3']) ? $this->formdata['price3'] : '';
$price4 = isset($this->formdata['price4']) ? $this->formdata['price4'] : '';
$str .= '<table class="table"><th>人数规模</th><th>原价（单位：元）</th><th>现价（单位：元）</th></tr><tbody><tr><td>10-20人</td><td><input type="text" name="'.$field.'_old" id="'.$field.'_old" value="'.$price_old.'"></td><td><input type="text" name="'.$field.'" id="'.$field.'" value="'.$price.'"></td></tr>
    <tr><td>20-50人</td><td><input type="text" name="form['.$field.'_old2]" id="'.$field.'_old2" value="'.$price_old2.'"></td><td><input type="text" name="form['.$field.'2]" id="'.$field.'2" value="'.$price2.'"></td></tr>
    <tr><td>50-100人</td><td><input type="text" name="form['.$field.'_old3]" id="'.$field.'_old3" value="'.$price_old3.'"></td><td><input type="text" name="form['.$field.'3]" id="'.$field.'3" value="'.$price3.'"></td></tr>
    <tr><td>100人以上</td><td><input type="text" name="form['.$field.'_old4]" id="'.$field.'_old4" value="'.$price_old4.'"></td><td><input type="text" name="form['.$field.'4]" id="'.$field.'4" value="'.$price4.'"></td></tr>
    </tbody></table>';

}
return $str;
	}
