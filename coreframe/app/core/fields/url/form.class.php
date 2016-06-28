<?php exit();?>
	private function url($config, $value) {
		$size = isset($size) ? $size : 25;
        $route = isset($this->formdata['route']) ? $this->formdata['route'] : 0;
        if($route==1) {
            $def_type = '加密链接';
        } elseif($route==2) {
            $def_type = '外部链接';
        } elseif($route==3) {
            $def_type = '自定义';
        } else {
            $def_type = '默认链接';
        }
if($this->extdata['type']==0 || $this->extdata['type']==3) {
    return '<div class="input-group" style="max-width: 500px;">
    <input type="text" name="url" id="url" value="'.$value.'" size="'.$size.'" maxlength="255" class="form-control" placeholder="可自定义：如，wuzhicms-example'.POSTFIX.'" onBlur="fillurl(this,this.value)">
    <div class="input-group-btn">
        <input type="hidden" value="'.$route.'" id="route_type" name="form[route]">
        <button tabindex="-1" data-toggle="dropdown" aria-expanded="false" class="btn btn-white" type="button" id="def_type">'.$def_type.'</button>
        <button tabindex="-1" data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">
            <span class="caret"></span>
        </button>
        <ul role="menu" class="dropdown-menu pull-right">
            <li><a href="javascript:;" onclick="change_route(\'默认链接\',0);">默认链接</a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" onclick="change_route(\'加密链接\',1);">加密链接：例如，A4818GL100253B0H'.POSTFIX.'</a></li>
            <li><a href="javascript:;" onclick="change_route(\'外部链接\',2);">外部链接</a></li>
            <li><a href="javascript:;" onclick="change_route(\'自定义\',3);">自定义：例如，wuzhicms-example'.POSTFIX.'</a></li>
        </ul>
    </div>
</div>';
} else {
return '<div style="max-width: 400px;" title="单网页链接地址：请修改该栏目页URL规则">
    <input type="hidden" value="'.$route.'" id="route_type" name="form[route]">
    <input type="text" name="url" id="url" value="'.$value.'" size="'.$size.'" maxlength="255" class="form-control" placeholder="可自定义：如，wuzhicms-example'.POSTFIX.'" onBlur="fillurl(this,this.value)" readonly>
</div>';
}

	}
