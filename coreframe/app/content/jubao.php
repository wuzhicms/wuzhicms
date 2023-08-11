<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/7
 * Time: 10:43
 */
defined('IN_WZ') or exit('No direct script access allowed');
class jubao
{
    private $db;
    function __construct()
    {
        $this->db = load_class('db');
    }
    public function add()
    {
        $modelid = 8024;
        $cid = 97;
        $cate_config = get_cache('category_'.$cid,'content');
        if($GLOBALS['form']){
            $addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
            $formdata = $GLOBALS['form'];
            require get_cache_path('content_add','model');
            $form_add = new form_add($modelid);
            $formdata = $form_add->execute($formdata);
            $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;
            $formdata['master_data']['cid'] = $cid;
            //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
            $formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 9;
            $formdata['master_data']['publisher'] = '纪检监察处';
            $id = $this->db->insert($formdata['master_table'],$formdata['master_data']);

            $urlclass = load_class('url','content',$cate_config);
            $categorys = get_cache('category','content');
            $urlclass->set_category($cate_config);
            $urlclass->set_categorys($categorys);
            $route_config = array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1);
            $route_config = array_merge($route_config,$formdata['master_data']);
            $urls = $urlclass->showurl($route_config);
            $accessCode = date('Ymd',time()).mt_rand();
            $this->db->update($formdata['master_table'],array('url'=>$urls['url'],'accessCode'=>$accessCode),array('id'=>$id));
            MSG('提交成功,查询码：'.$accessCode);
        }else{
            load_function('template');
            require_once get_cache_path('content_form','model');
            $form_build =  new form_build($modelid);
            $form_build->cid = $cid;
            $form_build->extdata['catname'] = $cate_config['name'];
            $form_build->extdata['type'] = $cate_config['type'];
            $formdata = $form_build->execute();
            load_class('form');
            include T('jubao','add','default');
        }


    }

    function search(){
        $accessCode = remove_xss($GLOBALS['accessCode']);
        if($accessCode){
            $result = $this->db->get_one('report',array('accessCode'=>$accessCode));
            if(empty($result)){
                MSG('信件不存在');
            }
            if(isset($result['reply']) && !empty($result['reply'])){
                 header('Location:'.WEBURL.'index.php?f=jubao&v=getdetail&id='.$result['id']);
            }else{
                MSG('信件办理中');
            }
        }else{
            include T('jubao','search','default');
        }
    }

    function getDetail()
    {
        $id = intval($GLOBALS['id']);
        $qustions = $this->db->get_one('report',array('id'=>$id));
        include T('jubao','detail','default');
    }

    function baoguangtai()
    {
        include T('jubao','index','default');
    }




}