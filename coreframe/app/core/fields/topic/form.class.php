<?php exit();?>
private function topic($config, $value) {
	extract($config,EXTR_SKIP);
	extract($setting,EXTR_SKIP);
	$iframeurl = '?m=content&f=topic_content&v=manage&cid='.$GLOBALS['cid'];
	$tcidform = '';
	if($value) {
		$data =$this->db->get_one('topic_content', array('tcid'=>$value));
		$topic_data = $this->db->get_one('topic', array('tid' => $data['tid']));
		$tcidform = '【'.$data['kid1name'];
		if($data['kid2name']) $tcidform .= ' - '.$data['kid2name'];
		$tcidform .= '】'.$topic_data['name'];
	}
	$string = "<div class='input-group'>
		<input type='hidden' name='form[tcid]' id='tcid' value='$value' >
		<input type='text' name='search' id='tcidform' class='form-control' value='$tcidform' style='width: 300px;' readonly>
		<span class='input-group-btn pull-left'>
		<button class='btn btn-white' type='button' onclick='topic_content_add(\"$iframeurl\");'>选择专题</button>
		</span>
		</div>";
	return $string;
}
