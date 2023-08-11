<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/10/4
 * Time: 6:43
 */
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_category
{
    public $siteid = 1;
    public $type; //栏目类型
    public $cid; //
    public $categorys; //所有栏目
    public $catname = array();  //待添加栏目
    public $formdata = array(); //表单数据
    public $dataTable; //数据表


    function __construct()
    {
        $this->db       = load_class('db');
        $this->pinyin   = load_class('pinyin');
    }

    function add()
    {
        foreach ($this->catname as $key => $value) {
            if(trim($value)=='') continue;

            $this->formdata['siteid'] = $this->siteid;
            $this->formdata['keyid'] = M;
            $this->formdata['pid'] = intval($GLOBALS['form']['pid']);
            $this->formdata['name'] = trim($value);
            $this->formdata['type'] = $this->type;
            if($GLOBALS['catdir'][$key]) {
                $this->formdata['catdir'] = trim(sql_replace($GLOBALS['catdir'][$key]));
            } else {
                $py = $this->pinyin->return_py($this->formdata['name']);
                $this->formdata['catdir'] = $py['pinyin'];
            }

            $this->formdata['parentdir'] = $this->get_parentdir($this->formdata['pid']);

            $cid = $this->db->insert($this->dataTable,$this->formdata);
            if($this->type==2) {
                $urls['url'] = $GLOBALS['url'];
            } else {
                //生成url
                $urlclass = load_class('url','content',$this->formdata);
                $categorys[$cid] = $this->formdata;
                $urlclass->set_categorys($categorys);
                $urls = $urlclass->listurl(array('cid'=>$cid,'page'=>1));
            }

            if($this->formdata['pid']) {
                $this->db->update($this->dataTable,array('child'=>1),array('cid'=>$this->formdata['pid']));
            }
            $this->db->update($this->dataTable,array('url'=>$urls['url']),array('cid'=>$cid));
            //添加上栏目访问权限
        }
    }

    public function edit()
    {
        $this->formdata['keyid'] = M;
        $this->formdata['type'] = $this->type;
        $this->formdata['parentdir'] = $this->get_parentdir($this->cid);
        if($this->type==2) {
            $urls['url'] = $GLOBALS['url'];
        } else {
            //生成url
            $urlclass = load_class('url', 'content', $this->formdata);
            $this->categorys[$this->cid] = $this->formdata;
            $urlclass->set_categorys($this->categorys);
            $urls = $urlclass->listurl(array('cid' => $this->cid, 'page' => 1));
        }
        $this->formdata['url'] = $urls['url'];

        $this->db->update($this->dataTable,$this->formdata,array('cid'=>$this->cid));
    }

    public function delete()
    {
        $this->db->delete($this->dataTable,array('cid'=>$this->cid));
        $this->delete_child($this->cid);
    }

    private function delete_child($cid) {
        $r = $this->db->get_one('category',array('pid'=>$cid));
        if($r) {
            $this->db->delete('category',array('cid'=>$r['cid']));
            $this->delete_child($r['cid']);
        }
    }

    /**
     * @return string
     * Date: 2020/10/4
     * DES : 获取父级节点目录名称
     */
    /**
     * 生成父栏目目录
     * @param $pid
     */
    private function get_parentdir($cid,$result = '') {
        if($cid==0) return '';
        if($result) $this->categorys = $result;
        $pids = $this->get_parents($cid);
        if($pids) {
            $pids = explode(',',$pids);
            $dir = '';
            foreach($pids as $_cid) {
                if($_cid && $cid!=$_cid) $dir .= $this->categorys[$_cid]['catdir'].'/';
            }
            return rtrim($dir,'/');
        } else {
            return $this->categorys[$cid]['catdir'];
        }
    }

    /**
     * 获取所有父级栏目id
     * @param $cid
     * @return string
     */
    private function get_parents($cid, $arrpid = '', $n = 1) {
        $this->getCategory();
        if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$cid])) return false;
        $pid = $this->categorys[$cid]['pid'];
        $arrpid = $arrpid ? $pid.','.$arrpid : $pid;
        if($pid) {
            $arrpid = $this->get_parents($pid, $arrpid, ++$n);
        } else {
            $this->categorys[$cid]['arrpid'] = $arrpid;
        }
        $parentid = $this->categorys[$cid]['pid'];
        return $arrpid;
    }

    private  function getCategory()
    {
        $categorys = $this->db->get_list($this->dataTable);
        foreach ($categorys as $key=>$value) {
            $tmp[ $value['cid'] ] =  $value;
        }
        $this->categorys = $tmp;
    }

    /**
     * 返回栏目树数据
     */
    public function categoryTree()
    {
        $where = "`keyid`='" . M . "' AND `siteid`='$this->siteid' AND `type`<2";
        $result_tmp = $this->db->get_list($this->dataTable, $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
        foreach ($result_tmp as $key=>$value) {
            $result[$value['cid']] = $value;
        }
        return $result;
    }
}