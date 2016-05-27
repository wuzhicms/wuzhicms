<?php exit();?>
	private function video_tudou($field, $value) {
		if($value=='') return array();
		$return_values = array();
		$return_values['data'] = $value;

		//$value = 'http://www.tudou.com/programs/view/F5-QHb0My9Q/';
		preg_match('/view\/([A-Za-z0-9=\-_]+)\//is',$value,$_v);
		if($_v[1]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=0&code='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 0;
			$return_values['code'] = $_v[1];
			$return_values['lcode'] = '';
			return $return_values;
		}

		//$value = 'http://www.tudou.com/albumplay/0At_ddWfzlY/6Kl0I2HOlzQ.html';
		preg_match('/albumplay\/([A-Za-z0-9=\-_]+)\/([A-Za-z0-9=\-_]+)\.html/is',$value,$_v);
		if($_v[2]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=2&code='.$_v[2].'&lcode='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 2;
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[1];
			return $return_values;
		}

		//$value = 'http://www.tudou.com/listplay/YJR-Rdd0nGM/SZb_7cL2E8M/';
		preg_match('/listplay\/([A-Za-z0-9=\-_]+)\/([A-Za-z0-9=\-_]+)\//is',$value,$_v);
		if($_v[2]) {
			$return_values['url'] = 'http://www.tudou.com/programs/view/html5embed.action?type=1&code='.$_v[2].'&lcode='.$_v[1].'&from=wuzhicms';
			$return_values['type'] = 1;
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[1];
			return $return_values;
		}

		//$value = 'http://www.tudou.com/programs/view/html5embed.action?type=1&code=SkJQ_1zpAMU&lcode=YJR-Rdd0nGM&resourceId=0_';
		$return_values['url'] = $value;
		preg_match('/type=([0-9])\&code=([A-Za-z0-9=\-_]+)\&lcode=([A-Za-z0-9=\-_]+)\&/is',$value,$_v);
		if($_v[1]) {
			$return_values['type'] = $_v[0];
			$return_values['code'] = $_v[1];
			$return_values['lcode'] = $_v[2];
		}

		$value = 'http://www.tudou.com/programs/view/html5embed.action?type=0&code=F5-QHb0My9Q&lcode=&';
		preg_match('/\?type=([0-9])\&code=([A-Za-z0-9=\-_]+)\&lcode=([A-Za-z0-9=\-_]*)\&/is',$value,$_v);
		if($_v[2]) {
			$return_values['type'] = $_v[1];
			$return_values['code'] = $_v[2];
			$return_values['lcode'] = $_v[3];
		}

		$return_values['url'] = $value;
		return $return_values;
	}
