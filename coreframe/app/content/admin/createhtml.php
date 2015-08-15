<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 批量生成静态／批量更新url
 */
define('HTML',true);
load_class('admin');
class createhtml extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->categorys = get_cache('category','content');
        $this->db = load_class('db');
        $this->html = load_class('html','content');
        $this->urlclass = load_class('url','content');
    }

    public function listing() {
        $form = load_class('form');
        $categorys = get_cache('category','content');
        foreach($categorys as $cid=>$cate) {
            $categorys[$cid]['cid'] = $cid;
        }
        include $this->template('createhtml_listing');
    }
    /**
     * 批量生成首页
     */
    public function index() {
        $length = $this->html->index();
        MSG('首页更新完成！大小:'.sizecount($length));
    }
    /**
     * 批量生成栏目页
     */
    public function htmllist() {
        $goto = '';
        $uid = $_SESSION['uid'];
        if(isset($GLOBALS['setcache'])) {
            $catids = get_cache('cache-html-'.$uid);
        } else {
            if($GLOBALS['catids'][0]=='') {
                foreach($this->categorys as $_id=>$_tmp) {
                    if($_tmp['listhtml'] && $_tmp['type']!=2) $catids[] = $_id;
                }

            } else {
                $catids = array();
                foreach($GLOBALS['catids'] as $_id) {
                    if($this->categorys[$_id]['listhtml'] && $this->categorys[$_id]['type']!=2) $catids[] = $_id;
                }
            }
        }
        if(empty($catids)) MSG('生成完成！','?m=content&f=createhtml&v=listing'.$this->su());
        $cid = array_shift($catids);
        set_cache('cache-html-'.$uid,$catids);
        $this->category = get_cache('category_'.$cid,'content');
        $this->urlclass->set_category($this->category);
        $this->urlclass->set_categorys($this->categorys);
        $page = isset($GLOBALS['page']) ? $GLOBALS['page'] : 1;
        $pre_page = 10;//每次生成页数
        $this->html->set_category($this->category);
        $this->html->set_categorys($this->categorys);
        for($i=1;$i<=$pre_page;$i++) {
            $page = $page+1;
            $urls = $this->urlclass->listurl(array('cid'=>$cid,'page'=>$page));
            if(empty($urls['root'])) {

            }
            $file_root = $urls['root'];
            $this->html->listing($file_root,$page);
            if($GLOBALS['result_lists']==0) {
                set_cache('cache-html-'.$uid,$catids);
                MSG($this->category['name'].' '.L('createhtml'),'?m=content&f=createhtml&v=htmllist&setcache=1&'.$this->su(),1);
            }
        }
        MSG($this->category['name'].' '.L('createhtml'),'?m=content&f=createhtml&v=htmllist&setcache=1&page='.$page.$this->su(),1);


    }
    public function htmlshow() {
        $goto = '';
        $uid = $_SESSION['uid'];
        if(isset($GLOBALS['setcache'])) {
            $catids = get_cache('cache-html-'.$uid);
        } else {
            if($GLOBALS['catids'][0]=='') {
                foreach($this->categorys as $_id=>$_tmp) {
                    if($_tmp['showhtml']) $catids[] = $_id;
                }
            } else {
                $catids = array();
                foreach($GLOBALS['catids'] as $_id) {
                    if($this->categorys[$_id]['showhtml']) $catids[] = $_id;
                }
            }
            set_cache('cache-html-'.$uid,$catids);
        }
        if(empty($catids)) MSG('生成完成！','?m=content&f=createhtml&v=listing'.$this->su());
        $cid = array_shift($catids);

        $this->category = get_cache('category_'.$cid,'content');
        $this->urlclass->set_category($this->category);
        $this->urlclass->set_categorys($this->categorys);
        $startid = isset($GLOBALS['startid']) ? $GLOBALS['startid'] : 0;
        $pre_page = 10;//每次生成页数
        $this->html->set_category($this->category);
        $this->html->set_categorys($this->categorys);
        $models = get_cache('model_content','model');
        $modelid = $this->category['modelid'];
        $model_r = $models[$modelid];
        $master_table = $model_r['master_table'];
        $where = "`cid`='$cid' AND `status`=9";

        $result = $this->db->get_list($master_table,$where, '*', $startid, $pre_page, 0,'id DESC');
        if(empty($result)) {
            set_cache('cache-html-'.$uid,$catids);
            MSG($this->category['name'].' '.L('createhtml'),'?m=content&f=createhtml&v=htmlshow&setcache=1'.$this->su(),1);
        }
        //print_r($result);
        $this->html->load_formatcache();

        foreach($result as $key=>$rs) {
            $id = $rs['id'];
            $data = $rs;

            if($model_r['attr_table']) {
                $attr_table = $model_r['attr_table'];
                if($data['modelid']) {
                    $modelid = $data['modelid'];
                    $attr_table = $models[$modelid]['attr_table'];
                }
                $attr_data = $this->db->get_one($attr_table,array('id'=>$id));
                if($attr_data) {
                    $data = array_merge($attr_data,$data);
                } else {
                    //删除数据不全的内容
                    $this->db->delete($master_table,array('id'=>$id));
                    continue;
                }
            }

            //上一页
            if($key) {
                $data['previous_page'] = array_slice($result, $key, 1);//上一页
                $data['next_page'] = array_slice($result, $key-2, 1);//下一页
                if(empty($data['previous_page'])) {
                    $data['previous_page'] = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
                }
            } else {
                $data['previous_page'] = $this->db->get_one($master_table,"`cid`= '$cid' AND `id`>'$id' AND `status`=9",'*',0,'id ASC');
                $data['next_page'] = $this->db->get_one($master_table,"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
            }

            $this->html->show($data,1,1,'',$model_r);

            $startid = $startid+1;
        }
        MSG($this->category['name'].' '.$startid.' '.L('createhtml'),'?m=content&f=createhtml&v=htmlshow&setcache=1&startid='.$startid.$this->su(),1);

    }
    public function updateurls() {

        $goto = '';
        $uid = $_SESSION['uid'];
        if(isset($GLOBALS['setcache'])) {
            $catids = get_cache('cache-html-'.$uid);
        } else {
            if($GLOBALS['catids'][0]=='') {
                $catids = array_keys($this->categorys);
            } else {
                $catids = $GLOBALS['catids'];
            }
            set_cache('cache-html-'.$uid,$catids);
        }
        if(empty($catids)) MSG('url更新完成！','?m=content&f=createhtml&v=listing'.$this->su());
        $cid = array_shift($catids);

        $this->category = get_cache('category_'.$cid,'content');
        $this->urlclass->set_category($this->category);
        $this->urlclass->set_categorys($this->categorys);
        $startid = isset($GLOBALS['startid']) ? $GLOBALS['startid'] : 0;
        $pre_page = 10;//每次生成页数

        $modelid = $this->category['modelid'];
        $model_r = $this->db->get_one('model',array('modelid'=>$modelid));
        $master_table = $model_r['master_table'];
        $where = "`cid`='$cid' AND `status`=9";

        $result = $this->db->get_list($master_table,$where, '*', $startid, $pre_page, 0,'id DESC');
        if(empty($result)) {
            set_cache('cache-html-'.$uid,$catids);
            MSG($this->category['name'].' '.L('update url'),'?m=content&f=createhtml&v=updateurls&setcache=1'.$this->su(),1);
        }
        foreach($result as $key=>$rs) {
            if($rs['route']>1) continue;
            $id = $rs['id'];
            $urls = $this->urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$rs['addtime'],'page'=>1,'route'=>$rs['route'],'productid'=>$rs['productid']));
            $this->db->update($master_table,array('url'=>$urls['url']),array('id'=>$id));

            $startid = $startid+1;
        }
        MSG($this->category['name'].' '.$startid.' '.L('update url'),'?m=content&f=createhtml&v=updateurls&setcache=1&startid='.$startid.$this->su(),1);
    }
}