<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 投稿
 */
load_class('foreground', 'member');
class contribute extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
	}
    /**
     * 列表
     */
    public function listing() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $publisher = $memberinfo['username'];

        $page = intval($GLOBALS['page']);
        $page = max($page,1);

        $where = "`publisher`='$publisher'";

        $result = $this->db->get_list('tougao',$where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        include T('content','member_contribute_listing');
    }

    /**
     * 信息发布
     */
    public function newinfo() {
        $memberinfo = $this->memberinfo;
        if($memberinfo['ischeck_mobile']==0) {
            MSG('您的手机还未验证！请先验证！','index.php?m=member&f=index&v=edit_mobile',3000);
        }
        $uid = $memberinfo['uid'];
        if(isset($GLOBALS['submit'])) {
            $cid = 48;
            $cate_config = get_cache('category_'.$cid,'content');
            if(!$cate_config) MSG(L('category not exists'));
            //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
            if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
                $modelid = $GLOBALS['modelid'];
            } else {
                $modelid = $cate_config['modelid'];
            }

                $formdata = $GLOBALS['form'];
                $formdata['title'] = strip_tags($formdata['title']);
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


            MSG('信息发布成功，我们将在24小时内进行审核！');
        } else {
            load_class('form');
            $categorys = get_cache('category','content');
            include T('content','member_contribute_newinfo');
        }

    }

    /**
     * 删除信息
     */
    public function delinfo() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        $this->db->update('tougao', array('status'=>'0'), array('id' => $id,'publisher'=>$memberinfo['username']));
        MSG('删除成功！',HTTP_REFERER);
    }
    /**
     * 查看信息
     */
    public function view() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        $data = $this->db->get_one('tougao', array('id' => $id,'publisher'=>$memberinfo['username']));
        include T('content','member_contribute_view');
    }
    /**
     * 修改信息
     */
    public function edit() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['title'] = strip_tags($GLOBALS['form']['title']);
            $formdata['content'] = strip_tags($GLOBALS['form']['content']);
            $formdata['updatetime'] = SYS_TIME;
            $formdata['status'] = 1;
            $this->db->update('tougao', $formdata, array('id' => $id,'publisher'=>$memberinfo['username']));
            MSG('更新成功！','?m=content&f=contribute&v=listing');
        } else {
            $data = $this->db->get_one('tougao', array('id' => $id,'publisher'=>$memberinfo['username']));
            include T('content','member_contribute_edit');
        }

    }

}