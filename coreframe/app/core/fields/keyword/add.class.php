<?php exit();?>
<!--这样的注释，会在合成缓存文件的时候删除-->
	private function keyword($config, $value) {
         if(strpos($value,',')===false) {
            return str_replace(' ',',',$value);
         } else {
            return $value;
         }
	}
