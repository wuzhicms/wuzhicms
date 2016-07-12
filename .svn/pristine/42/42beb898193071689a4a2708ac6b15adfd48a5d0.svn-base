<?php exit();?>
private function video_youku($field, $value) {
	if($value=='') return array();
	$return_values = array();
	$return_values['data'] = $value;
	//$value = 'http://v.youku.com/v_show/id_XMTUyNDkxMDU2OA==.html?f=27017556&from=y1.2-3.2';
	//$value = '<iframe height=498 width=510 src="http://player.youku.com/embed/XMTUyNDkxMDU2OA==" frameborder=0 allowfullscreen></iframe>';
	//$value = 'http://player.youku.com/player.php/Type/Folder/Fid/27017556/Ob/1/sid/XMTUyNDkxMDU2OA==/v.swf';
	//$value = '<embed src="http://player.youku.com/player.php/Type/Folder/Fid/27017556/Ob/1/sid/XMTUyNDkxMDU2OA==/v.swf" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>';

	preg_match('/v_show\/id_([A-Za-z0-9=]+).html/is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	preg_match('/embed\/([A-Za-z0-9=]+)"/is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	preg_match('/\/sid\/([A-Za-z0-9=]+)\//is',$value,$_v);
	if($_v[1]) {
		$return_values['url'] = 'http://player.youku.com/embed/'.$_v[1].'&from=wuzhicms';
		$return_values['code'] = $_v[1];
		return $return_values;
	}
	return $return_values;
}
