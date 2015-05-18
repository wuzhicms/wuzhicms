<?php exit();?>
	private function relation($config, $value) {
         extract($config,EXTR_SKIP);
         if(is_array($setting)) extract($setting,EXTR_SKIP);
		if(!$value && isset($defaultvalue)) $value = $defaultvalue;
$iframeurl = '?m=content&f=relation&v=manage&cid='.$GLOBALS['cid'].'&_su='.$GLOBALS['_su'];
		return "<div class='input-group'>
    <input type='hidden' name='form[relation]' id='relation' value='$value' >
    <input type='text' name='search' id='relation_search' class='form-control' style='width: 200px;'>
<span class='input-group-btn pull-left'>
<button class='btn btn-white' type='button' onclick='relation_add(\"$iframeurl\");'>搜索</button>
</span>
</div>
<div class='tasks-widget'>
    <ul class='task-list' id='relation_result'></ul>
</div>
";
	}
