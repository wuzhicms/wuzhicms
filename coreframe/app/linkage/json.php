<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/*
[
{"v" : "31", "n" : "特色天", "s" : [
    {"v" : "61", "n" : "版本"},
    {"v" : "62", "n" : "问问"}
]},
{"v" : "60", "n" : "nnn"}
]
 */
class json {
    private $db;
    public function __construct() {
        $this->db = load_class('db');
    }
    public function init() {
        $linkageid = isset($GLOBALS['linkageid']) ? intval($GLOBALS['linkageid']) : exit('-1');
        $result = $this->db->get_list('linkage_data', array('linkageid'=>$linkageid,'pid'=>0), '*', 0, 200, 0,"sort ASC,lid ASC");
        $returnid = intval($GLOBALS['returnid']);
        $str = '[';
        foreach($result as $rs) {
            $vid = $returnid ? $rs['lid'] : $rs['name'];
            $str .= '{"v" : "'.$vid.'", "n" : "'.$rs['name'].'"';
            if($rs['child']) {
                $str .= $this->child($rs['lid'],$returnid);
            }
           $str .= '},';
        }
        $str = substr($str,0,-1);
        $str .= ']';
        echo $str;
    }
    private function child($pid,$returnid) {
        $result = $this->db->get_list('linkage_data', array('pid'=>$pid), '*', 0, 200, 0,"sort ASC,lid ASC");
        $str = ', "s" : [';
        foreach($result as $rs) {
            $vid = $returnid ? $rs['lid'] : $rs['name'];
            $str .= '{"v" : "'.$vid.'", "n" : "'.$rs['name'].'"';
            if($rs['child']) {
                $str .= $this->child($rs['lid'],$returnid);
            }
            $str .= '},';
        }
        $str = substr($str,0,-1);
        $str .= ']';
        return $str;
    }
}
?>