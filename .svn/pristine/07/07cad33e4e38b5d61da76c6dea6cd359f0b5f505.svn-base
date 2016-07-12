<?php exit();?>
	private function video_tudou($config, $value) {
		$ext = substr($value,-5);
		if($ext=='v.swf') {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $value);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 20);
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$ret = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);

			preg_match('/\&code=([A-Za-z0-9=\-_]+)\&/',$info['url'],$_v);
			preg_match('/\&lCode=([A-Za-z0-9=\-_]+)\&/',$info['url'],$_v2);
			preg_match('/\&listType=([0-9])\&/',$info['url'],$_v3);

			$str = 'http://www.tudou.com/programs/view/html5embed.action?type='.$_v3[1].'&code='.$_v[1].'&lcode='.$_v2[1].'&';
			return $str;
		}

		return $value;
	}
