<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangyong <wayo@sina.cn>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', M);
class biz_company extends WUZHI_foreground{
	function __construct() {
		$this->member = load_class('member', M);
		load_function('common', M);
		$this->setting = get_cache('setting', M);
		parent::__construct();
	}

	/**
	 * 我的公司
	 */
	public function mycompany(){
			$memberinfo = $this->memberinfo;
			if($memberinfo['ischeck_mobile']==0) {
				MSG('您的手机还未验证！请先验证！','index.php?m=member&f=index&v=edit_mobile',3000);
			}
			$cid = 49;
			if(!$cid) {
				MSG('请选择要发布的信息分类！');
			}
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

				$data = $this->db->get_one($formdata['master_table'], array('owner' => $uid));

				if($data) {//更新
					$id = $formdata['master_data']['id'] = $data['id'];
					if($data['title'] && $data['status']==9) unset($formdata['master_data']['title'],$formdata['master_data']['status']);
					$this->db->update($formdata['master_table'],$formdata['master_data'],array('id'=>$id));
					if(!empty($formdata['attr_table'])) {
						$this->db->update($formdata['attr_table'],$formdata['attr_data'],array('id'=>$id));
					}
//执行更新
					require get_cache_path('content_update','model');
					$form_update = new form_update($modelid);

					$form_update->execute($formdata);
					MSG('公司信息更新成功！',HTTP_REFERER);
				} else {
					$formdata['master_data']['owner'] = $uid;
					$id = $this->db->insert($formdata['master_table'],$formdata['master_data']);
					//生成url
					$urlclass = load_class('url','content',$cate_config);
					$urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route']));

					$this->db->update($formdata['master_table'],array('url'=>$urls['url']),array('id'=>$id));
					if(!empty($formdata['attr_table'])) {
						$formdata['attr_data']['id'] = $id;
						$this->db->insert($formdata['attr_table'],$formdata['attr_data']);
					}
					$formdata['master_data']['url'] = $urls['url'];
					//执行更新
					require get_cache_path('content_update','model');
					$form_update = new form_update($modelid);
					$data = $form_update->execute($formdata);

					//统计表加默认数据
					$this->db->insert('content_rank',array('cid'=>$cid,'id'=>$id,'updatetime'=>SYS_TIME));
					MSG('公司信息已提交，我们将在24小时内进行审核！',HTTP_REFERER,5000);
				}
			} else {
				$categorys = get_cache('category','content');
				$models = get_cache('model_content','model');

				load_function('content','content');
				load_function('template');

				$modelid = $categorys[$cid]['modelid'];
				$model_r = $models[$modelid];
				$master_table = $model_r['master_table'];

				$master_table = $model_r['master_table'];
				$data = $this->db->get_one($master_table,array('owner'=>$uid));
				if($model_r['attr_table']) {
					$attr_table = $model_r['attr_table'];
					if($data['modelid']) {
						$modelid = $data['modelid'];
						$attr_table = $model_r['attr_table'];
					}
					$attrdata = $this->db->get_one($attr_table,array('id'=>$data['id']));
					$data = array_merge($data,$attrdata);
				}


				$status = 1;
				require get_cache_path('content_form','model');
				$form_build = new form_build($modelid);
				$form_build->cid = $cid;

				$form_build->extdata['catname'] = '';
				$form_build->extdata['type'] = '0';

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
				include T('member','biz_mycompany');
			}

		}
}