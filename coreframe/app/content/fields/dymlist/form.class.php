<?php exit();?>
private function dymlist($config, $value) {

	if(!$this->id) {
		return "<div class='input-group'>
    <span class='input-group-btn pull-left'>
    <button class='btn btn-white' type='button' disabled>请先添加后再编辑</button>
    </span>
</div>";
	} else {
		$iframeurl = '?m=content&f=dymlist&v=manage&id='.$this->id.'&_su='.$GLOBALS['_su'];

		return "<div class='input-group'>
        <span class='input-group-btn pull-left'>
        <button class='btn btn-white' type='button' onclick='dymlist(\"$iframeurl\");'>人员选取</button>
        </span>
    </div>";
	}
}