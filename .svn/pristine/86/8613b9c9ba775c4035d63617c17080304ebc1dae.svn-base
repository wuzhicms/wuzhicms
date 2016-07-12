<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_html_tags {

	public function __construct() {
		if(!defined('HTML')) define('HTML',1);
		$this->_cache = get_cache('tags');
		if(isset($this->_cache['rewrite']) && $this->_cache['rewrite'] == 1 ) MSG( L('no_html'), HTTP_REFERER, 3000);
		$this->db = load_class('db');
	}

	/**
	 * 生成tags内容页
	 * @param int $tagid 传入tagid来生成其文字列表页面
	 * @param array taginfo 标签信息,如果无值就从数据库重新读取
	 */
	public function show($tagid, $taginfo = array() ) 
	{
		if(!$tagid) return false;
		if(empty($taginfo)) $taginfo = $this->db->get_one('tag', array('tid'=>$tagid) );
		$tid = $tagid ? $tagid : $taginfo['tid'];
		$page = 1;
		
		$_template = isset($this->_cache['show_tpl']) ? $this->_cache['show_tpl'] : 'default:show';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) && !empty($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
		
		$seo_title = $taginfo['title'] ? $taginfo['title'] : $taginfo['tag'];
		$seo_keywords = $taginfo['keyword'] ? $taginfo['keyword'] : $taginfo['tag'];
		$seo_description = $taginfo['desc'] ? $taginfo['desc'] : $taginfo['tag'];

		if(!defined('NOTHML')) ob_start();
		include T(M,$_template,$project_css);
		if(!defined('NOTHML')) return $this->createhtml(WWW_ROOT.$taginfo['url']);
	}

	/**
	 * 更新tags首页以及分页
	 * @param int maxpage 最多生成多少页,当其他地方调用时,给 1 表示仅生成第一页,空值表示生成所有
	 */
	public function index($maxpage = '') 
	{
		$_template = isset($this->_cache['index_tpl']) ? $this->_cache['index_tpl'] : 'default:index';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'index';

		if(!defined('NOTHML')) ob_start();
		
		$seo_title = $this->_cache['title'];
		$seo_keywords = $this->_cache['keyword'];
		$seo_description = $this->_cache['desc'];

		$tags_obj = load_class('tags',M);
		$url = $tags_obj->url_rule('index', array(), $maxpage );
		if(is_array($url)) //生成多页
		{
			foreach($url AS $k=>$v)
			{
				$page = $k;
				include T(M,$_template,$project_css);
			    if(!defined('NOTHML')) $this->createhtml(WWW_ROOT.$v);
			}
			return true;
		}
		else
		{
			include T(M,$_template,$project_css);
		    if(!defined('NOTHML')) return $this->createhtml(WWW_ROOT.$url);
		}
	}

/**
 * 字母列表静态化
 *
 * @author tuzwu
 */
	public function letter($letter = '', $maxpage = 1)
	{
		$_template = isset($this->_cache['letter_tpl']) ? $this->_cache['letter_tpl'] : 'default:list';
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'list';

		if(!defined('NOTHML')) ob_start();

		$tags_obj = load_class('tags',M);
		if( $letter )
		{
			$url = $tags_obj->url_rule('letter', array('letter'=>$letter), $maxpage = 5 );
			$seo_title = $letter;
			$seo_keywords = $letter;
			$seo_description = $letter;
			foreach($url AS $k=>$v)
			{
				$page = $k;
				include T(M,$_template,$project_css);
				if(!defined('NOTHML')) $this->createhtml(WWW_ROOT.$v);   
			}
		}
		else
		{
		    $letter_arr = range('a','z');
			foreach($letter_arr AS $k=>$letter)
			{
			    $url = $tags_obj->url_rule('letter', array('letter'=>$letter), $maxpage = 5 );
				$seo_title = $letter;
				$seo_keywords = $letter;
				$seo_description = $letter;
				foreach($url AS $k=>$v)
				{
					$page = $k;
					include T(M,$_template,$project_css);
					if(!defined('NOTHML')) $this->createhtml(WWW_ROOT.$v);   
				}
			}
		}
		return true;
	}

	/**
	* 写入文件
	* @param $file 文件绝对路径
	*/
	private function createhtml($file) 
	{
		$data = ob_get_contents();
		ob_clean();
		$dir = dirname($file);
		if(!is_dir($dir)) 
		{
			mkdir($dir, 0777,1);
		}
		$strlen = file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) 
		{
			$file = str_replace(WWW_ROOT,'',$file);
			MSG(L('file').'：'.$file.'<br>'.L('not_writable'));
		}
		return $strlen;
	}
}