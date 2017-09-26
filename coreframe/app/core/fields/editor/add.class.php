<?php exit();?>
	private function editor($config, $value) {
		extract($config,EXTR_SKIP);
		if($setting) extract($setting,EXTR_SKIP);
		if($value && $editor_type=='ckeditor') {
			$value = str_replace('<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>','_wuzhicms_page_tag_',$value);
		}
		/*远程图片加载*/
		$enablesaveimage = $setting['enablesaveimage'];
		if(isset($_POST['spider_img'])) $enablesaveimage = 1;
		if($enablesaveimage) {
			$watermark_enable = intval($setting['watermark_enable']);
			$attachment = load_class('attachment','attachment');
			$value = $attachment->save_remote($value,$watermark_enable);
		}
		return $value;
	}