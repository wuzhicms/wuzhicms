<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容模版，标签解析
 */
class WUZHI_tags_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
    public function __construct() {
        $this->db = load_class('db');
        $this->categorys = get_cache('category','content');
		$this->_cache = get_cache(M);
    }

    /**
     * 标签tag列表方法
     *
     * @param $c
     * @return array
     */
    public function listing($c) 
	{
		$where = ' isshow = 1 ';
		$urlrule_param['page'] = $c['page'];
		if( output($c,'letter') )
		{
			$where .= ' AND letter = "'.$c['letter'].'" ';
			$urlrule = $this->_cache['letter_url_rule'];
			$urlrule_param['letter'] = output($c,'letter');
		}
		else
		{
		    $urlrule = $this->_cache['index_url_rule'];
		}
        
        if( output($c,'linkage') ) 
		{
            $where .= ' AND `linkage`="'.$c['linkage'].'" ';
        }

        $order = isset($c['order']) ? $c['order'] : 'tid DESC';
        $result = $this->db->get_list('tag', $where, '*', $c['start'], $c['pagesize'], $c['page'],$order,'','',$urlrule, $urlrule_param);
        if($c['page']) $this->pages = $this->db->pages;
        return $result;
	}

    /**
     * tag相关内容列表标签
     *
	 * 注意仅支持id DESC/id ASC 两种排序方式;
	 * 查询流程是:先get_list取tag表pagesize条数据,然后拿到modelid信息,遍历需要查询的模型,循环查询指定表而不是一次性查询,最后组合数据
     * @param $c
     * @return mixed
     */
    public function content($c) 
	{
		$where = ' 1 ';
		if( !output( $c,'field') ) $c['field'] = '*';
        if(isset($c['tid'])) 
		{
            $tid = intval($c['tid']);
            $where .= ' AND `tid`='.$tid;
        }
		else 
		{
            return array();
        }

		if( output($c,'cid') )
		{
			$cid = intval($c['cid']);
			$where .= ' AND `cid`='.$cid;
		}
		if( output($c,'modelid') )
		{
			$where .= ' AND `modelid`='.intval($c['modelid']);
		}
		if( output($c,'moduleid') )
		{
		    $where .= ' AND `moduleid`='.intval($c['moduleid']);
		}
        $order = isset($c['order']) && $c['order'] == 'id DESC' ? 'id DESC' : 'id ASC';
		$temp_info = $this->db->get_list( 'tag_data', $where, '*', '', $c['pagesize'], $c['page'], $order, '' );

		$modelid_arr = $query_arr = $result = $ids_arr = array();
		foreach($temp_info AS $k=>$v)
		{
		    $modelid_arr[] = $v['modelid'];
			$ids_arr[$v['modelid']][] = $v['id'];
		}
		$modelid_arr = array_unique($modelid_arr);
		$model_arr = get_cache('model_content','model');
		foreach($modelid_arr AS $k=>$modelid)
		{
			$table = $model_arr[$modelid]['master_table'];
			$where = ' id in('.implode(',',$ids_arr[$modelid]).') ';
		    $query_arr[$modelid] = $this->db->get_list( $table, $where, $c['field'] );
		}
		
		foreach($query_arr AS $ks=>$rs)
		{
			foreach($rs AS $k=>$v)
			{
			    $result[] = $v;
			}
		}
        return $result;
    }
}