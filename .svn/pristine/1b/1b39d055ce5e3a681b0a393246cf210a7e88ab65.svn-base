<?php exit();?>
	private function slider($config, $value) {
		extract($config,EXTR_SKIP);
        extract($setting,EXTR_SKIP);
		if(!$value) $value = $defaultvalue;
		return '
        <div class="slider-info">
            最小值:
            <span class="slider-info" id="'.$field.'-min-amount">'.$value.'</span>
            <input type="hidden" name="form['.$field.']" id="'.$field.'-name" value="'.$value.'">
        </div>
        <div id="'.$field.'" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 0%;"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
<script type="text/javascript">
    $(function() {
        $("#'.$field.'").slider({
            range: "min",
            value: '.$value.',
            min: '.$minlength.',
            max: '.$maxlength.',
            slide: function (event, ui) {
                $("#'.$field.'-min-amount").text("" + ui.value);
                $("#'.$field.'-name").val(ui.value);
            }
        });
        $("#'.$field.'-min-amount").text("" + $("#'.$field.'").slider("value"));
    });
</script>
    ';
	}
