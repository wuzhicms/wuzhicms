<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 生成树状结构
 */
class WUZHI_tree {
    public $arr = array();
    public $icon = array('┇&nbsp;','├&nbsp;','└&nbsp;');
    private $result_array = '';
    //计算树状结构的最深层，默认不允许超过5层结构，有效防止数据结构混乱造成无限循环
    private $deep = 1;
 
    /**
    * 注意，array的索引要和索引值id值相同
    * 例子：
    * array(
    *      1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目A'),
    *      2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目B'),
    *      3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目A'),
    *      4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目B'),
    *      5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目C'),
    *      6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目A'),
    *      7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目B')
    *      )
    */
    function __construct($arr) {
		$this->arr = $arr;
		$this->result_array = '';
    }
 
    /**
    * 得到父级数组
    * @param int
    * @return array
    */
    public function get_parent($k_id) {
        $arrays = array();
        if(!isset($this->arr[$k_id])) return FALSE;
        $pid = $this->arr[$k_id]['pid'];
        $pid = $this->arr[$pid]['pid'];
        if(is_array($this->arr)) {
            foreach($this->arr as $id => $a) {
                if($a['pid'] == $pid) $arrays[$id] = $a;
            }
        }
        return $arrays;
    }
 
    /**
    * 得到子级数组
    * @param int
    * @return array
    */
    public function get_child($k_id) {
        $arrays = array();
        if(is_array($this->arr)) {
            foreach($this->arr as $id => $a) {
                if($a['pid'] == $k_id) $arrays[$id] = $a;
            }
        }
        $this->deep++;
        return $arrays ? $arrays : FALSE;
    }

    /**
    * 得到树型结构
    * @param int ID，表示获得这个ID下的所有子级
    * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
    * @param int 被选中的ID，比如在做树型下拉框的时候需要用到
    * @return string
    */
    public function create($k_id,$str,$sid=0,$adds='') {
        if($this->deep>5) {
            echo L('array structure error');
            exit;
        }
        $number=1;
        $child = $this->get_child($k_id);
        if(is_array($child)) {
        $total = count($child);
        foreach($child as $id=>$a) {
            $j = $k = '';
            if($number==$total){
                $j .= $this->icon[2];
            } else {
                $j .= $this->icon[1];
                $k = $adds ? $this->icon[0] : '';
            }
            $spacer = $adds ? $adds.$j : '';
            $selected = $id==$sid ? "selected" : '';
            @extract($a);
            eval("\$nstr = \"$str\";");
            $this->result_array .= $nstr;
            $this->create($id,$str,$sid,$adds.$k.'&nbsp;');
            $number++;
        }
        }
        $this->deep = 1;
        return $this->result_array;
    }

    public function get_treeview($cid, $treeid = 'tree', $str = "<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a></li>", $str2 = "<li><a href='javascript:w(\$cid);' onclick='o_p(\$cid,this)' class='i-t'>\$name</a>", $showlevel = 0, $currentlevel = 1, $have_child = FALSE) {
        $child = $this->get_child($cid);
        if (!defined('EFFECTED_INIT')) {
            $effected = ' id="' . $treeid . '"';
            define('EFFECTED_INIT', 1);
        }
        else {
            $effected = '';
        }
        if (!$have_child) $this->str .= '<ul' . $effected . '>';
        foreach ($child as $id => $a) {
            @extract($a);
            $this->str .= $have_child ? '<ul><li>' : '';
            $have_child = FALSE;
            if ($this->get_child($id)) {
                eval("\$nstr = \"$str2\";");
                $this->str .= $nstr;
                if ($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {
                    $this->get_treeview($id, '', $str, $str2, $showlevel, $currentlevel + 1, TRUE);
                }
            }
            else {
                eval("\$nstr = \"$str\";");
                $this->str .= $nstr;
            }
            $this->str .= $have_child ? '</li></ul>' : '</li>';
        }
        if (!$have_child) $this->str .= '</ul>';
        return $this->str;
    }
}
?>