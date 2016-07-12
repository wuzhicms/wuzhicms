<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

load_class('admin');
//load_function('common',M);

class index extends WUZHI_admin {

	function __construct() {
		$this->db = load_class('db');
		$GLOBALS['_menuid'] = isset($GLOBALS['_menuid']) ? intval($GLOBALS['_menuid']) : '';
		$this->_cache = get_cache(M);
	}

	public function listing()
	{
		$where = ' 1 ';
		$this->order_by = 'tid DESC';
		load_class('form');
		
		$where .= $this->search_where();

		$pagesize = isset($GLOBALS['pagesize']) ? intval($GLOBALS['pagesize']) : 20;
		$page = isset($GLOBALS['page'])  ? intval($GLOBALS['page']) : 1;
		$lists = $this->db->get_list('tag',$where,'*', 0, $pagesize, $page, $this->order_by);
		$pages = $this->db->pages;
        $linkage = $this->db->get_list('linkage', '', 'name,linkageid', 0, 100, '',"linkageid ASC", '', 'linkageid');
        foreach($linkage AS $k=>$v)
        {
            $linkage[$k] = $v['name'];
        }
        include $this->template(V,M);
	}

/**
 * 添加/修改tags用同一个方法,有tid表示修改
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
	public function add()
	{
		$tag_info = array();
		$tid = intval( output( $GLOBALS, 'tid') );//有值表示为修改
		if(output($GLOBALS,'dosubmit'))
		{
			$tag_info = $GLOBALS['tag'];
			unset($GLOBALS['tag']);
			$tag_info['tag'] = trim(output($tag_info,'tag'));
			if( ($tid && isset($GLOBALS['is_edit'])) || !$tid)
			{
				if(empty($tag_info['tag'])) MSG(L('operation_failure'),HTTP_REFERER,3000);
			}

			if( $tag_exists = $this->db->get_one('tag', array('tag'=>$tag_info['tag']), 'tid' ) )
			{
				if(output($tag_exists,'tid') != $tid) MSG(L('tag_exists'),HTTP_REFERER,3000);
			}
			//准备入库数据
			if(!$tid)
			{
				$tag_info['addtime'] = SYS_TIME;
				$tag_info['number'] = 0;
			} 
			if(empty($tag_info['pinyin']) || output($GLOBALS,'is_edit') == 1)
			{
				$pinyin = load_class('pinyin');
				$py = $pinyin->return_py($tag_info['tag']);
				$tag_info['pinyin'] = $py['pinyin'];
				$tag_info['letter'] = $py['letter'];
			}
			else
			{
			    $tag_info['letter'] = $tag_info['letter'] ? $tag_info['letter'] : substr($tag_info['pinyin'],0,1);
			}
			//调用url处理方法
			if(empty($tag_info['url']) || output($GLOBALS,'is_edit') == 1)
			{
				if(!$tid) $tagid = $this->db->insert('tag',$tag_info);
				$tag_class = load_class('tags',M);
				$param = array(
					'pinyin'=>$tag_info['pinyin'],
					'letter'=>$tag_info['letter'],
					'urlencode_tag'=>$tag_info['tag'],
					'tagid'=>$tid ? $tid : $tagid,
				);
				$tag_info['url'] = $tag_class->url_rule('show',$param);
			}
			//开头不需要/斜杠
			$tag_info['url'] = strpos($tag_info['url'], '/') === 0 ? substr($tag_info['url'],1) : $tag_info['url'];
			
			if($tid) //修改
			{
				$this->db->update('tag', $tag_info, array('tid'=>$tid) );
				$html_tags = load_class('html_tags',M);
				$html_tags->show($tid);
				MSG(L('edit_success'),link_url( array('v'=>'listing') ),3000);
			}
			else	//新增插入
			{
				if($tagid) //前面入库了基本信息,这里更新下url
				{
					$this->db->update('tag', array('url'=>$tag_info['url']), array('tid'=>$tagid) );
				}
				else
				{
				    $this->db->insert('tag',$tag_info);
				}
				MSG(L('add_success'),HTTP_REFERER,3000);
			}
		}
		else
		{
			if($tid) $tag_info = $this->db->get_one('tag',$where = array('tid'=>$tid) );
		    include $this->template(V,M);
		}
	}

/**
 * 删除
 *
 * @author tuzwu
 */
	public function del()
	{
		$tid = intval( output( $GLOBALS, 'tid') );
		if( empty($tid) ) MSG(L('operation_failure'),HTTP_REFERER,3000);
		$r = $this->db->delete('tag', array('tid'=>$tid) );
		if($r)
		{
			$this->db->delete('tag_data', array('tid'=>$tid) );
			MSG(L('operation_success'),HTTP_REFERER,3000);
		}
	}

/**
 * 重新从keyword里创建tag,删除tag_data表,重置tag表的number为0
 *
 * @author tuzwu
 */
	public function create()
	{	
		if( output($GLOBALS,'dosubmit') && output($GLOBALS,'create_confirm') == '五指CMS' )
		{
			$page = max(1,output($GLOBALS,'page'));
			$modelid = output($GLOBALS,'modelid');
			if( $page <= 1 && !$modelid )
			{
				$this->db->query( 'TRUNCATE TABLE wz_tag_data' );
				$r = $this->db->update( 'tag', array('number'=>0), $where = array() );//重新计数
			}
				$model = get_cache('model_content','model');
				$model_key = array_keys($model);sort($model_key);
				$model_num = count($model_key);
				$modelid = $modelid ? $modelid : $model_key[0];//没有modelid表示第一次运行,从第一个模型开始
				$pagesize = 50;//每次处理50个文章
				$where = $model[$modelid]['share_model'] == 1 ? array('modelid'=>$modelid) : '';
				$lists = $this->db->get_list($model[$modelid]['master_table'], $where, $field = 'keywords,cid,id'.($where ? ',modelid' : ''),0,$pagesize,$page );
				$page_num = ceil($this->db->number/$pagesize);

				require get_cache_path('content_update','model');
				$form_update = new form_update($modelid);
				
				foreach($lists AS $k=>$v)
				{
					$formdata['master_data'] = array( 'id'=>$v['id'], 'cid'=>$v['cid'],'modelid'=>$v['modelid'] ? $v['modelid'] : $modelid,'keywords'=>$v['keywords']);
					$form_update->execute($formdata);//这里会调用keyword方法进行tag+1/入库处理等
				}
				
				if($page_num <= $page && $modelid == $model_key[$model_num-1]) //最后一轮更新,提示成功
				{
					$url = link_url( array('v'=>'listing') );
				    MSG( L('operation_success'), $url, 3000); //完成更新
				}
				else
				{
					if($page_num > $page)
					{
						$page += 1;
					}
					else
					{
					    $page = $GLOBALS['page'] = 1;//页数从1开始,主要方便get_list执行;
						$modelid = $model_key[array_search($modelid,$model_key)+1];//下一个模型
					}
				}
				$url = link_url( array('page'=>$page,'modelid'=>$modelid,'create_confirm'=>'五指CMS','dosubmit'=>1));
				MSG( L('next_round').'modelid:'.$modelid.'-page_num:'.$page_num.'-page:'.$page, $url, 2000);
			
		}
		else
		{
		    include $this->template(V,M);
		}
	}

/**
 * 导入或者是批量添加
 *
 * @author tuzwu
 */
	public function import()
	{
		if(output($GLOBALS,'dosubmit'))
		{
			set_time_limit(300);
			if(output($GLOBALS,'import'))
			{
				$tag_arr = explode("\r\n", output($GLOBALS,'import') );
			}
			if(isset($_FILES['file']['size']) && $_FILES['file']['size'] > 0)
			{
				if($_FILES['file']['type'] != 'text/plain') MSG(L('operation_failure'), HTTP_REFERER, 3000);
				$tag_arr = file($_FILES['file']['tmp_name']);
			}

			$pinyin_class = load_class('pinyin');
			$tag_class = load_class('tags',M);
			unset($pinyin);

			foreach($tag_arr AS $k=>$v)
			{
				$v = trim($v);
				if(strpos($v, '|') !== false)
				{
					$tmp = explode('|', $v);
					$tag = trim($tmp[0]);
					$pinyin = $tmp[1];
				}
				else
				{
				    $tag = $v;
				}

				//入库操作
				if(empty($tag)) continue;
				$tag = array_iconv('utf-8', 'gbk', $tag);
				$tag_exists = $this->db->get_one('tag', array('tag'=>$tag), 'tid' );
				if($tag_exists) continue;
				
				$insert = array('tag'=>$tag);
				if(!isset($pinyin))
				{
					$py = $pinyin_class->return_py($tag);
					$insert['pinyin'] = $py['pinyin'];
					$insert['letter'] = $py['letter'];
				}
				else
				{
				    $insert['pinyin'] = $pinyin;
					$insert['letter'] = substr($pinyin,0,1);
				}

				$insert['number'] = 0;
				$insert['addtime'] = SYS_TIME;
				$tid = $this->db->insert('tag',$insert);
				$param = array(
					'pinyin'=>$insert['pinyin'],
					'letter'=>$insert['letter'],
					'urlencode_tag'=>$insert['tag'],
					'tagid'=>$tid,
				);
				$url = $tag_class->url_rule('show',$param);
				$this->db->update('tag', array('url'=>$url), array('tid'=>$tid) );
			}

			MSG(L('operation_success'), HTTP_REFERER, 3000);
		}
		else
		{
		    include $this->template(V,M);
		}
	}

/**
 * 批量静态化生成
 *
 * @author tuzwu
 */
	public function html()
	{
		if(output($this->_cache,'rewrite') == 1) MSG(L('no_html'), HTTP_REFERER, 3000);
		$html_tags = load_class('html_tags',M);
		$tid = intval( output( $GLOBALS, 'tid') );
		if($tid)
		{
			$html_tags->show($tid);
			MSG(L('operation_success'), HTTP_REFERER , 3000);
		}
		else
		{
		    $action = output( $GLOBALS, 'action');
			switch($action)
			{
				case 'show'://内页批量静态化
					$pagesize = 10;//每次生成50个tag内页
					$page = max(1, output($GLOBALS,'page') );
					$list = $this->db->get_list('tag',' number > 0 and isshow = 1 ','*',0,$pagesize,$page);
					$pagenum = ceil($this->db->number/$pagesize);
					if($page <= $pagenum)
					{
						foreach($list AS $k=>$v)
						{
							if(!$v['url']) continue;
						    $html_tags->show($v['tid'], $v);
						}
						$next_page_url = link_url( array('action'=>'show','page'=>$page+1) );
						MSG( (round($page/$pagenum,2)*100).'%:'.L('next_round').$page.'-'.$pagenum, $next_page_url , 3000);
					}
				break;

				case 'letter'://列表页
					$html_tags->letter();
				break;

				case 'index'://模块首页
					$html_tags->index(5);
				break;
				
				default://加载模板
					include $this->template('html',M);
					exit;
				break;
			}
		}
		MSG(L('operation_success'), link_url( array('v'=>V,'action'=>'false') ) , 3000);
	}

/**
 * 模块设置
 *
 * @author tuzwu
 */
	public function set()
	{
		 if(isset($GLOBALS['dosubmit']))
		 {
			 $cache_in_db = cache_in_db($GLOBALS['setting'], V, M);
			 set_cache(M, $GLOBALS['setting']);
			 MSG( L('operation_success'), HTTP_REFERER, 3000);
		 }
		 else
		 {
             $show_dialog = 1;
			 load_class('form');
			 load_function('template');
			 $templates = select_template(M);
			 $setting = &$this->_cache;

			 if(empty($setting)) $setting = cache_in_db('', V, M);
			 $linkage = $this->db->get_list('linkage', '', 'name,linkageid', 0, 100, '',"linkageid ASC", '', 'linkageid');
			 foreach($linkage AS $k=>$v)
			 {
				 $linkage[$k] = $v['name'];
			 }
		     include $this->template('set',M);
		 }
	}

	/**
 * 根据GET传值,返回where条件给主方法使用
 *
 * @author tuzwu
 * @createtime 2014-9-13 23:03:33
 * @modifytime
 * @param	
 * @return string
 */
	private function search_where()
	{
		$where = '';
		$GLOBALS['start'] = isset($GLOBALS['start']) ? remove_xss($GLOBALS['start']) : '';
		$GLOBALS['end'] = isset($GLOBALS['end']) ? remove_xss($GLOBALS['end']) : '';
		$GLOBALS['linkage'] = isset($GLOBALS['linkage']) ? sql_replace($GLOBALS['linkage']) : '';
		$GLOBALS['tags'] = isset($GLOBALS['tags']) ? sql_replace( $GLOBALS['tags'] ) : '';
		$GLOBALS['order'] = isset($GLOBALS['order']) ? intval( $GLOBALS['order'] ) : '0';
		
		if(!isset($GLOBALS['dosearch']))
		{
			return '';
		}

		if($GLOBALS['start'] || $GLOBALS['end'])
		{
			if($GLOBALS['start'] && !$GLOBALS['end']) $where_end_time = SYS_TIME;
			if(!$GLOBALS['start'] && $GLOBALS['end']) $where_start_time = SYS_TIME - 2592000;
			if($GLOBALS['start'] && $GLOBALS['end'])
			{
				$where_start_time = strtotime($GLOBALS['start']);
				$where_end_time = strtotime($GLOBALS['end']);
				if($where_start_time > $where_end_time) list($where_start_time , $where_end_time) = array($where_end_time,$where_start_time);
			}
			$where .= " and `addtime` BETWEEN '$where_start_time' AND '$where_end_time' ";
		}

		if( $GLOBALS['linkage'] )
		{
			$where .= ' and linkage = "'.$GLOBALS['linkage'].'" ';
		}

		if( $GLOBALS['tags'] )
		{
			$where .= ' and tag like "%'.$GLOBALS['tags'].'%" ';
		}
		
		if($GLOBALS['order'])
		{
			switch($GLOBALS['order'])
			{
				case 1:
					$order_by = 'number DESC';
				break;

				case 2:
					$order_by = 'number ASC';
				break;

				case 4:
					$order_by = 'tid ASC';
				break;
				
				default:
					$order_by = 'tid DESC';
				break;
			}
		$this->order_by = $order_by;
		}
		return $where;
	}

}
?>