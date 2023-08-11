<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 专题管理
 */
load_class('admin');

class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
	/**
	 * 专题列表
	 */
	public function listing() {
		$status = array('1'=>'未发布','9'=>'<font color="green">已发布</font>');
		$upgrade_status = array('0'=>'停止更新','9'=>'<font color="green">长期更新</font>');
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$keyid = sql_replace($GLOBALS['keyid']);

		$where = "`status`!=0";
		$result = $this->db->get_list('topic', $where, '*', 0, 20,$page,'tid DESC');
		foreach($result as $k=>$v){
		    $result[$k]['url'] = '/index.php?m=topic&f=index&v=init&tid='.$v['tid'];
        }
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_formjs = 1;
		$show_dialog = 1;
		include $this->template('topic_listing');
	}
	/**
	 * 添加专题
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			$formdata =  $GLOBALS['form'];
			$formdata['addtime'] = SYS_TIME;
			$formdata['files'] = array2string($formdata['files']);
			$this->db->insert('topic', $formdata);
			MSG(L('operation success'),HTTP_REFERER);
		} else {
			$show_formjs = 1;
			$show_dialog = 1;
			$this->form = $form = load_class('form');
			$options = $this->db->get_list('kind',array('keyid'=>'topic'));
			$options = key_value($options,'kid','name');
			$style_options = $this->db->get_list('kind',array('keyid'=>'topic_style'));
			$style_options = key_value($style_options,'kid','name');

			load_function('template');
			$field_images = $this->images(array('field'=>'files'), '');
			include $this->template('topic_add');
		}
	}
	/**
	 * 排序
	 */
	public function sort() {
		if(isset($GLOBALS['submit'])) {
			foreach($GLOBALS['sorts'] as $cid => $n) {
				$n = intval($n);
				$this->db->update('topic',array('sort'=>$n),array('tid'=>$cid));
			}
			MSG(L('operation success'),HTTP_REFERER);
		} else {
			MSG(L('operation failure'));
		}
	}
	/**
	 * 删除专题
	 */
	public function delete() {
		$tid = intval($GLOBALS['tid']);
		$this->db->update('topic',array('status'=>0),array('tid'=>$tid));
		MSG(L('delete success'),HTTP_REFERER,1500);
	}

	/**
	 * 编辑
	 */
	public function edit() {
		$tid = intval($GLOBALS['tid']);
		if(isset($GLOBALS['submit'])) {
			$formdata = $GLOBALS['form'];
			$formdata['files'] = array2string($formdata['files']);
			$this->db->update('topic', $formdata, array('tid' => $tid));
			MSG('更新成功','?m=topic&f=index&v=listing'.$this->su());
		} else {

			$show_formjs = 1;
			$show_dialog = 1;
			$this->form = $form = load_class('form');
			load_function('template');
			$options = $this->db->get_list('kind',array('keyid'=>'topic'));
			$options = key_value($options,'kid','name');
			$style_options = $this->db->get_list('kind',array('keyid'=>'topic_style'));
			$style_options = key_value($style_options,'kid','name');

			$data = $this->db->get_one('topic', array('tid' => $tid));
			$field_images = $this->images(array('field'=>'files'), $data['files']);

			include $this->template('topic_edit');
		}
	}
	/**
	 * 专题内容管理
	 */
	public function list_manage() {
		//$this->sharedb = new WUZHI_db('server_mysql_share');
		$this->sharedb = $this->db;
		$status = array('1'=>'待审核','9'=>'<font color="green">已发布</font>');
		$upgrade_status = array('0'=>'停止更新','9'=>'<font color="green">长期更新</font>');
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page,1);
		$keyid = sql_replace($GLOBALS['keyid']);
		$tid = intval($GLOBALS['tid']);
		$data = $this->db->get_one('topic', array('tid' => $tid));

		$result = $this->db->get_list('topic_content', array('tid'=>$tid), '*', 0, 20,$page,'tcid DESC');
		$pages = $this->db->pages;
		$total = $this->db->number;
		$show_formjs = 1;
		$show_dialog = 1;
		
		include $this->template('list_manage');
	}
	/**
	 * 导入共享内容
	 */
	/**
	public function import_share() {
		$tid = intval($GLOBALS['tid']);
		$this->sharedb = new WUZHI_db('server_mysql_share');
		if(isset($GLOBALS['ids'])) {
			$formdata = array();
			$formdata['tid'] = $tid;
			$formdata['kid1'] = intval($GLOBALS['kid1']);
			$formdata['kid2'] = intval($GLOBALS['kid2']);
			$kid1_r = $this->db->get_one('kind', array('kid' => $formdata['kid1']));
			$kid2_r = $this->db->get_one('kind', array('kid' => $formdata['kid2']));
			$formdata['kid1name'] = $kid1_r['name'];
			$formdata['kid2name'] = $kid2_r['name'];
			$formdata['importtime'] = SYS_TIME;
			foreach ($GLOBALS['ids'] as $sid) {
				$formdata['sid'] = $sid;
				$this->db->insert('topic_content', $formdata);
			}
			MSG('导入成功',HTTP_REFERER);
		} else {
			$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
			$page = max($page,1);
			$keyid = sql_replace($GLOBALS['keyid']);

			$data = $this->db->get_one('topic', array('tid' => $tid));
			$kid1s = $this->db->get_list('kind', array('keyid'=>'topic'), '*', 0, 100, 0, 'sort DESC,kid ASC');
			$kid2s = $this->db->get_list('kind', array('keyid'=>'topic'.$tid), '*', 0, 100, 0, 'sort DESC,kid ASC');
			$result = $this->sharedb->get_list('share_item', '', '*', 0, 20,$page,'sid DESC');
			$pages = $this->sharedb->pages;
			$total = $this->sharedb->number;
			$show_formjs = 1;
			$show_dialog = 1;

			include $this->template('import_share');
		}
	}
	 **/

	/**
	 * 导入内容
	 */
	public function import() {
		$tid = intval($GLOBALS['tid']);

		if(isset($GLOBALS['ids'])) {
			$formdata = array();
			$formdata['tid'] = $tid;
			$formdata['kid1'] = intval($GLOBALS['kid1']);
			$formdata['kid2'] = intval($GLOBALS['kid2']);
			$kid1_r = $this->db->get_one('kind', array('kid' => $formdata['kid1']));
			$kid2_r = $this->db->get_one('kind', array('kid' => $formdata['kid2']));
			$formdata['kid1name'] = $kid1_r['name'];
			$formdata['kid2name'] = $kid2_r['name'];
			$formdata['importtime'] = SYS_TIME;

			foreach ($GLOBALS['ids'] as $sid) {
				$formdata['id'] = $sid;
				$data = $this->db->get_one('content_share', array('id' => $sid));
				//$data2 = $this->db->get_one('news_data', array('id' => $sid));
				$formdata['title'] = $data['title'];
				$formdata['islink'] = 1;
				$formdata['status'] = $data['status'];
				//$formdata['thumb'] = $data['thumb'];
				//$formdata['content'] = $data2['content'];
				$this->db->insert('topic_content', $formdata);
			}
			MSG('导入成功','/index.php?m=topic&f=index&v=list_manage&tid='.$tid.'&_su='.$GLOBALS['_su']);
		} else {
			$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
			$page = max($page,1);
			$categorys = get_cache('category','content');
			$keyid = sql_replace($GLOBALS['keyid']);

			$data = $this->db->get_one('topic', array('tid' => $tid));
			$kid1s = $this->db->get_list('kind', array('keyid'=>'topic'), '*', 0, 100, 0, 'sort DESC,kid ASC');
			$kid2s = $this->db->get_list('kind', array('keyid'=>'topic'.$tid), '*', 0, 100, 0, 'sort DESC,kid ASC');
			//这里指定只有新闻的模型可以导入
            $fieldName = $GLOBALS['fieldtype'];
            $keyword = $GLOBALS['keywords'];
            $where = '';
            $where .= "`modelid`=1 AND `status`=9";
            if(!empty($keyword)){
                $where .= " AND `{$fieldName}` LIKE '%{$keyword}%'";
            }
			$result = $this->db->get_list('content_share', $where, '*', 0, 20,$page,'id DESC');
			$pages = $this->db->pages;
			$total = $this->db->number;
			$show_formjs = 1;
			$show_dialog = 1;

			include $this->template('import');
		}
	}
	/**
	 * 删除内容列表
	 */
	public function list_delete() {
		$tcid = intval($GLOBALS['tcid']);
		$this->db->delete('topic_content',array('tcid'=>$tcid));
		MSG(L('delete success'),HTTP_REFERER,1500);
	}
	/**
     * 内容批量删除
     */
    public function delete_more() {
        foreach($GLOBALS['tcids'] as $tcid) {
				$this->db->delete('topic_content',array('tcid'=>$tcid));
        }
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
	/**
	 * 专题内容排序
	 */
	public function list_sort() {
		if(isset($GLOBALS['submit'])) {
			foreach($GLOBALS['sorts'] as $cid => $n) {
				$n = intval($n);
				$this->db->update('topic_content',array('sort'=>$n),array('tcid'=>$cid));
			}
			MSG(L('operation success'),HTTP_REFERER);
		} else {
			MSG(L('operation failure'));
		}
	}
	/**
	 * 专题内容添加
	 */
	public function add_content() {
		$tid = intval($GLOBALS['tid']);
		if(isset($GLOBALS['submit'])) {
			$formdata =  $GLOBALS['form'];
			$formdata['tid'] = $tid;
			$formdata['importtime'] = SYS_TIME;
			$kid1_r = $this->db->get_one('kind', array('kid' => $formdata['kid1']));
			$kid2_r = $this->db->get_one('kind', array('kid' => $formdata['kid2']));
			$formdata['kid1name'] = $kid1_r['name'];
			$formdata['kid2name'] = $kid2_r['name'];
			$this->db->insert('topic_content', $formdata);
			MSG(L('operation success'),'?m=topic&f=index&v=list_manage&tid='.$tid.$this->su());
		} else {
			$show_formjs = 1;
			$show_dialog = 1;
			$form = load_class('form');
			$topic = $this->db->get_one('topic', array('tid' => $tid));
			$kid1 = $topic['kid'];
			$options = $this->db->get_list('kind',array('keyid'=>'topic'.$tid));
			$options = key_value($options,'kid','name');
			load_function('template');
			include $this->template('add_content');
		}
	}
	/**
	 * 专题内容修改
	 */
	public function edit_content() {
		$tcid = intval($GLOBALS['tcid']);
		if(isset($GLOBALS['submit'])) {
			$formdata =  $GLOBALS['form'];
			$formdata['importtime'] = SYS_TIME;
			$kid1_r = $this->db->get_one('kind', array('kid' => $formdata['kid1']));
			$kid2_r = $this->db->get_one('kind', array('kid' => $formdata['kid2']));
			$formdata['kid1name'] = $kid1_r['name'];
			$formdata['kid2name'] = $kid2_r['name'];
			$this->db->update('topic_content', $formdata,array('tcid'=>$tcid));
			MSG(L('operation success'),$GLOBALS['forward']);
		} else {
			$show_formjs = 1;
			$show_dialog = 1;
			$form = load_class('form');
			$data = $this->db->get_one('topic_content', array('tcid' => $tcid));
			$tid = $data['tid'];
			$topic = $this->db->get_one('topic', array('tid' => $tid));
			$kid1 = $topic['kid'];
			$options = $this->db->get_list('kind',array('keyid'=>'topic'.$tid));
			$options = key_value($options,'kid','name');
			load_function('template');

			include $this->template('edit_content');
		}
	}
    /*
     * 推荐位slider显示
     */
    function recommend(){
        $tcid = $GLOBALS['tcid'];
        $recommend = $GLOBALS['recommend'];
        $result = $this->db->update('topic_content',array('recommend'=>$recommend),array('tcid'=>$tcid));
        MSG(L('操作成功！'),HTTP_REFERER,1500);
    }

	private function images($config, $value){
		if (!empty($value)) $value = string2array($value);
		extract($config, EXTR_SKIP);
		$str = '<script src="/res/libs/jquery-ui/jquery-ui.min.js"></script>';
		$str .= '<script>
            $(function() {
                $( "#'.$field.'_ul" ).sortable();
                $( "#'.$field.'_ul" ).disableSelection();
            });
        </script>';
		$default_multiple = '';
		if ($value && is_array($value)) {
			foreach ($value AS $k => $v) {
				$default_multiple .= '<li id="file_node_' . $k . '" class="d-inline-block me-2 mb-2"><div class="card"><img  class="p-2" src="' . $v['url'] . '" alt="' . $v['alt'] . '" onclick="img_view(this.src);"><input type="hidden" name="form[' . $field . '][' . $k . '][url]" value="' . $v['url'] . '"><div class="card-body pt-0 px-2"><textarea class="form-control" rows="3" name="form[' . $field . '][' . $k . '][alt]" >' . $v['alt'] . '</textarea> <a class="btn btn-danger btn-sm btn-xs p-1 w-100 mt-2" href="javascript:remove_file(' . $k . ');">移除</a></div></div></li>';
			}
		}
		$str2 = '<div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';

		return $str . '<div class="attaclist">' . $str2 . $this->form->attachment("jpg|png|gif|bmp", 20, "form[$field]", $value, 'callback_images2', 0,true) . '</div>';
	}
}
