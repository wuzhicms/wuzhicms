<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 信息发布到指定栏目
 */
load_class('foreground', 'member');
class postinfo extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
		//判断当前是否验证了邮箱和手机
        if(!$this->memberinfo['ischeck_email']) {
            MSG('请先验证您的邮箱!','?m=member&f=index&v=edit_email&set_iframe='.$GLOBALS['set_iframe'],3000);
        }
		if($this->member_setting['checkmobile'] && !$this->memberinfo['ischeck_mobile']) {
			MSG('您的手机还未验证！请先验证！','index.php?m=member&f=index&v=edit_mobile&set_iframe='.$GLOBALS['set_iframe'],3000);
		}
	}

	/**
	 * 允许投稿的栏目列表
	 */
	public function contribute_list() {
		$categorys = get_cache('category','content');
		/**
		 * $formdata['groupid'] = $groupid;
		$formdata['value'] = $cid;
		$formdata['priv']
		 */
		$uid = $this->uid;
		$groupid = $this->memberinfo['groupid'];
		$category_priv = array();
		$result_tmp = $this->db->get_list('member_group_priv',array('groupid'=>$groupid,'priv'=>'add'), '*', 0, 100, 0);
		foreach($result_tmp as $_r) {
			$category_priv[$_r['value']] = $categorys[$_r['value']];
		}
		$extend_result = $this->db->get_list('member_group_extend', array('uid'=>$uid), '*', 0, 20, 0);
		foreach($extend_result as $r) {
			$result_tmp = $this->db->get_list('member_group_priv',array('groupid'=>$r['groupid'],'priv'=>'add'), '*', 0, 100, 0);
			foreach($result_tmp as $_r) {
				$category_priv[$_r['value']] = $categorys[$_r['value']];
			}
		}
		include T('content','member_contribute_list');
	}
    /**
     * 列表
     */
    public function listing() {

        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $cid = intval($GLOBALS['cid']);
        $publisher = $memberinfo['username'];
		$this->priv_check($cid);
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) MSG(L('category not exists'));

        $categorys = get_cache('category','content');
        $modelid = $cate_config['modelid'];
        $models = get_cache('model_content','model');
        $master_table = $models[$modelid]['master_table'];
        $page = intval($GLOBALS['page']);
        $page = max($page,1);

        $where = "`cid`='$cid' AND `publisher`='$publisher'";

        $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
		$catname = $cate_config['name'];
        include T('content','member_postinfo_listing');
    }
	//权限判断
	private function priv_check($cid) {
		$uid = $this->uid;
		$groupid = $this->memberinfo['groupid'];
		$category_priv = array();
		$result_tmp = $this->db->get_list('member_group_priv',array('groupid'=>$groupid,'value'=>$cid,'priv'=>'add'), '*', 0, 100, 0);

		$no_priv = true;//初始化,没有权限
		if(empty($result_tmp)) {
			$extend_result = $this->db->get_list('member_group_extend', array('uid'=>$uid), '*', 0, 20, 0);
			foreach($extend_result as $r) {
				$result_tmp = $this->db->get_list('member_group_priv',array('groupid'=>$r['groupid'],'value'=>$cid,'priv'=>'add'), '*', 0, 100, 0);
				if(!empty($result_tmp)) {
					$no_priv = false;
					break;
				}
			}
		} else {
			$no_priv = false;
		}
		if($no_priv) {
			MSG('没有权限!');
		}
	}
    /**
     * 信息发布
     */
    public function newinfo() {
        $memberinfo = $this->memberinfo;

        $cid = intval($GLOBALS['cid']);
        if(!$cid) {
            MSG('请选择要发布的信息分类！');
        }
		$this->priv_check($cid);
        $uid = $memberinfo['uid'];
        if(isset($GLOBALS['submit'])) {

            $cate_config = get_cache('category_'.$cid,'content');
            if(!$cate_config) MSG(L('category not exists'));
            //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
            if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
                $modelid = $GLOBALS['modelid'];
            } else {
                $modelid = $cate_config['modelid'];
            }

                $formdata = $GLOBALS['form'];
                $formdata['title'] = remove_xss($formdata['title']);
                //添加数据之前，将用户提交的数据按照字段的配置，进行处理
                require get_cache_path('content_add','model');
                $form_add = new form_add($modelid);
                $formdata = $form_add->execute($formdata);

                //插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
                $addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
                $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;
                //如果是共享模型，那么需要在将字段modelid增加到数据库
                if($formdata['master_table']=='content_share') {
                    $formdata['master_data']['modelid'] = $modelid;
                }
                $formdata['master_data']['cid'] = $cid;
                //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
                $formdata['master_data']['status'] = 1;

                //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
                $formdata['master_data']['route'] = 0;
                $formdata['master_data']['publisher'] = $memberinfo['username'];

                //echo $formdata['master_table'];exit;
                if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
                    $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
                }
                //处理前台特殊字段

                //$formdata['master_data']['type'] = 2;//团购类型


                $id = $this->db->insert($formdata['master_table'],$formdata['master_data']);
                //生成url
                $urlclass = load_class('url','content',$cate_config);
                $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route']));

                $this->db->update($formdata['master_table'],array('url'=>$urls['url']),array('id'=>$id));
                if(!empty($formdata['attr_table'])) {
                    $formdata['attr_data']['id'] = $id;
                    // print_r($formdata['attr_data']);exit;
                    $this->db->insert($formdata['attr_table'],$formdata['attr_data']);
                }
                $formdata['master_data']['url'] = $urls['url'];
                //执行更新
                require get_cache_path('content_update','model');
                $form_update = new form_update($modelid);
                $data = $form_update->execute($formdata);

                //统计表加默认数据
                $this->db->insert('content_rank',array('cid'=>$cid,'id'=>$id,'updatetime'=>SYS_TIME));
            MSG('信息发布成功，我们将在24小时内进行审核！','?f=postinfo&v=listing&cid='.$cid.'&set_iframe='.$GLOBALS['set_iframe'],3000);
        } else {
            $categorys = get_cache('category','content');
            load_function('content','content');
            //
            $modelid = $categorys[$cid]['modelid'];

            $model_r = get_cache('field_'.$modelid,'model');

            load_function('template');
            $status = 1;
            require get_cache_path('content_form','model');
            $form_build = new form_build($modelid);
            $form_build->cid = $cid;
            
            $form_build->extdata['catname'] = '';
            $form_build->extdata['type'] = '0';
            $formdata = $form_build->execute();
            load_class('form');
            $show_formjs = 1;
            $show_dialog = 1;

            $field_list = '';
            if(is_array($formdata['0'])) {
                foreach($formdata['0'] as $field=>$info) {
                    if($info['powerful_field'] || $info['ban_contribute']==0) continue;
                    if($info['formtype']=='powerful_field') {
                        foreach($formdata['0'] as $_fm=>$_fm_value) {
                            if($_fm_value['powerful_field']) {
                                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                            }
                        }
                        foreach($formdata['1'] as $_fm=>$_fm_value) {
                            if($_fm_value['powerful_field']) {
                                $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                            }
                        }
                    }
                    $field_list[] = $info;
                }
            }
			
			$catname = $categorys[$cid]['name'];
            include T('content','member_postinfo_newinfo');
        }

    }

    /**
     * 修改信息
     */
    public function editinfo() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        $this->db->update('gsxq', array('status'=>'0'), array('id' => $id,'publisher'=>$memberinfo['username']));
    }

    /**
     * 删除信息
     */
    public function delinfo() {
        $cid = intval($GLOBALS['cid']);
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) MSG(L('category not exists'));

        $categorys = get_cache('category','content');
        $modelid = $cate_config['modelid'];
        $models = get_cache('model_content','model');
        $master_table = $models[$modelid]['master_table'];

        $this->db->update($master_table, array('status'=>'0'), array('id' => $id,'publisher'=>$memberinfo['username']));
        MSG('删除成功！',HTTP_REFERER);
    }
/**
    public function referer() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        if($memberinfo['points']<10) {
            exit('2');
        }
        $this->db->update('jgfb', array('updatetime'=>SYS_TIME), array('id' => $id));
        $credit_api = load_class('credit_api','credit');
        $credit_api->handle($memberinfo['uid'], '-',10, '刷新信息消耗',$id);
        exit('1');
    }
**/
    /**
     * 选择栏目项
     */
    public function select_cid() {
        $cids = $GLOBALS['cids'];
        $cids = explode('-',$cids);
        $categorys = get_cache('category','content');
        include T('content','member_select_cid');
    }

    public function edit() {
		$memberinfo = $this->memberinfo;
		$uid = $memberinfo['uid'];
		$id = intval($GLOBALS['id']);
		$cid = intval($GLOBALS['cid']);
		$cate_config = get_cache('category_'.$cid,'content');
		if(!$cate_config) MSG(L('category not exists'));
		//如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
		if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
			$modelid = $GLOBALS['modelid'];
		} else {
			$modelid = $cate_config['modelid'];
		}
		$models = get_cache('model_content','model');
		$model_r = $models[$modelid];
		$master_table = $model_r['master_table'];
		$data = $this->db->get_one($master_table,array('id'=>$id));
		if($data['status']==0) MSG('内容已删除！不允许修改！');

		if(isset($GLOBALS['submit'])) {
			$formdata = $GLOBALS['form'];
			//插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
			$addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
			//添加数据之前，将用户提交的数据按照字段的配置，进行处理
			require get_cache_path('content_add','model');
			$form_add = new form_add($modelid);
			$formdata = $form_add->execute($formdata);
			$formdata['master_data']['addtime'] = $addtime;
			$formdata['master_data']['updatetime'] = SYS_TIME;
			//如果是共享模型，那么需要在将字段modelid增加到数据库
			if($formdata['master_table']=='content_share') {
				$formdata['master_data']['modelid'] = $modelid;
			}
			$formdata['master_data']['cid'] = $cid;
			//默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
			$formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 1;
			//非超级管理员，验证该栏目是否设置了审核
			if($cate_config['workflowid'] && $_SESSION['role']!=1 && in_array($formdata['master_data']['status'],array(9,8))) {
				$formdata['master_data']['status'] = 9;
			}
			//如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
			$formdata['master_data']['route'] = intval($GLOBALS['form']['route']);
			//标题样式
			$title_css = preg_match('/([a-z0-9]+)/i',$GLOBALS['title_css']) ? $GLOBALS['title_css'] : '';
			$formdata['master_data']['css'] = $title_css;

			if($cate_config['type']) {
				$urls['url'] = $cate_config['url'];
			} elseif($formdata['master_data']['route']>1) {//外部链接/或者自定义链接
				$urls['url'] = remove_xss($GLOBALS['url']);
			} else {
				//生成url
				$urlclass = load_class('url','content',$cate_config);
				$urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route']));
			}
			$formdata['master_data']['url'] = $urls['url'];

			if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
				$formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
			}
			$this->db->update($formdata['master_table'],$formdata['master_data'],array('id'=>$id));
			if(!empty($formdata['attr_table'])) {
				$this->db->update($formdata['attr_table'],$formdata['attr_data'],array('id'=>$id));
			}

			//执行更新
			require get_cache_path('content_update','model');
			$form_update = new form_update($modelid);

			$formdata['master_data']['id'] = $id;
			$form_update->execute($formdata);
			$forward = '?m=content&f=postinfo&v=listing&cid='.$cid;
			MSG(L('update success'),$forward,1000);
		} else {
			if($model_r['attr_table']) {
				$attr_table = $model_r['attr_table'];
				if($data['modelid']) {
					$modelid = $data['modelid'];
					$attr_table = $models[$modelid]['attr_table'];
				}

				$attrdata = $this->db->get_one($attr_table,array('id'=>$id));

				if($attrdata) $data = array_merge($data,$attrdata);
			}

			load_function('template');
			load_function('content','content');
			$status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
			require get_cache_path('content_form','model');
			$form_build = new form_build($modelid);
			$form_build->cid = $cid;
			$category = get_cache('category','content');
			$form_build->extdata['catname'] = $cate_config['name'];
			$form_build->extdata['type'] = $cate_config['type'];

			$formdata = $form_build->execute($data);

			load_class('form');
			$show_formjs = 1;
			$show_dialog = 1;
			$field_list = '';
			if(is_array($formdata['0'])) {
				foreach($formdata['0'] as $field=>$info) {
					if($info['powerful_field'] || $info['ban_contribute']==0) continue;
					if($info['formtype']=='powerful_field') {
						foreach($formdata['0'] as $_fm=>$_fm_value) {
							if($_fm_value['powerful_field']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
							}
						}
						foreach($formdata['1'] as $_fm=>$_fm_value) {
							if($_fm_value['powerful_field']) {
								$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
							}
						}
					}
					$field_list[] = $info;
				}
			}

			include T('content','member_postinfo_edit');
		}
	}
}