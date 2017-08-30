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
    private $siteid;
    private $siteurl;
    private $sitelist;
    function __construct() {
        $this->db = load_class('db');
        $this->private_check();
        $this->siteid = get_cookie('siteid');
        if(!$this->siteid) {
            $this->siteid = 1;
            set_cookie('siteid',1);
        }
        $this->sitelist = get_cache('sitelist');
        $this->siteurl = isset($this->sitelist[$this->siteid]['url']) ? $this->sitelist[$this->siteid]['url'] : '';
    }
    public function manage() {
        $modelid = isset($GLOBALS['modelid']) ? intval($GLOBALS['modelid']) : 0;
		$type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : 0;
        include $this->template('content_manage');
    }
    public function left() {
        $siteid = $this->siteid;
        $where = "`keyid`='content' AND `siteid`='$siteid' AND `type`<2";

        if(isset($GLOBALS['modelid']) && $GLOBALS['modelid']!=0) {
            $where['modelid'] = intval($GLOBALS['modelid']);
        }
        $role = trim($_SESSION['role'],',');
        $where2 = "`role` IN ($role) AND `actionid`=1";
        $private_result = $this->db->get_list('category_private', $where2, '*', 0, 2000, 0, '', '', 'cid');
        if($private_result) $private_result = array_keys($private_result);
        $result_tmp = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
		$cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;

        if(empty($result_tmp)) {
            $category_tree = '';
        } else {
            $result = array();
            if(strpos($_SESSION['role'],',1,')!==false) {
                $result = $result_tmp;
            } elseif($private_result) {
                foreach($result_tmp as $cid=>$rs) {
                    if(in_array($cid,$private_result)) {
                        $result[$cid] = $rs;
                    }
                }
            }

            $tree = load_class('tree','core',$result);
            $category_tree = $tree->get_treeview(0,'tree', "<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a></li>","<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a>");
        }
        include $this->template('content_left');
    }
    public function listing() {
        //默认显示共享模型数据，即modelid为0.
        //默认status为9 通过审核
        $siteid = get_cookie('siteid');
        $this->siteurl = substr($this->siteurl,0,-1);

        $type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : 0;
        $title = isset($GLOBALS['title']) ? sql_replace($GLOBALS['title']) : '';
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        if($cid) {
            $cate_config = get_cache('category_'.$cid,'content');
            if(!$cate_config) MSG(L('category not exists'));
            $modelid = $cate_config['modelid'];
            if($cate_config['siteid'] !=$this->siteid) MSG('请重新选择栏目');
            $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
            $_master_table = $master_table = $model_r['master_table'];

            $where = "`cid`='$cid' AND `status`='$status'";

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
            $_master_table = $master_table = 'content_share';

            $where = "`status`='$status'";
            $categorys = get_cache('category','content');
            if($title) $where .= " AND `title` LIKE '%$title%'";
			$cids = array();
            if(is_array($categorys)){
                foreach($categorys as $_cid=>$_res) {
                    if($_res['siteid']==$siteid) $cids[] = $_cid;
                }
            }
			if(!empty($cids)) {
				$cids = implode(',',$cids);
				$where .= " AND `cid` IN($cids)";
			}

        }
        $page = intval($GLOBALS['page']);
        $page = max($page,1);
        $models = get_cache('model_content','model');
        $result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'addtime DESC');
        //$result = array();
        $pages = $this->db->pages;
        if($modelid) {
            $manage_template = $models[$modelid]['manage_template'];
            if(!$manage_template) $manage_template = 'content_listing';
            include $this->template($manage_template);
        } else {
            include $this->template('content_listing');
        }
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
        $content_share_table='content_share';
        foreach($models as $key=>$model) {
            $master_table = $model['master_table'];
            $tmp = $this->db->get_list($master_table,$where, '*', 0, 20,0,'id DESC');
			if($tmp) $result[$key] = $tmp;
        }
        //print_r($result);
        include $this->template('content_allcheck');
    }
    public function add() {
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : 0;
        $cate_config = get_cache('category_'.$cid,'content');
        if(!$cate_config) MSG(L('category not exists'));
        //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
        if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
            $modelid = $GLOBALS['modelid'];
        } else {
            $modelid = $cate_config['modelid'];
        }
        if($cate_config['type']==1) {//单网页,查下是否已经存在该内容
            $models = get_cache('model_content','model');
            $master_table = $models[$modelid]['master_table'];

            $data = $this->db->get_one($master_table, array('cid' => $cid),'id');
            if($data) {
                header("Location: ?m=content&f=content&v=edit&cid=".$cid.'&_lang='.$_lang.'&id='.$data['id'].$this->su());
            }
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
            if($cate_config['type']==1) {
                $urls['url'] = $cate_config['url'];
            } elseif($formdata['master_data']['route']>1) {//外部链接
                $urls['url'] = remove_xss($GLOBALS['url']);
            } else {
                //生成url
				$urlclass = load_class('url','content',$cate_config);
				$categorys = get_cache('category','content');
				$urlclass->set_category($cate_config);
				$urlclass->set_categorys($categorys);

				$route_config = array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1);
				$route_config = array_merge($route_config,$formdata['master_data']);
				$urls = $urlclass->showurl($route_config);
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

			//自动推送至搜索引擎
			$baidu_urls = array($urls['url']);
			baidu_linkpost($baidu_urls,$this->siteid,'urls');

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
                //生成上级栏目
                if($cate_config['pid']) {
                    $cate_config2 = get_cache('category_'.$cate_config['pid'],'content');
                    $urlclass->set_category($cate_config2);
                    $cateurls = $urlclass->listurl(array('cid'=>$cate_config['pid'],'page'=>1));
                    $this->html->set_category($cate_config2);
                    $this->html->listing($cateurls['root'],1);
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
		$categorys = get_cache('category','content');

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

            $urlclass = load_class('url','content',$cate_config);
            if($cate_config['type']==1) {
                $urls['url'] = $cate_config['url'];
            } elseif($formdata['master_data']['route']>1) {//外部链接/或者自定义链接
                $urls['url'] = remove_xss($GLOBALS['url']);
            } else {
                //生成url

                $productid = 0;

				$urlclass->set_category($cate_config);
				$urlclass->set_categorys($categorys);

                if(isset($formdata['master_data']['productid'])) $productid = $formdata['master_data']['productid'];
				$route_config = array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1);
				$route_config = array_merge($route_config,$formdata['master_data']);
				$urls = $urlclass->showurl($route_config);
            }
            $formdata['master_data']['url'] = $urls['url'];

            if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
                $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
            }

            $this->db->update($formdata['master_table'],$formdata['master_data'],array('id'=>$id));
            if(!empty($formdata['attr_table']) && $formdata['attr_data']) {
                $_attr_table = $attr_table = $formdata['attr_table'];

                //查询从表是否存在数据,不存在则修复数据.
                $attr_data = $this->db->get_one($attr_table, array('id' => $id),'id');
                if($attr_data) {
                    $this->db->update($attr_table,$formdata['attr_data'],array('id'=>$id));
                } else {
                    $formdata['attr_data']['id'] = $id;
                    $this->db->insert($attr_table,$formdata['attr_data']);
                }

            }

            //执行更新
            require get_cache_path('content_update','model');
            $form_update = new form_update($modelid);

            $formdata['master_data']['id'] = $id;
            $form_update->execute($formdata);

			//自动推送至搜索引擎
			$baidu_urls = array($urls['url']);
			baidu_linkpost($baidu_urls,$this->siteid,'update');

            //同步修改
            if($GLOBALS['tb_update']) {
                foreach($GLOBALS['tb_update'] as $tb_id=>$tb_cid) {
                    $formdata['master_data']['id'] = $tb_id;
                    $formdata['master_data']['cid'] = $tb_cid;
                    if(strpos($formdata['master_data']['url'],'://')===false) {
                        unset($formdata['master_data']['url']);
                    }

                    //同步更新如果是外链地址,才更新url,默认保持不更新url
                    $this->db->update($formdata['master_table'],$formdata['master_data'],array('id'=>$tb_id));
                    if(!empty($formdata['attr_table'])) {
                        $this->db->update($attr_table,$formdata['attr_data'],array('id'=>$tb_id));
                    }
                }
            }

            //end同步修改

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
                $this->html->set_categorys($categorys);
                $this->html->load_formatcache();


                $this->html->show($data,1,1,$urls['root']);
                $loadhtml = true;
                if($GLOBALS['old_status']!=9) {
                    $message_api = load_class('message_api', 'message');
                    $message_api->send_sys($data['publisher'], '信息通过审核', $data['title'] . ' <a href="' . $data['url'] . '" target="_blank">点击查看</a>');
                }
            } else {
                $loadhtml = false;
                //发送通知短息
                if($GLOBALS['old_status']!=9) {
                    $data = $this->db->get_one($formdata['master_table'],array('id'=>$id));
                    $message_api = load_class('message_api','message');
                    $message_api->send_sys($data['publisher'],'信息通过审核' ,$data['title'].' <a href="'.$data['url'].'" target="_blank">点击查看</a>');
                }
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
                //生成上级栏目
                if($cate_config['pid']) {
                    $cate_config2 = get_cache('category_'.$cate_config['pid'],'content');
                    $urlclass->set_category($cate_config2);
                    $cateurls = $urlclass->listurl(array('cid'=>$cate_config['pid'],'page'=>1));
                    $this->html->set_category($cate_config2);
                    $this->html->listing($cateurls['root'],1);
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
                if($attrdata) $data = array_merge($data,$attrdata);
            }

            load_function('template');
            load_function('content','content');
            $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : 9;
            require get_cache_path('content_form','model');
            $form_build = new form_build($modelid);
            $form_build->cid = $cid;
            $categorys = get_cache('category','content');
            $form_build->extdata['catname'] = $cate_config['name'];
            $form_build->extdata['type'] = $cate_config['type'];
            $formdata = $form_build->execute($data);
            load_class('form');
            $show_formjs = 1;
            $show_dialog = 1;
            //同步更新显示
            $tb_arr = '';
            $tb_rs = $this->db->get_one('content_ids', array('new_cid' => $cid,'new_id'=>$id));

            if($tb_rs) {
                //[ciid] => 1 [siteid] => 1 [id] => 4481 [cid] => 62 [new_id] => 4670 [new_siteid] => 2 [new_cid] => 469
                $tb_arr[] = array('ciid'=>$tb_rs['ciid'],'siteid'=>$tb_rs['new_siteid'],'id'=>$tb_rs['new_id'],'cid'=>$tb_rs['new_cid'],'new_siteid'=>$tb_rs['siteid'],'new_id'=>$tb_rs['id'],'new_cid'=>$tb_rs['cid']);
                $tb_result = $this->db->get_list('content_ids', array('cid' => $tb_rs['cid'],'id'=>$tb_rs['id']), '*', 0, 10, 0, 'siteid ASC');
                foreach($tb_result as $tb_r) {
                    if($tb_rs['ciid']==$tb_r['ciid']) continue;
                    $tb_arr[] = $tb_r;
                }
                foreach($tb_arr as $key=>$tmp) {
                    $tb_arr[$key]['names'] = $this->sitelist[$tmp['new_siteid']]['name'].' > ';
                }
            } else {
                $tb_result = $this->db->get_list('content_ids', array('cid' => $cid,'id'=>$id), '*', 0, 10, 0, 'siteid ASC');
                if(!empty($tb_result)) {
                    foreach($tb_result as $tb_r) {
                        $tb_r['names'] = $this->sitelist[$tb_r['new_siteid']]['name'].' > ';
                        $tb_arr[] = $tb_r;
                    }
                }
            }

            include $this->template('content_edit');
        }
    }

    /**
     * 内容预览
     */
    public function view() {
        load_function('content','content');
        $siteconfigs = $this->siteconfigs;
        $id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : MSG(L('parameter_error'));
        $cid = isset($GLOBALS['cid']) ? intval($GLOBALS['cid']) : MSG(L('parameter_error'));
        if($cid==0) MSG(L('parameter_error'));
        $categorys = get_cache('category','content');
        //查询数据
        $category = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        if(!$category) MSG(L('parameter_error'));
        $model_r = $models[$category['modelid']];
        if(!$model_r) MSG(L('parameter_error'));
        $master_table = $model_r['master_table'];

        $data = $this->db->get_one($master_table,array('id'=>$id));
        if(!$data) MSG('信息不存在!');
		if($data['modelid']) {
			$model_r = $models[$data['modelid']];
		}

        //城市分站信息
        $city = get_cookie('city');
        $city = isset($GLOBALS['city']) && !empty($GLOBALS['city']) ? $GLOBALS['city'] : $city ? $city : 'xa';
        $city_config = get_config('city_config');
        $cityid = $city_config[$city]['cityid'];
        $cityname = $city_config[$city]['cityname'];

        if($model_r['attr_table']) {
            $attr_table = $model_r['attr_table'];
            if($data['modelid']) {
                $modelid = $data['modelid'];
                $attr_table = $models[$modelid]['attr_table'];
            } else {
                $modelid = $model_r['modelid'];
            }
            $attrdata = $this->db->get_one($attr_table,array('id'=>$id));
            $data = array_merge($data,$attrdata);
        } else {
            $modelid = $model_r['modelid'];
        }
        $data_r = $data;
        $urlrule = $category['showurl'];
        if($category['showhtml']) {
            $urlrules = explode('|',$urlrule);
            $urlrule = WWW_PATH.$urlrules[0].'|'.WWW_PATH.$urlrules[1];
        }
        require get_cache_path('content_format','model');
        $form_format = new form_format($modelid);
        $data = $form_format->execute($data);

        foreach($data as $_key=>$_value) {
            $$_key = $_value['data'];
        }
        if($template) {
            $_template = $template;
		} elseif($model_r['template'] && $category['modelid']!=$modelid) {
			$_template = $model_r['template'];
        } elseif($category['show_template']) {
            $_template = $category['show_template'];
        } elseif($model_r['template']) {
            $_template = TPLID.':'.$model_r['template'];
        } else {
            $_template = TPLID.':show';
        }
        $styles = explode(':',$_template);
        $project_css = isset($styles[0]) ? $styles[0] : 'default';
        $_template = isset($styles[1]) ? $styles[1] : 'show';
        $original_addtime = $data_r['addtime'];

        $elasticid = elasticid($cid);
        $seo_title = $title.'_'.$category['name'].'_'.$siteconfigs['sitename'];
        $seo_keywords = !empty($keywords) ? implode(',',$keywords) : '';
        $seo_description = $remark;
        //上一页
        $previous_page = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
        //下一页
        $next_page = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
        //手动分页
        $CONTENT_POS = strpos($content, '_wuzhicms_page_tag_');
        if(!empty($content) && $CONTENT_POS !== false) {
            $page = max($GLOBALS['page'],1);
            $contents = array_filter(explode('_wuzhicms_page_tag_', $content));
            $pagetotal = count($contents);
            $content = $contents[$page-1];
            $tmp_year = date('Y',$original_addtime);
            $tmp_month = date('m',$original_addtime);
            $tmp_day = date('d',$original_addtime);
            $content_pages = pages($pagetotal,$page,1,$category['showurl'],array('year'=>$tmp_year,'month'=>$tmp_month,'day'=>$tmp_day,'catdir'=>$category['catdir'],'cid'=>$cid,'id'=>$id));
        } else {
            $content_pages = '';
        }
		$access_authority = true;
        if($model_r['view_template']) {
            $check_tpl = $this->template($model_r['view_template']);
            $fields = $form_format->fields;
            include $check_tpl;
        } else {
            include T('content',$_template,$project_css);
        }
        include $this->template('check_foot');
    }
    /**
     * 内容删除到回收站
     */
    public function recycle_delete() {
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
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

        $keyid = $id.'-'.$cid.'-'.$_lang;
        $this->db->update('block_data', array('status'=>0), array('keyid' => $keyid));
        //删除统计
        //$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
        //删除推送关联
        $this->db->delete('content_ids',array('new_id'=>$id,'new_cid'=>$cid));

        //删除已生成的文件
        if($cate_config['showhtml']) {
            $r = $this->db->get_one($master_table, array('id' => $id));
            $urlclass = load_class('url', 'content', $cate_config);
			$categorys = get_cache('category','content');
			$urlclass->set_categorys($categorys);
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
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        if(!$cid) MSG(L('parameter_error'));
        $category_r = get_cache('category_'.$cid,'content');
        $models = get_cache('model_content','model');
        $model_r = $models[$category_r['modelid']];
        $master_table = $model_r['master_table'];
        $data = $this->db->delete($master_table,array('id'=>$id));
        $attr_table = $model_r['attr_table'];

        if($model_r['attr_table']) {
            $attrdata = $this->db->delete($attr_table,array('id'=>$id));
        }
        //$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
        $keyid = $id.'-'.$cid.'-'.$_lang;
        $this->db->delete('block_data', array('keyid' => $keyid));
        MSG(L('delete success'),HTTP_REFERER,1000);
    }

    /**
     * 内容批量删除
     */
    public function delete_more() {
        if(empty($GLOBALS['ids'])) MSG('没有选择任何文章');
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        $cid = intval($GLOBALS['cid']);
		$models = get_cache('model_content','model');

        if($cid) {
			$category_r = get_cache('category_'.$cid,'content');
			$model_r = $models[$category_r['modelid']];
			$master_table = $model_r['master_table'];
			$status = intval($GLOBALS['status']);
			$attr_table = $model_r['attr_table'];
			foreach($GLOBALS['ids'] as $id) {
				if($status==0) {
					$data = $this->db->delete($master_table,array('id'=>$id));
					if($model_r['attr_table']) {

						$attrdata = $this->db->delete($attr_table,array('id'=>$id));
					}
					//$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
					$keyid = $id.'-'.$cid.'-'.$_lang;
					$this->db->delete('block_data', array('keyid' => $keyid));
				} else {
					$data = $this->db->update($master_table,array('status'=>0),array('id'=>$id));
					//$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
					$keyid = $id.'-'.$cid.'-'.$_lang;
					$this->db->update('block_data', array('status'=>0), array('keyid' => $keyid));
				}
			}
		} else {
        	foreach($GLOBALS['ids'] as $modelid=>$ids) {
				$model_r = $models[$modelid];
				$master_table = $model_r['master_table'];
				$status = intval($GLOBALS['status']);
				$attr_table = $model_r['attr_table'];
				foreach($ids as $id) {
					if($status==0) {
						$data = $this->db->delete($master_table,array('id'=>$id));
						if($model_r['attr_table']) {

							$attrdata = $this->db->delete($attr_table,array('id'=>$id));
						}
						//$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
						$keyid = $id.'-'.$cid.'-'.$_lang;
						$this->db->delete('block_data', array('keyid' => $keyid));
					} else {
						$data = $this->db->update($master_table,array('status'=>0),array('id'=>$id));
						//$this->db->delete('content_rank',array('cid'=>$cid,'id'=>$id));
						$keyid = $id.'-'.$cid.'-'.$_lang;
						$this->db->update('block_data', array('status'=>0), array('keyid' => $keyid));
					}
				}
			}




		}
        MSG(L('delete success'),HTTP_REFERER,1);
    }
    /**
     * 内容审核
     */
    public function check() {
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        if(!$cid) MSG(L('parameter_error'));
        $category_r = get_cache('category_'.$cid,'content');
        $workflowid = $category_r['workflowid'];
        $models = get_cache('model_content','model');
        $model_r = $models[$category_r['modelid']];
        $master_table = $model_r['master_table'];
        $r = $this->db->get_one($master_table,array('id'=>$id));
        if($GLOBALS['pass']==='0') {
            $status = 7;
        } elseif($workflowid) {
            //检查权限
            $role = $_SESSION['role'];
            $workflows = $this->db->get_one('workflow', array('workflowid'=>$workflowid));

            $level = $workflows['level'];

            if($level==1) {
                $level_user = p_unserialize($workflows['level1_user']);
                if(empty($level_user ))MSG('工作流程审核中没有该管理员，如需审核到后台超级管理员设置工作流程权限！');
                if(!in_array($_SESSION['uid'],array_keys($level_user))) {
                    MSG(L('no content private'));
                }
                $status=9;
            } elseif($level>1) {
                $level_user = p_unserialize($workflows['level'.$r['status'].'_user']);
                if(empty($level_user ))MSG('工作流程审核中没有该管理员，如需审核到后台超级管理员设置工作流程权限！');
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
        if($status==9 && $r['status']!=9) {//通过审核
            $message_api = load_class('message_api','message');
            $message_api->send_sys($r['publisher'],'信息通过审核' ,$r['title'].' <a href="'.$r['url'].'" target="_blank">点击查看</a>');
            $loadhtml=false;
            $urlclass = load_class('url','content',$category_r);
            $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$r['addtime'],'page'=>1,'route'=>$r['route']));
            if($category_r['showhtml']) {
                if($model_r['attr_table']) {
                    $attrdata = $this->db->get_one($model_r['attr_table'],array('id'=>$id));
                    $r = array_merge($r,$attrdata);
                }

                $this->html = load_class('html','content');
                $this->html->set_category($category_r);
                $this->html->set_categorys();
                $this->html->load_formatcache();
                $this->html->show($r,1,1,$urls['root']);
                $loadhtml = true;
            }

            //生成相关栏目列表
            if($category_r['listhtml']) {
                if($loadhtml==false) {
                    $this->html = load_class('html','content');
                    $this->html->set_category($category_r);
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
                //生成上级栏目
                if($category_r['pid']) {
                    $cate_config2 = get_cache('category_'.$category_r['pid'],'content');
                    $urlclass->set_category($cate_config2);
                    $cateurls = $urlclass->listurl(array('cid'=>$category_r['pid'],'page'=>1));
                    $this->html->set_category($cate_config2);
                    $this->html->listing($cateurls['root'],1);
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
        } elseif($status==7) {//退稿
            $message_api = load_class('message_api','message');
            $message_api->send_sys($r['publisher'],'很遗憾,您的信息未通过审核' ,$r['title'].' <a href="index.php?m=content&f=postinfo&v=edit&cid='.$r['cid'].'&id='.$id.'" target="_blank">点击修改</a>');
        }
        $this->db->update($master_table,array('status'=>$status),array('id'=>$id));
        //更新推荐位状态
        $keyid = $id.'-'.$cid.'-'.$_lang;
        $this->db->update('block_data', array('status'=>$status), array('keyid' => $keyid));
        //TODO 跳转到下一篇审批内容
        $hook = load_class('hook');
        $hook->run_hook('content_pass',$r,array('modelid'=>$category_r['modelid'],'status'=>$status));

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
                    if($cate['siteid']!=$siteid || $cate['modelid']!=$modelid) continue;
                    if($cate['type']<2) {
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
        if(strpos($_SESSION['role'],',1,')!==false) return true;

        $actionids = array(1=>'listing',2=>'add',3=>'edit',4=>'delete',5=>'sort');
        if(in_array(V,$actionids)) {
            $cid = intval($GLOBALS['cid']);
            if($cid==0) return true;
            $actionids = array_flip($actionids);
            $actionid = $actionids[V];
            $role = trim($_SESSION['role'],',');
            $where = "`role` IN ($role) AND `cid`='$cid' AND `actionid`='$actionid'";
            if(!$this->db->get_one('category_private',$where)) {
                //查看副栏目是否给予权限，如果有，则继承权限
                $category = get_cache('category_'.$cid,'content');
                if($category && $category['pid']) {
                    $pid = $category['pid'];
                    $where = "`role` IN ($role) AND `cid`='$pid' AND `actionid`='$actionid'";
                    if($this->db->get_one('category_private',$where)) {
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
            $categorys = get_cache('category','content');
            //推送中文同时要推送英文,新插入时产生新的主键id,中英文需要相同
            foreach($ids as $id) {
                $r = $this->db->get_one($master_table,array('id'=>$id));
                $this->db->update($master_table,array('push'=>1),array('id'=>$id));
                //$r_en = $this->db->get_one($master_table.'_en',array('id'=>$id));
                //$this->db->update($master_table.'_en',array('push'=>1),array('id'=>$id));
                if($master_table=='content_share') {
                    $modelid = $r['modelid'];
                    $attr_table = $models[$modelid]['attr_table'];
                }
                $formdata = array();
                $formdata['siteid'] = $categorys[$r['cid']]['siteid'];
                $formdata['id'] = $r['id'];
                $formdata['cid'] = $r['cid'];
                //推送中文内容
                //根据是否推送过，如果推送过，就覆盖原有内容
				$cc = $this->db->get_one($master_table, "`old_id`='$id' AND `cid`='$cid'");
				$r['cid'] = $cid;
				$r_en['cid'] = $cid;
                $r['old_id'] = $id;
                $r_en['old_id'] = $id;
				unset($r['id'],$r_en['id']);
                //print_r($r);exit;
				if($cc) {
					$r['id'] = $r_en['id'] = $newid = $cc['id'];
					$this->db->update($master_table, $r,array('id'=>$newid));
					//$this->db->update($master_table.'_en', $r_en,array('id'=>$newid));
                    $datas = $r;
                    $datas_en = $r_en;
					if($attr_table) {
						$r2 = $this->db->get_one($attr_table,array('id'=>$id));
						//$r2_en = $this->db->get_one($attr_table.'_en',array('id'=>$id));
                        $r2_en['id'] = $r2['id'] = $newid;

						$this->db->update($attr_table, $r2,array('id'=>$newid));
						//$this->db->update($attr_table.'_en', $r2_en,array('id'=>$newid));
                        $datas = array_merge($r,$r2);
                        $datas_en = array_merge($r_en,$r2_en);
					}
				} else {

                    unset($r['block'],$r_en['block']);
                    //设置为推送
                    $r['push'] = $r_en['push'] = 1;
					$newid = $this->db->insert($master_table, $r);
                    $r_en['id'] = $newid;
					//$this->db->insert($master_table.'_en', $r_en);
                    $datas = $r;
                    $datas_en = $r_en;
					if($attr_table) {
						$r2 = $this->db->get_one($attr_table,array('id'=>$id));
						//$r2_en = $this->db->get_one($attr_table.'_en',array('id'=>$id));
						$r2['id'] = $newid;
						$r2_en['id'] = $newid;
						$this->db->insert($attr_table, $r2);
						//$this->db->insert($attr_table.'_en', $r2_en);
                        $datas = array_merge($r,$r2);
                        $datas_en = array_merge($r_en,$r2_en);
					}
                    $formdata['new_id'] = $newid;
                    $formdata['new_siteid'] = $category['siteid'];
                    $formdata['new_cid'] = $cid;
                    $this->db->insert('content_ids', $formdata);

                    //判断是否存在，防止意外发生
					if(!$this->db->get_one('content_rank',array('cid'=>$cid,'id'=>$newid))) {
						//统计表加默认数据
						$this->db->insert('content_rank',array('cid'=>$cid,'id'=>$newid,'updatetime'=>SYS_TIME));
					}
				}
                //只有默认路径使用新的地址

                if($r['route']==0) {
                    $urls = $urlclass->showurl(array('id'=>$newid,'cid'=>$cid,'addtime'=>$r['addtime'],'page'=>1,'route'=>$r['route']));
                    $this->db->update($master_table,array('url'=>$urls['url']),array('id'=>$newid));
                    //$this->db->update($master_table.'_en',array('url'=>$urls['url']),array('id'=>$newid));
                }

                if($category['showhtml'] && $r['status']==9) {
                    //上一页
                    $datas['previous_page'] = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                    //下一页
                    $datas['next_page'] = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                    $this->html = load_class('html','content');
                    $this->html->set_category($category);
                    $this->html->set_categorys();
                    $this->html->load_formatcache();
                    $this->html->show($datas,1,1,$urls['root']);

                    $datas_en['previous_page'] = $this->db->get_one($master_table.'_en',"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                    //下一页
                    $datas_en['next_page'] = $this->db->get_one($master_table.'_en',"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                    $this->html->show($datas_en,1,1,$urls['root']);
                }
                //----end 推送中文内容
            }
            MSG('推送成功',$GLOBALS['forward']);
        }

    }
}