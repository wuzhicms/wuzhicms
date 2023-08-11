<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/10/4
 * Time: 11:34
 */
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_content
{
    private $db;
    public $status; //文章状态
    public $categoryTable; //栏目表
    public $page; //current page
    public $result; //返回结果
    public $pages; //返回页数
    public $siteid;
    public $formdata; //表单数据
    public $modelid;
    public $id;
    public $cid;
    public $title_css;
    public $category;
    public $categorys;


    function __construct()
    {
        $this->db       = load_class('db');
        $this->pinyin   = load_class('pinyin');
        $this->categoryTable = 'category_magazine';
    }

    /**
     * @param $this->cid,$this->status,$this->page,$this->siteid,$thsi->categoryTable
     *
     */
    function listing()
    {
        if ($this->cid) {
            $cate_config = $this->db->get_one( $this->categoryTable,array( 'cid' => $this->cid, 'siteid' => $this->siteid ) );
        } else {
            $cate_config = $this->db->get_one( $this->categoryTable, array( 'siteid' => $this->siteid ) );
        }
        if(!$cate_config) MSG(L('category not exists'));
        if ( !empty($GLOBALS['modelid']) ) {
            $modelid = intval($GLOBALS['modelid']);
        } else {
            $modelid = $cate_config['modelid'];
        }

        if($cate_config['siteid'] != $this->siteid) MSG('请重新选择栏目');
        $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
        $master_table = $model_r['master_table'];
        if ($this->cid == 37 || $this->cid == 38) {
            $where = "`cid`='$this->cid' AND `status`='$this->status' AND `maga_id`='$this->maga_id' AND `issue_id`='$this->issue_id'";
        } else {
            $where = "`cid`='$this->cid' AND `status`='$this->status'";
        }
        $page = $this->page;
        $page = max($page,1);
        $this->result = $this->db->get_list($master_table,$where, '*', 0, 20,$page,'addtime DESC');
        $this->pages = $this->db->pages;
    }
    /* $formdata,$modelid,title_css,category,categorys
     *
     */
    function add()
    {
       
        //插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
        $addtime = empty($this->formdata['addtime']) ? SYS_TIME : strtotime($this->formdata['addtime']);
        //添加数据之前，将用户提交的数据按照字段的配置，进行处理
        require get_cache_path('content_add','model');
        if ($this->cid) {
            $cate_config = $this->db->get_one( $this->categoryTable,array( 'cid' => $this->cid ) );
            $form_add = new form_add($cate_config['modelid']);
        } else {
            $form_add = new form_add($this->modelid);
        }
        
        $formdata = $form_add->execute($this->formdata);
        $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;

        $formdata['master_data']['cid'] = $this->cid;
        //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
        $formdata['master_data']['status'] =$this->formdata['status'];

        //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
        $formdata['master_data']['route'] = intval($this->formdata['route']);
        $formdata['master_data']['publisher'] = get_cookie('username');
        //标题样式
        $formdata['master_data']['css'] = $this->title_css;
        //echo $formdata['master_table'];exit;
        if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
            $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
        }

        $title = trim(remove_xss($formdata['master_data']['title']));
        $py = $this->pinyin->return_py($title);
        $formdata['master_data']['initial'] = strtolower($py['pinyin']);

        $models = $this->db->get_one( 'model', array('modelid'  => $this->modelid) );

    

        $id = $this->db->insert($models['master_table'],$formdata['master_data']);
        if($this->formdata['master_data']['route']>1) {//外部链接
           // $urls['url'] = remove_xss($this->formdata['url']);
        } else {
            //生成url
            $urlclass = load_class('url','content',$this->category);
            $urlclass->set_category($this->category);
            $urlclass->set_categorys($this->categorys);

            $route_config = array('id'=>$id,'cid'=>$this->cid,'addtime'=>$addtime,'page'=>1);
            $route_config = array_merge($route_config,$formdata['master_data']);
            $urls = $urlclass->showurl($route_config);
        }

        $this->db->update($models['master_table'],array('url'=>$urls['url']),array('id'=>$id));
        if(!empty($formdata['attr_table'])) {
            $formdata['attr_data']['id'] = $id;
            // print_r($formdata['attr_data']);exit;
            $this->db->insert($models['attr_table'],$formdata['attr_data']);
        }
    }
    public function edit()
    {
        //插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
        $addtime = empty($this->formdata['addtime']) ? SYS_TIME : strtotime($this->formdata['addtime']);
        //添加数据之前，将用户提交的数据按照字段的配置，进行处理
        require get_cache_path('content_add','model');
        if ($this->cid) {
            $cate_config = $this->db->get_one( $this->categoryTable,array( 'cid' => $this->cid ) );
            $form_add = new form_add($cate_config['modelid']);
        } else {
            $form_add = new form_add($this->modelid);

        }
        $formdata = $form_add->execute($this->formdata);
        $formdata['master_data']['addtime'] =  $addtime;
        $formdata['master_data']['updatetime'] = SYS_TIME;

        $formdata['master_data']['cid'] = $this->cid;
        //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
        $formdata['master_data']['status'] =$this->formdata['status'];

        //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
        $formdata['master_data']['route'] = intval($this->formdata['route']);
        $formdata['master_data']['publisher'] = get_cookie('username');
        //标题样式
        $formdata['master_data']['css'] = $this->title_css;
        //echo $formdata['master_table'];exit;
        if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
            $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
        }

        $title = trim(remove_xss($formdata['master_data']['title']));
        $py = $this->pinyin->return_py($title);
        $formdata['master_data']['initial'] = strtolower($py['pinyin']);

        if($this->formdata['master_data']['route']>1) {//外部链接
            // $urls['url'] = remove_xss($this->formdata['url']);
        } else {
            //生成url
            $urlclass = load_class('url','content',$this->category);
            $urlclass->set_category($this->category);
            $urlclass->set_categorys($this->categorys);

            $route_config = array('id'=>$this->id,'cid'=>$this->cid,'addtime'=>$addtime,'page'=>1);
            $route_config = array_merge($route_config,$formdata['master_data']);
            $urls = $urlclass->showurl($route_config);
        }
        $this->db->update($formdata['master_table'],$formdata['master_data'],array('id'=>$this->id));
        if(!empty($formdata['attr_table']) && $formdata['attr_data']) {
            $_attr_table = $attr_table = $formdata['attr_table'];

            //查询从表是否存在数据,不存在则修复数据.
            $attr_data = $this->db->get_one($attr_table, array('id' => $this->id),'id');
            if($attr_data) {
                $this->db->update($attr_table,$formdata['attr_data'],array('id'=>$this->id));
            } else {
                $formdata['attr_data']['id'] = $this->id;
                $this->db->insert($attr_table,$formdata['attr_data']);
            }
        }
    }
}