<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容添加
 */
load_class('admin');
define('HTML',true);
class content extends WUZHI_admin {
    private $status_array = array(
        9=>'审核通过',
        8=>'定时发送',
        1=>'一审',
        2=>'二审',
        3=>'三审',
        0=>'回收站',
        7=>'退稿',
        6=>'草稿',
    );
    private $status_array2 = array(
        8=>'定时发送',
        10=>'一审~三审',
        0=>'回收站',
        7=>'退稿',
        6=>'草稿',
    );
    function __construct() {
        $this->db = load_class('db');
        $this->private_check();
    }
    public function manage() {
        $modelid = isset($GLOBALS['modelid']) ? intval($GLOBALS['modelid']) : 0;
        include $this->template('content_manage');
    }
    public function left() {
        $siteid = get_cookie('siteid');
        $where = array('keyid'=>'content','siteid'=>$siteid);

        if(isset($GLOBALS['modelid']) && $GLOBALS['modelid']!=0) {
            $where['modelid'] = intval($GLOBALS['modelid']);
        } else {
            $result = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
        }

        if(empty($result)) {
            $category_tree = '';
        } else {
            $tree = load_class('tree','core',$result);
            $category_tree = $tree->get_treeview(0,'tree', "<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a></li>","<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a>");
        }
        include $this->template('content_left');
    }
    public function listing() {
        //默认显示共享模型数据，即modelid为0.
        //默认status为9 通过审核
        $type = intval($GLOBALS['type']);
        $title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        if($cid) {
            $cate_config = get_cache('category_'.$cid,'content');
            if(!$cate_config) MSG(L('category not exists'));
            $modelid = $cate_config['modelid'];
            $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
            $master_table = $model_r['master_table'];
            if($modelid==2) {
                $where = "`cid`='$cid' AND `status`='$status' AND `type`='$type'";
            } else {
                $where = "`cid`='$cid' AND `status`='$status'";
            }
            if($title) $where .= " AND `title` LIKE '%$title%'";
            //单网页
            if($cate_config['type']==1) {
                $r = $this->db->get_one($master_table,array('cid'=>$cid));
                if(!$r) {
                    header("Location: index.php?m=content&f=content&v=add&modelid=".$cate_config['modelid']."&cid=".$cid.$this->su());
                } else {
                    header("Location: index.php?m=content&f=content&v=edit&modelid=".$cate_config['modelid']."&cid=".$cid.'&id='.$r['id'].$this->su());
                }
            }
        } else {
            $modelid = 0;
			$siteid= get_cookie('siteid');
            $master_table = 'content_share';
            $where = "`status`='$status'";
            $categorys = get_cache('category','content');
            if($title) $where .= " AND `title` LIKE '%$title%'";
			$cids = array();
			foreach($categorys as $_cid=>$_res) {
				if($_res['siteid']==$siteid) $cids[] = $_cid;
			}
			if(!empty($cids)) {
				$cids = implode(',',$cids);
				$where .= " AND `cid` IN($cids)";
			}

        }
        $page = intval($GLOBALS['page']);
        $page = max($page,1);
        $models = get_cache('model_content','model');
        $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'sort DESC');
        //$result = array();
        $pages = $this->db->pages;

        include $this->template('content_listing');
    }

    /**
     * 审核所有待审内容，根据模型
     */
    public function allcheck() {
        $categorys = get_cache('category','content');
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : '10';
        $models = get_cache('model_content','model');
        if($status=='10') {
            $where = "`status` IN(1,2,3)";
        } else {
            $where = "`status`='$status'";
        }
		$siteid= get_cookie('siteid');

		$cids = array();
		foreach($categorys as $_cid=>$_res) {
			if($_res['siteid']==$siteid) $cids[] = $_cid;
		}
		$cids = implode(',',$cids);
		$where .= " AND `cid` IN($cids)";

        $result = array();
        $result[0] = $this->db->get_list('content_share',$where, '*', 0, 20,0,'id DESC');
        foreach($models as $key=>$model) {
            $master_table = $model['master_table'];
            if($master_table=='content_share') continue;
            $result[$key] = $this->db->get_list($master_table,$where, '*', 0, 20,0,'id DESC');
        }
        //print_r($result);
        include $this->template('content_allcheck');
    }
    public function add() {
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) MSG(L('category not exists'));
        //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
        if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
            $modelid = $GLOBALS['modelid'];
        } else {
            $modelid = $cate_config['modelid'];
        }

        if(isset($GLOBALS['submit']) || isset($GLOBALS['submit2'])) {
            $formdata = $GLOBALS['form'];
			//插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
			$addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
            //添加数据之前，将用户提交的数据按照字段的配置，进行处理
            require get_cache_path('content_add','model');
            $form_add = new form_add($modelid);
            $formdata = $form_add->execute($formdata);
            $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;
            //如果是共享模型，那么需要在将字段modelid增加到数据库
            if($formdata['master_table']=='content_share') {
                $formdata['master_data']['modelid'] = $modelid;
            }
            $formdata['master_data']['cid'] = $cid;
            //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
            $formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 9;
            //非超级管理员，验证该栏目是否设置了审核
            if($cate_config['workflowid'] && $_SESSION['role']!=1 && in_array($formdata['master_data']['status'],array(9,8))) {
                $formdata['master_data']['status'] = 1;
            }

            //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
            $formdata['master_data']['route'] = intval($GLOBALS['form']['route']);
            $formdata['master_data']['publisher'] = get_cookie('username');
            //标题样式
            $title_css = preg_match('/([a-z0-9]+)/i',$GLOBALS['title_css']) ? $GLOBALS['title_css'] : '';
            $formdata['master_data']['css'] = $title_css;
            //echo $formdata['master_table'];exit;
            if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
                $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
            }

            $id = $this->db->insert($formdata['master_table'],$formdata['master_data']);
            if($cate_config['type']) {
                $urls['url'] = $cate_config['url'];
            } elseif($formdata['master_data']['route']>1) {//外部链接
                $urls['url'] = remove_xss($GLOBALS['url']);
            } else {
                //生成url
                $urlclass = load_class('url','content',$cate_config);
                $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route']));
            }


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

            //判断是否存在，防止意外发生
            if(!$this->db->get_one('content_rank',array('cid'=>$cid,'id'=>$id))) {
                //统计表加默认数据
                $this->db->insert('content_rank',array('cid'=>$cid,'id'=>$id,'updatetime'=>SYS_TIME));
            }
            //生成静态
            if($cate_config['showhtml'] && $formdata['master_data']['status']==9) {
                $data = $this->db->get_one($formdata['master_table'],array('id'=>$id));
                if(!empty($formdata['attr_table'])) {
                    $attrdata = $this->db->get_one($formdata['attr_table'],array('id'=>$id));
                    $data = array_merge($data,$attrdata);
                }
                //上一页
                $data['previous_page'] = $this->db->get_one($formdata['master_table'],"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                //下一页
                $data['next_page'] = '';
                $this->html = load_class('html','content');
                $this->html->set_category($cate_config);
                $this->html->set_categorys();
                $this->html->load_formatcache();
                $this->html->show($data,1,1,$urls['root']);
                $loadhtml = true;
            } else {
                $loadhtml = false;
            }
            //生成相关栏目列表
            if($cate_config['listhtml']) {
                if($loadhtml==false) {
                    $this->html = load_class('html','content');
                    $this->html->set_category($cate_config);
                    $this->html->set_categorys();
                    $loadhtml = true;
                }
                for($i=1;$i<6;$i++) {
                    $cateurls = $urlclass->listurl(array('cid'=>$cid,'page'=>$i));
                    $this->html->listing($cateurls['root'],$i);
                    if($GLOBALS['result_lists']==0) {
                        break;
                    }
                }
            }
            //生成首页
            if($loadhtml) {
                $this->html->index();
            } else {
                $this->html = load_class('html','content');
                $this->html->set_categorys();
                $this->html->index();
            }
            //添加到最新列表中
            $lastlist = get_cache('lastlist','content');
            $newcontent = array(0=>array('cid'=>$cid,'title'=>$formdata['master_data']['title'],'url'=>$urls['url'],'addtime'=>SYS_TIME));
            if(is_array($lastlist)) {
                $lastlist = array_merge($newcontent,$lastlist);
                if(count($lastlist)>100) array_pop($lastlist);
            } else {
                $lastlist = $newcontent;
            }

            set_cache('lastlist',$lastlist,'content');
            //编辑操作日志
            $this->editor_logs('add',$formdata['master_data']['title'],$urls['url'], "?m=content&f=content&v=edit&id=$id&cid=$cid");
            //设置返回地址
            if(isset($GLOBALS['submit'])) {
                MSG(L('add success'),'?m=content&f=content&v=listing&type='.$GLOBALS['type'].'&cid='.$cid.$this->su(),1000);
            } else {
                MSG(L('add success'),URL(),1000);
            }
        } else {
            load_function('template');
            load_function('content','content');
            $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
            require get_cache_path('content_form','model');
            $form_build = new form_build($modelid);
            $form_build->cid = $cid;
            $category = get_cache('category','content');
            $form_build->extdata['catname'] = $cate_config['name'];
            $form_build->extdata['type'] = $cate_config['type'];
            $formdata = $form_build->execute();
            load_class('form');
            $show_formjs = 1;
            $show_dialog = 1;

            include $this->template('content_add');
        }
    }

    public function edit() {
        if(!isset($GLOBALS['id'])) MSG(L('parameter_error'));
        $id = intval($GLOBALS['id']);
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) MSG(L('category not exists'));
        //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
        if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
            $modelid = $GLOBALS['modelid'];
        } else {
            $modelid = $cate_config['modelid'];
        }

        if(isset($GLOBALS['submit']) || isset($GLOBALS['submit2'])) {
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
            $formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 9;
            //非超级管理员，验证该栏目是否设置了审核
            if($cate_config['workflowid'] && $_SESSION['role']!=1 && in_array($formdata['master_data']['status'],array(9,8))) {
                $formdata['master_data']['status'] = 1;
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
                $productid = 0;
                if(isset($formdata['master_data']['productid'])) $productid = $formdata['master_data']['productid'];
                $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route'],'productid'=>$productid));
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
            //生成静态
            if($cate_config['showhtml'] && $formdata['master_data']['status']==9) {
                $data = $this->db->get_one($formdata['master_table'],array('id'=>$id));
                if(!empty($formdata['attr_table'])) {
                    $attrdata = $this->db->get_one($formdata['attr_table'],array('id'=>$id));
                    $data = array_merge($data,$attrdata);
                }
                //上一页
                $data['previous_page'] = $this->db->get_one($formdata['master_table'],"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                //下一页
                $data['next_page'] = $this->db->get_one($formdata['master_table'],"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                $this->html = load_class('html','content');
                $this->html->set_category($cate_config);
                $this->html->set_categorys();
                $this->html->load_formatcache();
                $this->html->show($data,1,1,$urls['root']);
                $loadhtml = true;
            } else {
                $loadhtml = false;
            }
            //生成相关栏目列表
            if($cate_config['listhtml']) {
                if($loadhtml==false) {
                    $this->html = load_class('html','content');
                    $this->html->set_category($cate_config);
                    $this->html->set_categorys();
                    $loadhtml = true;
                }
                for($i=1;$i<6;$i++) {
                    $cateurls = $urlclass->listurl(array('cid'=>$cid,'page'=>$i));
                    $this->html->listing($cateurls['root'],$i);
                    if($GLOBALS['result_lists']==0) {
                        break;
                    }
                }
            }
            //生成首页
            if($loadhtml) {
                $this->html->index();
            } else {
                $this->html = load_class('html','content');
                $this->html->set_categorys();
                $this->html->index();
            }
            //编辑操作日志
            $this->editor_logs('edit',$formdata['master_data']['title'],$urls['url'], "?m=content&f=content&v=edit&id=$id&cid=$cid");
            //设置返回地址
            $forward = isset($GLOBALS['submit2']) ? HTTP_REFERER : '?m=content&f=content&v=listing&type='.$GLOBALS['type'].'&cid='.$cid.$this->su();
            MSG(L('update success'),$forward,1000);
        } else {
            $models = get_cache('model_content','model');
            $model_r = $models[$modelid];
            $master_table = $model_r['master_table'];
            $data = $this->db->get_one($master_table,array('id'=>$id));
            if($model_r['attr_table']) {
                $attr_table = $model_r['attr_table'];
                if($data['modelid']) {
                    $modelid = $data['modelid'];
                    $attr_table = $models[$modelid]['attr_table'];
                }
                $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
                $data = array_merge($data,$attrdata);
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

            include $this->template('content_edit');
        }
    }

    /**
     * 内容预览
     */
    public function view() {
        load_function('content','content');
        $siteconfigs = get_cache('siteconfigs');
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        $categorys = get_cache('category','content');
        //查询数据
        $category = get_cache('category_'.$cid,'content');
        if(empty($category)) MSG('栏目不存在');
        $models = get_cache('model_content','model');
        $model_r = $models[$category['modelid']];
		$siteid = $category['siteid'];
        $master_table = $model_r['master_table'];
        $data = $this->db->get_one($master_table,array('id'=>$id));
        if($model_r['attr_table']) {
            $attr_table = $model_r['attr_table'];
            if($data['modelid']) {
                $modelid = $data['modelid'];
                $attr_table = $models[$modelid]['attr_table'];
            }
            $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
            $data = array_merge($data,$attrdata);
        } else {
            $modelid = $model_r['modelid'];
        }
		$model_r = $models[$modelid];
        require get_cache_path('content_format','model');
        $form_format = new form_format($modelid);
        $data = $form_format->execute($data);

        foreach($data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
		if($template) {
			$_template = $template;
		} elseif($model_r['template']) {
			$template_set = unserialize($model_r['template_set']);
			$_template = $template_set[$siteid];
		} else {
			$_template = TPLID.':show';
		}

        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : '1';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $elasticid = elasticid($cid);
        $seo_title = $title.'_'.$category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = !empty($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        //上一页
        $previous_page = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
        //下一页
        $next_page = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');

        include T('content',$_template,$project_css);
        include $this->template('check_foot');
    }
    /**
     * 内容删除到回收站
     */
    public function recycle_delete() {
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        if(!$cid) MSG(L('parameter_error'));
        $cate_config = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        $model_r = $models[$cate_config['modelid']];
        $master_table = $model_r['master_table'];
        $data = $this->db->update($master_table,array('status'=>0),array('id'=>$id));

        //删除相关文章内容
        $this->db->delete('content_relation',array('origin_id'=>$id,'origin_cid'=>$cid));
        //更新推荐位信息
        $keyid = $id.'-'.$cid;
        $this->db->update('block_data', array('status'=>0), array('keyid' => $keyid));
        //删除已生成的文件
        if($cate_config['showhtml']) {
            $r = $this->db->get_one($master_table, array('id' => $id));
            $urlclass = load_class('url', 'content', $cate_config);
            $urls = $urlclass->showurl(array('id' => $id, 'cid' => $cid, 'addtime' => $r['addtime'], 'page' => 1, 'route' => $r['route']));
            //编辑操作日志
            $this->editor_logs('delete',$r['title'],'', "?m=content&f=content&v=edit&id=$id&cid=$cid");

            //先删除绝对的文件，再删除分页
            $ext = get_ext($urls['root']);
            if (in_array($ext, array('htm', 'html', 'shtml')) && file_exists($urls['root'])) {
                @unlink($urls['root']);
                //删除静态文件，排除htm/html/shtml外的文件
                $lasttext = strrchr($urls['root'], '.');
                $len = -strlen($lasttext);
                $path = substr($urls['root'], 0, $len);
                $filelist = glob($path . '_*.'.$ext);
                foreach ($filelist as $delfile) {
                    @unlink($delfile);
                }
                $filelist = glob($path . '-*.'.$ext);
                foreach ($filelist as $delfile) {
                    @unlink($delfile);
                }
            }
        }
        //删除统计表对应数据
        if(isset($GLOBALS['close'])) {
            MSG(L('delete success').','.L('auto close')."<script>setTimeout('window.close();',2000)</script>",'',3000);
        } else {
            MSG(L('delete success'),HTTP_REFERER,1000);
        }
    }

    /**
     * 内容删除
     */
    public function delete() {
    	//获取提交的数据
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        
        //数据校验
        if(!$cid) MSG(L('parameter_error'));
        
        //读取缓存数据
        $category_r = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        
        //获取对应栏目的模型数据
        $model_r = $models[$category_r['modelid']];
        $master_table = $model_r['master_table'];
        
        //删除共享模型内容
        if ($master_table == 'content_share') {
        	//查询内容
        	$r = $this->db->get_one($master_table, array('id' => $id));
        	
        	if (isset($r['modelid'])) $model_r = $models[$r['modelid']];
        }

        //删除主表数据
        $data = $this->db->delete($master_table, array('id' => $id));
        
        //删除附属表数据
        if($model_r['attr_table']) $attrdata = $this->db->delete($model_r['attr_table'], array('id' => $id));
        
        //删除排名数据
        $this->db->delete('content_rank', array('cid' => $cid, 'id' => $id));
        
        //删除 Block 数据
        $keyid = $id.'-'.$cid;
        $this->db->delete('block_data', array('keyid' => $keyid));
        
        //返回回收站
        MSG(L('delete success'), HTTP_REFERER, 1000);
    }

    /**
     * 内容批量删除
     */
    public function delete_more() {
    	//获取提交的数据
    	$cid = intval($GLOBALS['cid']);
    	
    	//数据校验
        if(empty($GLOBALS['ids'])) MSG('没有选择任何文章');
        if(!$cid) MSG(L('parameter_error'));
        
        //读取缓存数据
        $category_r = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        
        //获取对应栏目的模型数据
        $model_r = $models[$category_r['modelid']];
        $master_table = $model_r['master_table'];
        
        //批量删除数据
        foreach($GLOBALS['ids'] as $id) {
        	//共享模型
        	if ($master_table == 'content_share') {
        		//查询内容
        		$r = $this->db->get_one($master_table, array('id' => $id));
        		 
        		if (isset($r['modelid'])) $model_r = $models[$r['modelid']];
        	}
        	
        	//删除主表数据
            $data = $this->db->delete($master_table, array('id' => $id));
            
            //删除附属表数据
            if($model_r['attr_table']) $attrdata = $this->db->delete($model_r['attr_table'], array('id' => $id));

            //删除排名数据
            $this->db->delete('content_rank', array('cid' => $cid, 'id' => $id));
            
            //删除 Block 数据
            $keyid = $id.'-'.$cid;
            $this->db->delete('block_data', array('keyid' => $keyid));
        }
        
        //返回回收站
        MSG(L('delete success'), HTTP_REFERER, 1000);
    }
    /**
     * 内容审核
     */
    public function check() {
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        if(!$cid) MSG(L('parameter_error'));
        $category_r = get_cache('category_'.$cid,'content');
        $workflowid = $category_r['workflowid'];
        $models = get_cache('model_content','model');
        $model_r = $models[$category_r['modelid']];
        $master_table = $model_r['master_table'];
        if($GLOBALS['pass']==='0') {
            $status = 7;
        } elseif($workflowid) {
            //检查权限
            $role = $_SESSION['role'];
            $workflows = $this->db->get_one('workflow', array('workflowid'=>$workflowid));
            $level = $workflows['level'];
            if($level==1) {
                $level_user = p_unserialize($workflows['level1_user']);
                if(!in_array($_SESSION['uid'],array_keys($level_user))) {
                    MSG(L('no content private'));
                }
                $status=9;
            } elseif($level>1) {
                $r = $this->db->get_one($master_table,array('id'=>$id));
                $level_user = p_unserialize($workflows['level'.$r['status'].'_user']);
                if(!in_array($_SESSION['uid'],array_keys($level_user))) {
                    MSG(L('no content private'));
                }

                if($level==$r['status']) {
                    $status=9;
                } elseif($level>$r['status']) {
                    $status=$r['status']+1;
                } else {//其他草稿，退稿等状态
                    $status=1;
                }
            }
        } elseif($GLOBALS['pass']==='1') {
            $status=9;
        }
        $this->db->update($master_table,array('status'=>$status),array('id'=>$id));
        //更新推荐位状态
        $keyid = $id.'-'.$cid;
        $this->db->update('block_data', array('status'=>$status), array('keyid' => $keyid));
        //TODO 跳转到下一篇审批内容
        MSG(L('check success').','.L('auto close')."<script>setTimeout('window.close();',2000)</script>",'',3000);
    }

    private function _status($status) {
        $status_array = $this->status_array;
        $string = '';
        foreach($status_array as $k=>$s) {
            if($k==$status) {
                $string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="icon-check btn-icon"></i>'.$s.'<span class="caret"></span></a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach($status_array as $k=>$s) {
            if($k!=$status) {
                $url = URL().'&status='.$k;
                $url = url_unique($url);
                $string .= '<li><a href="?'.$url.'">'.$s.'</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }
    private function _status2($status) {
        $status_array = $this->status_array2;
        $string = '';
        foreach($status_array as $k=>$s) {
            if($k==$status) {
                $string .= '<a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="icon-check btn-icon"></i>'.$s.'<span class="caret"></span></a>';
            }
        }
        $string .= '<ul class="dropdown-menu">';
        foreach($status_array as $k=>$s) {
            if($k!=$status) {
                $url = URL().'&status='.$k;
                $url = url_unique($url);
                $string .= '<li><a href="?'.$url.'">'.$s.'</a></li>';
            }
        }
        $string .= '</ul>';
        return $string;
    }
    /**
     * 显示共享模型的添加链接
     * 默认最多30个共享模型
     */
    private function _show_share_add($cid) {
        //文章 icon-file-word-o 图文 icon-file-photo-o 下载 icon-file-zip-o 视频 icon-file-movie-o
        $result = $this->db->get_list('model', array('m'=>'content','share_model'=>1), 'modelid,name,css', 0, 30,0,'modelid ASC');
        $string = '';
        foreach($result as $rs) {
            $string .= '<li><a href="?m=content&f=content&v=add&modelid='.$rs['modelid'].'&cid='.$cid.$this->su().'"><i class="'.$rs['css'].' btn-sm"></i>'.$rs['name'].'</a></li>';
        }
        return $string;
    }

    /**
     * 高级搜索
     */
    public function search() {
        $result = array();
        $stype = isset($GLOBALS['stype']) ? intval($GLOBALS['stype']) : 1;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $keywords = isset($GLOBALS['keywords']) ? sql_replace($GLOBALS['keywords']) : '';
        $start = isset($GLOBALS['start']) ? $GLOBALS['start'] : '';
        $end = isset($GLOBALS['end']) ? $GLOBALS['end'] : '';
        if(isset($GLOBALS['submit'])) {
            if($cid) {
                $cate_config = get_cache('category_'.$cid,'content');
                if(!$cate_config) MSG(L('category not exists'));
                $modelid = $cate_config['modelid'];
                $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
                $master_table = $model_r['master_table'];
                $where = "`cid`='$cid' AND `status`='$status'";
                switch($stype) {
                    case 1:
                        if($keywords) $where .= " AND `title` LIKE '%$keywords%'";
                        break;
                    case 2:
                        if($keywords) $where .= " AND `remark` LIKE '%$keywords%'";
                        break;
                    case 3:
                        if($keywords) $where .= " AND `publisher`='$keywords'";
                        break;
                }
                if($start) {
                    $where .= " AND `addtime`>'".strtotime($start)."'";
                }
                if($end) {
                    $where .= " AND `addtime`<'".strtotime($end)."'";
                }
                //单网页
                if($cate_config['type']==1) {
                    $r = $this->db->get_one($master_table,array('cid'=>$cid));
                    if(!$r) {
                        header("Location: index.php?m=content&f=content&v=add&modelid=".$cate_config['modelid']."&cid=".$cid.$this->su());
                    } else {
                        header("Location: index.php?m=content&f=content&v=edit&modelid=".$cate_config['modelid']."&cid=".$cid.'&id='.$r['id'].$this->su());
                    }
                }
            } else {
                $modelid = 0;
                $master_table = 'content_share';
                $where = "`status`='$status'";
                switch($stype) {
                    case 1:
                        if($keywords) $where .= " AND `title` LIKE '%$keywords%'";
                        break;
                    case 2:
                        if($keywords) $where .= " AND `remark` LIKE '%$keywords%'";
                        break;
                    case 3:
                        if($keywords) $where .= " AND `publisher`='$keywords'";
                        break;
                }
                if($start) {
                    $where .= " AND `addtime`>'".strtotime($start)."'";
                }
                if($end) {
                    $where .= " AND `addtime`<'".strtotime($end)."'";
                }
            }
            $page = intval($GLOBALS['page']);
            $page = max($page,1);

            $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'sort DESC');
            $pages = $this->db->pages;
        }

        $form = load_class('form');
        $categorys = get_cache('category','content');

        $options = array(1=>'标题',2=>'描述',3=>'发布人');
        include $this->template('content_search');
    }

    /**
     * 排序
     */
    public function sort() {
        $cid = intval($GLOBALS['cid']);
        if(isset($GLOBALS['submit'])) {
            if($cid) {
                $category_r = $this->db->get_one('category',array('cid'=>$cid));
                $model_r = $this->db->get_one('model',array('modelid'=>$category_r['modelid']));
                $master_table = $model_r['master_table'];
            } else {
                $master_table = 'content_share';
            }
            foreach($GLOBALS['sorts'] as $id => $n) {
                $n = intval($n);
                $r = $this->db->get_one($master_table,array('id'=>$id));
                if($r['sort']!=$n) {
                    $this->db->update($master_table,array('sort'=>$n),array('id'=>$id));
                    $this->editor_logs('sort',$r['title'],$r['url'], "?m=content&f=content&v=edit&id=$id&cid=$cid");
                }
            }
            MSG(L('operation success'),HTTP_REFERER,1000);
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 检测标题重复性
     */
    public function checktitle() {
        $title = isset($GLOBALS['title']) ? remove_xss($GLOBALS['title']) : exit('-1');
        if(strtolower(CHARSET)=='gbk') $title = iconv('utf-8','gbk',$title);
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : exit('-2');
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) exit('-2');
        $models = get_cache('model_content','model');
        $model_r = $models[$cate_config['modelid']];
        $master_table = $model_r['master_table'];
        $id = intval($GLOBALS['id']);
        $where = '';
        if($id) $where = " AND `id`!='$id'";
        $r = $this->db->get_one($master_table,"`title`='$title' $where");
        if($r) {
            exit('1');
        }
        $r = $this->db->get_one($master_table,"`title` LIKE '%$title%' $where");
        if($r) {
            exit('2');
        }
        exit('ok');
    }

    /**
     * 批量移动文章
     */
    public function move() {
        if(is_array($GLOBALS['ids'])) {
            $cid = intval($GLOBALS['cid']);
            $form = load_class('form');
            $cache_categorys = get_cache('category','content');
            $categorys = array();
            $models = get_cache('model_content','model');
            if($cid == 0) {
                $modelname = '共享模型';
                foreach($cache_categorys as $cid=>$cate) {
                    if($models[$cate['modelid']]['master_table']!='content_share') continue;
                    if($cate['type']==0) {
                        $cate['cid'] = $cid;
                        $categorys[$cid] = $cate;
                    }
                }
            } else {
                $modelid = $cache_categorys[$cid]['modelid'];
                $model = $models[$modelid];
                $modelname = $model['name'];
                foreach($cache_categorys as $cid=>$cate) {
                    if($cate['modelid']!=$modelid) continue;
                    if($cate['type']==0) {
                        $cate['cid'] = $cid;
                        $categorys[$cid] = $cate;
                    }
                }
            }
            $ids = empty($GLOBALS['ids']) ? '' : implode(',',$GLOBALS['ids']);
            include $this->template('content_move');
        } else {
            if(empty($GLOBALS['ids'])) MSG('没有选择要移动的文章');
            $ids = explode(',',$GLOBALS['ids']);
            $cid = intval($GLOBALS['cid']);
            if(!$cid) MSG('请选择目标栏目');
            $models = get_cache('model_content','model');
            $category = get_cache('category_'.$cid,'content');
            $model = $models[$category['modelid']];
            $urlclass = load_class('url','content',$category);
            foreach($ids as $id) {
                //生成url
                $r = $this->db->get_one($model['master_table'],array('id'=>$id));
                $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$r['addtime'],'page'=>1,'route'=>$r['route']));
                $this->db->update($model['master_table'],array('cid'=>$cid,'url'=>$urls['url']),array('id'=>$id));
                if($category['showhtml'] && $r['status']==9) {
                    if(!empty($model['attr_table'])) {
                        $attrdata = $this->db->get_one($model['attr_table'],array('id'=>$id));
                        $r = array_merge($r,$attrdata);
                    }
                    //上一页
                    $data['previous_page'] = $this->db->get_one($model['master_table'],"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                    //下一页
                    $data['next_page'] = $this->db->get_one($model['master_table'],"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                    $this->html = load_class('html','content');
                    $this->html->set_category($category);
                    $this->html->set_categorys();
                    $this->html->load_formatcache();
                    $this->html->show($r,1,1,$urls['root']);
                }
            }
            MSG('批量移动成功',$GLOBALS['forward']);
        }

    }

    /**
     * 检查内容管理权限
     */
    private function private_check() {
        $role = $_SESSION['role'];
        if($role==='1') return true;
        $actionids = array(1=>'listing',2=>'add',3=>'edit',4=>'delete',5=>'sort');
        if(in_array(V,$actionids)) {
            $cid = intval($GLOBALS['cid']);
            if($cid==0) return true;
            $actionids = array_flip($actionids);
            $actionid = $actionids[V];
            if(!$this->db->get_one('category_private',array('role'=>$role,'cid'=>$cid,'actionid'=>$actionid))) {
                //查看副栏目是否给予权限，如果有，则继承权限
                $category = get_cache('category_'.$cid,'content');
                if($category['pid']) {
                    if($this->db->get_one('category_private',array('role'=>$role,'cid'=>$category['pid'],'actionid'=>$actionid))) {
                        return true;
                    }
                }
                MSG(L('no content private'));
            }
        }
    }

    /**
     * 推送内容
     */
    public function push() {
        $siteid = get_cookie('siteid');
        if(is_array($GLOBALS['ids'])) {
            $cid = intval($GLOBALS['cid']);
            $form = load_class('form');
            $cache_categorys = get_cache('category','content');
            $categorys = array();
            $models = get_cache('model_content','model');
            if($cid == 0) {
                $modelname = '共享模型';
                foreach($cache_categorys as $cid=>$cate) {
                    if($models[$cate['modelid']]['master_table']!='content_share' || $cate['siteid']!=$siteid) continue;
                    if($cate['type']==0) {
                        $cate['cid'] = $cid;
                        $categorys[$cid] = $cate;
                    }
                }
            } else {
                $modelid = $cache_categorys[$cid]['modelid'];
                $model = $models[$modelid];
                $modelname = $model['name'];
                foreach($cache_categorys as $cid=>$cate) {
                    if($model['master_table']=='content_share') {
                        if($models[$cate['modelid']]['master_table']=='content_share' && $cate['type']==0 && $cate['siteid']==$siteid) {
                            $cate['cid'] = $cid;
                            $categorys[$cid] = $cate;
                        }
                    }// && $cate['modelid']!=$modelid) || $cate['siteid']!=$siteid

                }
            }
            $ids = empty($GLOBALS['ids']) ? '' : implode(',',$GLOBALS['ids']);
            include $this->template('content_push');
        } else {
            if(empty($GLOBALS['ids'])) MSG('没有选择任何文章');
            $ids = explode(',',$GLOBALS['ids']);
            $cid = intval($GLOBALS['cid']);
            if(!$cid) MSG('请选择目标栏目');
            $models = get_cache('model_content','model');
            $category = get_cache('category_'.$cid,'content');
            $model = $models[$category['modelid']];
            $urlclass = load_class('url','content',$category);
            $master_table = $model['master_table'];
            $attr_table = $model['attr_table'];
            foreach($ids as $id) {
               //根据标题查询是否推送过，如果推送过，就覆盖原有内容
				
                $r = $this->db->get_one($master_table,array('id'=>$id));
                if($master_table=='content_share') {
                    $modelid = $r['modelid'];
                    $attr_table = $models[$modelid]['attr_table'];
                }
				$cc = $this->db->get_one($master_table, "`cid`='$cid' AND `title`='".$r['title']."'");
				$r['cid'] = $cid;
				unset($r['id']);
				if($cc) {
					$r['id'] = $newid = $cc['id'];
					$this->db->update($master_table, $r,array('id'=>$newid));
					if($attr_table) {
						$r2 = $this->db->get_one($attr_table,array('id'=>$id));
						$r2['id'] = $newid;
						$this->db->update($attr_table, $r2,array('id'=>$newid));
						$r = array_merge($r,$r2);
					}
				} else {
					$newid = $this->db->insert($master_table, $r);


					if($attr_table) {
						$r2 = $this->db->get_one($attr_table,array('id'=>$id));
						$r2['id'] = $newid;
						$this->db->insert($attr_table, $r2);
						$r = array_merge($r,$r2);
					}
					//判断是否存在，防止意外发生
					if(!$this->db->get_one('content_rank',array('cid'=>$cid,'id'=>$newid))) {
						//统计表加默认数据
						$this->db->insert('content_rank',array('cid'=>$cid,'id'=>$newid,'updatetime'=>SYS_TIME));
					}
				}

                $urls = $urlclass->showurl(array('id'=>$newid,'cid'=>$cid,'addtime'=>$r['addtime'],'page'=>1,'route'=>$r['route']));
                $this->db->update($master_table,array('url'=>$urls['url']),array('id'=>$newid));
                if($category['showhtml'] && $r['status']==9) {
                    //上一页
                    $data['previous_page'] = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                    //下一页
                    $data['next_page'] = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                    $this->html = load_class('html','content');
                    $this->html->set_category($category);
                    $this->html->set_categorys();
                    $this->html->load_formatcache();
                    $this->html->show($r,1,1,$urls['root']);
                }
            }
            MSG('推送成功',$GLOBALS['forward']);
        }

    }
}