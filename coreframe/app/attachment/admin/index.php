<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_function('common', M);

class index extends WUZHI_admin
{
    private $db;

    function __construct()
    {
        $this->db = load_class('db');
        $GLOBALS['_menuid'] = isset($GLOBALS['_menuid']) ? intval($GLOBALS['_menuid']) : '';
        $this->_cache = get_cache(M);
    }

    public function listing()
    {
        $where = ' 1 ';
        $this->order_by = 'id DESC';
        load_class('form');

        $where .= $this->search_where();

        $pagesize = isset($GLOBALS['pagesize']) ? intval($GLOBALS['pagesize']) : 20;
        $page = $GLOBALS['page'] ? intval($GLOBALS['page']) : 1;
        $lists = $this->db->get_list('attachment', $where, '*', 0, $pagesize, $page, $this->order_by);
        $pages = $this->db->pages;
        include $this->template('listing', M);
    }
    public function add()
    {
        if(isset($GLOBALS['submit'])) {
            $diycat = strip_tags($GLOBALS['diycat']);
            if(empty($GLOBALS['files'])) MSG('请先上传文件');
            foreach($GLOBALS['files'] as $key=>$value) {
                $this->db->update('attachment', array('name'=>$value['alt'],'diycat'=>$diycat), array('id' => $key));
            }
            MSG('文件上传成功','?m=attachment&f=index&v=listing'.$this->su());
        } else {
            $show_dialog = 1;
            load_class('form');
            include $this->template('add');
        }
    }
    /**
     * 目录列表方式查看
     *
     * @author tuzwu
     * @createtime 2014-8-1 13:14:29
     * @modifytime
     * @param
     * @return array
     */
    public function dir()
    {
        $dir = isset($GLOBALS['dir']) && trim($GLOBALS['dir']) ? str_replace(array('..\\', '../', './', '.\\'), '', trim($GLOBALS['dir'])) : '';
        $dir = str_ireplace(array('%2F', '//'), '/', $dir);
        $lists = glob(ATTACHMENT_ROOT . $dir . '/' . '*');
        if (!empty($lists)) rsort($lists);
        $cur_dir = str_replace(array(WWW_ROOT, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR), array('', DIRECTORY_SEPARATOR), ATTACHMENT_ROOT . $dir . '/');
        include $this->template('dir', M);
    }

    /**
     * 处理tags的增加/删除
     *
     * @author tuzwu
     * @createtime 2014-8-3 12:53:58
     * @modifytime
     * @param
     * @return
     */
    public function tags()
    {
        $tag = isset($GLOBALS['tag']) ? remove_xss($GLOBALS['tag']) : '';//操作的标签,
        $act_type = isset($GLOBALS['act_type']) ? intval($GLOBALS['act_type']) : '';//1增加,2删除
        $tags = isset($GLOBALS['tags']) ? sql_replace($GLOBALS['tags']) : '';//当前附件的所有标签
        $att_id = isset($GLOBALS['att_id']) ? intval($GLOBALS['att_id']) : '';
        if (empty($tag) || empty($act_type) || empty($att_id)) {
            exit(L('param_err'));
        }

        $tag = strtolower(CHARSET) == 'gbk' ? iconv('utf-8', CHARSET, $tag) : $tag;
        $tags = strtolower(CHARSET) == 'gbk' ? iconv('utf-8', CHARSET, $tags) : $tags;
        $tag_info = $this->db->get_one('attachment_tags', array('tag' => $tag), 'id');

        switch ($act_type) {
            case 1:
                if ($tag_info['id']) {
                    $this->db->update('attachment_tags', 'usertimes = usertimes+1', array('id' => $tag_info['id']));
                }
                else {
                    $tag_info['id'] = $this->db->insert('attachment_tags', array('tag' => $tag), true);
                }
                $this->db->insert('attachment_tag_index', array('att_id' => $att_id, 'tag_id' => $tag_info['id']));
                break;

            case 2:
                $this->db->update('attachment_tags', 'usertimes = usertimes-1', array('id' => $tag_info['id']));
                $this->db->delete('attachment_tag_index', array('att_id' => $att_id, 'tag_id' => $tag_info['id']));
                break;
        }

        $this->db->update('attachment', array('tags' => $tags), array('id' => $att_id));
        exit('1');
    }

    /**
     * 模块配置
     *
     * @author tuzwu
     * @createtime
     * @modifytime
     * @param
     * @return
     */
    public function set()
    {
        if (isset($GLOBALS['submit'])) {
            set_cache(M, $GLOBALS['setting']);
            MSG(L('operation_success'), HTTP_REFERER, 3000);
        } else {
            $show_dialog = 1;
            load_class('form');
            $setting = &$this->_cache;
            if(!isset($setting['show_mode'])) {
				$setting = array('show_mode'=>2,'watermark_enable'=>1,'watermark_pos'=>0,'watermark_text'=>'www.wuzhicms.com');
				set_cache(M, $setting);
			}
            include $this->template('set', M);
        }
    }

    /**
     * 编辑器配置项目
     *
     * @author tuzwu
     * @createtime 2014-8-30 20:31:23
     * @modifytime
     * @param
     * @return
     */
    public function ueditor()
    {
        if (isset($GLOBALS['submit'])) {
            $cache_in_db = cache_in_db($GLOBALS['setting'], V, M);
            set_cache(V, $GLOBALS['setting']);
            MSG(L('operation_success'), HTTP_REFERER, 3000);
        }
        else {
            $setting = get_cache(V);
			if(empty($setting)) $setting = cache_in_db('', V, M);
            include $this->template(V, M);
        }
    }

    /**
     * 删除文件
     *
     * @author tuzwu
     * @createtime
     * @modifytime
     * @param
     * @return
     */
    public function del()
    {
        $id = isset($GLOBALS['id']) ? $GLOBALS['id'] : '';
        $url = isset($GLOBALS['url']) ? remove_xss($GLOBALS['url']) : '';
        if (!$id && !$url) MSG(L('operation_failure'), HTTP_REFERER, 3000);
        if ($id) {
        	if(!is_array($id)) {
				$ids = array($id);
			} else {
				$ids = $id;
			}

			foreach($ids as $id) {
				$where = array('id' => $id);
				$att_info = $this->db->get_one('attachment', $where, 'usertimes,path');
				if ($att_info['usertimes'] > 1) {
					$this->db->update('attachment', 'usertimes = usertimes-1', $where);
				}
				else {
					$this->my_unlink(ATTACHMENT_ROOT . $att_info['path']);
					$this->db->delete('attachment', $where);
					$this->db->delete('attachment_tag_index', array('att_id'=>$id));
				}
			}
			MSG(L('delete success'), HTTP_REFERER, 1000);
        }
        else {
            if (!$url) MSG('url del ' . L('operation_failure'), HTTP_REFERER, 3000);
            $path = str_ireplace(ATTACHMENT_URL, '', $url);
            if ($path) {
                $where = array('path' => $path);
                $att_info = $this->db->get_one('attachment', $where, 'usertimes,id');

                if (empty($att_info)) {
                    $this->my_unlink(ATTACHMENT_ROOT . $path);
                    MSG(L('operation_success'), HTTP_REFERER, 3000);
                }

                if ($att_info['usertimes'] > 1) {
                    $this->db->update('attachment', 'usertimes = usertimes-1', array('id' => $att_info['id']));
                }
                else {
                    $this->my_unlink(ATTACHMENT_ROOT . $path);
                    $this->db->delete('attachment', array('id' => $att_info['id']));
                    MSG(L('operation_success'), HTTP_REFERER, 3000);
                }
            }
            else {
                MSG(L('operation_failure'), HTTP_REFERER, 3000);
            }
        }
    }

    /**
     * 预览附件的缩略图
     *
     * @author tuzwu
     * @createtime
     * @modifytime
     * @param
     * @return
     */
    public function thumb()
    {
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : '';
        $url = isset($GLOBALS['url']) ? remove_xss($GLOBALS['url']) : '';
        if (!$id && !$url) MSG(L('operation_failure'), HTTP_REFERER, 3000);
    }

    /**
     * 附件删除,要同时删除缩略图,同时做一些安全认证
     *
     * @author tuzwu
     * @createtime
     * @modifytime
     * @param
     * @return
     */
    private function my_unlink($path)
    {
        if(file_exists($path)) unlink($path);
    }

    /**
     * 根据GET传值,返回where条件给主方法使用
     *
     * @author tuzwu
     * @createtime 2014-7-30 21:43:48
     * @modifytime
     * @param
     * @return string
     */
    private function search_where()
    {
        $where = '';
        $GLOBALS['start'] = isset($GLOBALS['start']) ? remove_xss($GLOBALS['start']) : '';
        $GLOBALS['end'] = isset($GLOBALS['end']) ? remove_xss($GLOBALS['end']) : '';
        $GLOBALS['userid'] = isset($GLOBALS['userid']) && $GLOBALS['userid'] ? intval($GLOBALS['userid']) : '';
        $GLOBALS['name'] = isset($GLOBALS['name']) ? sql_replace($GLOBALS['name']) : '';
        $GLOBALS['tags'] = isset($GLOBALS['tags']) ? sql_replace($GLOBALS['tags']) : '';
        $GLOBALS['order'] = isset($GLOBALS['order']) ? intval($GLOBALS['order']) : '0';

        if (!isset($GLOBALS['dosearch'])) {
            return '';
        }

        if ($GLOBALS['start'] || $GLOBALS['end']) {
            if ($GLOBALS['start'] && !$GLOBALS['end']) $where_end_time = SYS_TIME;
            if (!$GLOBALS['start'] && $GLOBALS['end']) $where_start_time = SYS_TIME - 2592000;
            if ($GLOBALS['start'] && $GLOBALS['end']) {
                $where_start_time = strtotime($GLOBALS['start']);
                $where_end_time = strtotime($GLOBALS['end']);
                if ($where_start_time > $where_end_time) list($where_start_time, $where_end_time) = array($where_end_time, $where_start_time);
            }
            $where .= " and `addtime` BETWEEN '$where_start_time' AND '$where_end_time' ";
        }

        if ($GLOBALS['userid']) {
            $where .= ' and userid ="' . $GLOBALS['userid'] . '" ';
        }

        if ($GLOBALS['name']) {
            $where .= ' and instr (`name`,"' . $GLOBALS['name'] . '") ';
        }

        if ($GLOBALS['tags']) {
            $where .= ' and tags like "%' . $GLOBALS['tags'] . '%" ';
        }

        if ($GLOBALS['order']) {
            switch ($GLOBALS['order']) {
                case 1:
                    $order_by = 'filesize DESC';
                    break;

                case 2:
                    $order_by = 'filesize ASC';
                    break;

                case 4:
                    $order_by = 'id ASC';
                    break;

                default:
                    $order_by = 'id DESC';
                    break;
            }
            $this->order_by = $order_by;
        }

        return $where;
    }
}