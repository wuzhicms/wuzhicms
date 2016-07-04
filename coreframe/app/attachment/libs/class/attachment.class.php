<?php

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('common','attachment');

/**
 * 附件处理类
 */
class WUZHI_attachment{
    /**
     * 是否开启图片水印
     *
     * @var bool true or false
     */
	public $water_mark = false;
    function __construct() {
        $this->image = load_class('image');
		$this->setting = get_cache('attachment');
		$this->water_mark = $this->setting['watermark_enable'];
    }

/**
 * 文件上传记录入库操作
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public function insert($insert)
	{
		$db = load_class('db');
        $insert['userkeys'] = get_cookie('userkeys');
        $ext = get_ext($insert['path']);
        if(in_array($ext,array('jpg','gif','bmp','png','jpeg'))) {
            $insert['isimage'] = 1;
        }
		return $id = $db->insert('attachment',$insert);
	}

	/**
	 * 设置水印
	 * @param bool $water_mark
	 */
	public function set_water_mark($water_mark = false)
	{
		$this->water_mark = $water_mark;
	}
/**
 * 从字符串中抓取远程图片
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return string 替换后的字符串
 */
	public function save_remote( $str = '', $watermark_enable = false)
	{
		if(empty($str)) return false;
		if($watermark_enable==1) $this->water_mark = true;
		$list = $replace_array = array();//这里存放结果map
		$c1 = preg_match_all('/<img\s.*?>/', $str, $m1);//先取出所有img标签文本
		for($i=0; $i<$c1; $i++) //对所有的img标签进行取属性
		{
			$c2 = preg_match_all('/(\w+)\s*=\s*(?:(?:(["\'])(.*?)(?=\2))|([^\/\s]*))/', $m1[0][$i], $m2);//匹配所有属性
			for($j=0; $j<$c2; $j++) //将匹配完的结果进行结构重组
			{
				$img_attr = $m2[1][$j];
				if( !in_array($img_attr, array('src','alt','title')) ) continue;
				$list[$i][$img_attr] = !empty($m2[4][$j]) ? $m2[4][$j] : $m2[3][$j];
			}
		}

		foreach($list AS $k=>$v)
		{
			if(strpos($v['src'], '://') === false || strpos_array($v['src'], array('127.0.0.1','localhost',ATTACHMENT_URL) ) !== false) continue;

			$alt = isset($v['alt']) ? remove_xss($v['alt']) : remove_xss($v['title']);
			$new_path = $this->get_remote_file( $v['src'], array('alt'=>$alt) );
			if($new_path)
			{
				$replace_array['old'][] = $v['src'];
				$replace_array['new'][] = $new_path;
			}

		}
		
		return empty($replace_array['new']) ? $str : str_ireplace( $replace_array['old'], $replace_array['new'] , $str);
	}

/**
 * 获取远程内容写入本地
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param array $file_attr 文件信息
 * @return $string 本地化后的文件路径 || false
 */
	public function get_remote_file($path = '', $file_attr = array() )
	{
		if(empty($path)) return false;

		$content = $this->get_remote_core($path);

		if($content)
		{
			$insert['name'] = isset($file_attr['alt']) && !empty($file_attr['alt']) ? $file_attr['alt'].'.'.fileext($path) : pathinfo($path,PATHINFO_BASENAME);
			$new_path = createdir().filename($insert['name']);
			if(!file_put_contents(ATTACHMENT_ROOT.$new_path, $content)) return false;
			if($this->water_mark == true) {
				$this->image->set_image(ATTACHMENT_ROOT.$new_path);
				$this->image->createImageFromFile();
				if($this->setting['watermark_enable']==2) {//文字水印
					$this->image->water_mark(WWW_ROOT.'res/images/watermark.png',$this->setting['watermark_pos']);
				} else {//图片水印
					$this->image->water_mark(WWW_ROOT.'res/images/watermark.png',$this->setting['watermark_pos']);
				}

				$this->image->save();
			}

			$insert['path'] = $new_path;
			$insert['addtime'] = SYS_TIME;
			$insert['filesize'] = strlen($content);
			$insert['ip'] = get_ip();
			$uid = intval(get_cookie('uid'));
			if($uid) {
				$insert['userid'] = $uid;
				$insert['username'] = get_cookie('username');
			} else {
				$insert['userid'] = get_cookie('_uid');
				$insert['username'] = get_cookie('_username');
			}

			$id = $this->insert($insert);
			return ATTACHMENT_URL.$new_path;
		}
		else
		{
		    return false;
		}
	}

/**
 * 获取远程内容的核心操作方法
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	private function get_remote_core($path = '')
	{
		if(function_exists('curl_init'))
		{
			$c = curl_init();
			$domain_array = parse_url($path);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($c,CURLOPT_REFERER,$domain_array['scheme'].'://'.$domain_array['host']);
			curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko');//部分服务器判断浏览器头,这里加上防止其返回404等异常;
			curl_setopt($c, CURLOPT_URL, $path);
			curl_setopt($c, CURLOPT_HEADER, 0);
			curl_setopt($c, CURLOPT_TIMEOUT,30);
			$contents = curl_exec($c);
			if(curl_errno($c) == 28) //链接超时
			{
				return false;
			}
			$http_status_arr = curl_getinfo($c);
			curl_close($c);

			$http_code = $http_status_arr['http_code'];
			if($http_code != '200')
			{
				switch($http_code)
				{
					case '301':
					case '302':
					$header_info = get_headers($path,true);
					return $this->get_remote_core($header_info['Location']);
					break;

					default:
					return false;
					break;
				}
			}
			return $contents;
		}
		else
		{
			ob_start();
			$context = stream_context_create(
			array('http' => array(
			'follow_location' => false,
			'timeout' => 10,
			))
			);
			readfile($path, false, $context);
			$img = ob_get_contents();
			ob_end_clean();
			return $img;
		}
	}

}

?>