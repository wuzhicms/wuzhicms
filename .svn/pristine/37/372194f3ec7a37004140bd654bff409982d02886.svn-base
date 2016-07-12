<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 公司需求发布
 */
load_class('foreground', 'member');
class cominfo extends WUZHI_foreground {
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
        $categorys = get_cache('category','content');
        $page = intval($GLOBALS['page']);
        $page = max($page,1);

        $where = "`publisher`='$publisher'";

        $result1 = $this->db->get_list('gsxq',$where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        $where = "`publisher`='$publisher' AND `status`=9";
        $result2 = $this->db->get_list('gsxq',$where, '*', 0, 50,0,'sort DESC,updatetime DESC');

        $where = "`publisher`='$publisher' AND `status` IN (1,2,3)";
        $result3 = $this->db->get_list('gsxq',$where, '*', 0, 50,0,'id DESC');

        $where = "`publisher`='$publisher' AND `status`=0";
        $result4 = $this->db->get_list('gsxq',$where, '*', 0, 50,0,'id DESC');
        $point_config = get_cache('point_config');
        include T('content','member_cominfo_listing');
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
            $cid = 69;
            $cate_config = get_cache('category_'.$cid,'content');
            if(!$cate_config) MSG(L('category not exists'));
            //如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
            if(isset($GLOBALS['modelid']) && is_numeric($GLOBALS['modelid'])) {
                $modelid = $GLOBALS['modelid'];
            } else {
                $modelid = $cate_config['modelid'];
            }

                $formdata = $GLOBALS['form'];
                $formdata['title'] = intval($formdata['renshu']).'人    预算'.intval($formdata['yusuan']).'元/人    预计体检时间：'.$formdata['tjtime'];
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

                $formdata['master_data']['province'] = remove_xss($GLOBALS['LK3_1']);
                $formdata['master_data']['city'] = remove_xss($GLOBALS['LK3_2']);
                $formdata['master_data']['area'] = remove_xss($GLOBALS['LK3_3']);
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
            //扣除积分
            $point_config = get_cache('point_config');
            if($point_config['cominfoadd']) {
                $credit_api = load_class('credit_api','credit');
                $credit_api->handle($uid, '-',$point_config['cominfoadd'], '发布信息扣除积分<br>'.$formdata['title']);
            }
            MSG('信息发布成功，我们将在24小时内进行审核！');
        } else {
            $categorys = get_cache('category','content');
            include T('content','member_cominfo_newinfo');
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
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        $this->db->update('gsxq', array('status'=>'0'), array('id' => $id,'publisher'=>$memberinfo['username']));
        MSG('删除成功！',HTTP_REFERER);
    }

    public function referer() {
        $id = intval($GLOBALS['id']);
        $memberinfo = $this->memberinfo;
        if($memberinfo['points']<10) {
            exit('2');
        }
        $this->db->update('gsxq', array('updatetime'=>SYS_TIME), array('id' => $id));
        //扣除积分
        $point_config = get_cache('point_config');
        if($point_config['cominfo_f5']) {
            $credit_api = load_class('credit_api','credit');
            $credit_api->handle($memberinfo['uid'], '-',$point_config['cominfo_f5'], '刷新信息消耗',$id);
        }
        exit('1');
    }
}