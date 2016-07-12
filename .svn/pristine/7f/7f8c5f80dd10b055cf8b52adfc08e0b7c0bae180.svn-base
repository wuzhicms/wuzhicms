<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class WUZHI_tags{

	public function __construct()
	{
		$this->_cache = get_cache('tags');
	}

/**
 * 处理tags的url
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param string type 类型,首页index||索引letter||内容show
 * @param array param url变量参数数组,允许的值如下: $page,$pinyin,$letter,$urlencode_tag,$tagid
 * @param int $maxpage 返回的最大页数,大于1时返回数组,比如传入8,返回从1-8索引的数组
 * @return
 */
	public function url_rule( $type = 'show', $param = array(), $maxpage = 1 )
	{
		if(!isset($param['page'])) $param['page'] = max(output($GLOBALS,'page'),1);
		if(!isset($this->_cache[$type.'_url_rule']))
		{
			MSG( L('url_rule_empty'), HTTP_REFERER, 3000);
		}
		$url_rule = explode('|',$this->_cache[$type.'_url_rule']);

		$replace_from_arr = array('{$page}','{$pinyin}','{$letter}','{$urlencode_tag}','{$tagid}');
		$replace_to_arr = array($param['page'],output($param,'pinyin'), output($param,'letter'), output($param,'urlencode_tag'), output($param,'tagid') );

		if($param['page'] > 1 || $maxpage > 1)
		{
			$url = $url_rule[1];
			if($maxpage <= 1)
			{
				$url = str_ireplace($replace_from_arr, $replace_to_arr,	$url );
			}
			else
			{
				$url_arr = array();
				$url_arr[1] = str_ireplace($replace_from_arr, $replace_to_arr, $url_rule[0] );//第一页
				unset($replace_to_arr[0], $replace_from_arr[0]);
				$url = str_ireplace( $replace_from_arr, $replace_to_arr , $url);
				
			    for($i=2; $i<=$maxpage; $i++ )
				{
					$url_arr[$i] = str_ireplace('{$page}',$i,$url);
				}
				$url = &$url_arr;
			}
		}
		else
		{
		    $url = $url_rule[0];
			$url = str_ireplace($replace_from_arr, $replace_to_arr, $url );
		}
		return $url;
	}

}

?>