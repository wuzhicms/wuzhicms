<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * tags模块前台页面
 */
class index{
    private $siteconfigs;
	public function __construct() 
	{
        //$this->siteconfigs = get_cache('siteconfigs');
		$this->_cache = get_cache(M);
        $this->db = load_class('db');
		define('NOTHML',true);//不静态化,带入下面的引入文件,保证复用
		$this->html_tags = load_class('html_tags',M);//直接调用静态化类来做变量准备,提高代码复用
	}

    /**
     * tags首页
     */
    public function init()
	{
        $siteconfigs = $this->siteconfigs;
		$page = max( 1,output($GLOBALS,'page') );
        $this->html_tags->index();
	}

    /**
     * 内容页面
     * url规则 /index.php?m=tags&f=index&v=show&tid=2,tid=id/pinyin/tag/其中一个
     */
    public function show() 
	{
        $siteconfigs = $this->siteconfigs;
		$page = max( 1,output($GLOBALS,'page') );
		if(isset($GLOBALS['tid']) && is_numeric($GLOBALS['tid']) )//id的url规则
		{
			$tid = intval($GLOBALS['tid']);
			$where = array('tid'=>$tid);
		}
		elseif( isset($GLOBALS['tid']) && ctype_alnum($GLOBALS['tid']) )//pinyin,可能为字母+数字
		{
		    $tid = sql_replace($GLOBALS['tid']);
			$where = array('pinyin'=>$tid);
		}
		else //中文编码
		{
            if(strtolower(CHARSET)=='gbk') {
                $tid = iconv('utf-8','gbk',urldecode($GLOBALS['tid']) );
            } else {
                $tid = urldecode($GLOBALS['tid']);
            }
            $tid = sql_replace($tid);
			$where = array('tag'=>$tid);
		}

        $tag_info = $this->db->get_one('tag', $where);
		if(empty($tag_info))
		{
			MSG(L('parameter_error'));
		}
		$tid = is_numeric($tid) ? $tid : $tag_info['tid'];

        $this->html_tags->show($tid, $tag_info );
    }

    /**
     * 首字母列表 /index.php?m=tags&f=index&v=letter&letter=A
     */
    public function letter() 
	{
        $letter = isset($GLOBALS['letter']) ? substr($GLOBALS['letter'],0,1) : MSG(L('parameter_error'));
		$page = max( 1,output($GLOBALS,'page') );
        $this->html_tags->letter( $letter );
    }

 /**
 * ajax获取tags,用于keyword表单字段的自动填充
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public function ajax_auto_complete()
	{
		$tag = isset($GLOBALS['term']) ? remove_xss($GLOBALS['term']) : MSG(L('parameter_error'));
		$tag = sql_replace($tag);
		$where = ' tag like "%'.$tag.'%" ';
		$tag_info = $this->db->get_list('tag', $where, 'tag',0,10,1);
		foreach($tag_info AS $k=>$v)
		{
		    $tag_info[$k]['label'] = $tag_info[$k]['value'] = $v['tag'];
			unset($tag_info[$k]['tag']);
		}
		exit(json_encode($tag_info));
	}
}
?>
