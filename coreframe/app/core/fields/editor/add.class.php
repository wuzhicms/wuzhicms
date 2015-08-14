<?php exit();?>
	private function editor($config, $value) {
		/*远程图片加载*/
        /*extract($config,EXTR_SKIP);
    		$enablesaveimage = $setting['enablesaveimage'];
    		if(isset($_POST['spider_img'])) $enablesaveimage = 1;
    		if($enablesaveimage) {
    			$watermark_enable = intval($setting['watermark_enable']);
    			$attachment = load_class('attachment','attachment');
    			$value = $attachment->save_remote($value,$watermark_enable);
    		}*/
		return $value;
	}