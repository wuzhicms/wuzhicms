<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 内容模版，标签解析
 */
class WUZHI_content_template_parse {
	public $number = 0;//初始化查询总数
	public $pages = '';//分页
	public $childs = '';//子栏目
    public function __construct() {
        $this->db = load_class('db');
        $this->categorys = get_cache('category','content');
    }

    /**
     * 内容列表标签
     *
     * @param $c
     * @return array
     */
    public function listing($c) {
        if(!isset($c['cid']) && !isset($c['modelid'])) return array();
        $GLOBALS['result_lists'] = 1;
        $cid = intval($c['cid']);
        //$urlrule = 'list-{$cid}-{$page}.html';
        if(isset($c['urlrule'])) {
            $urlrule = $c['urlrule'];
        } else {
            $urlrule = 'index.php?cid={$cid}&page={$page}';
        }

        if(empty($this->categorys[$cid]) && !isset($c['modelid'])) {
            $master_table = 'content_share';
        } elseif($c['modelid']) {
            $model_r = $this->db->get_one('model', array('modelid'=>$c['modelid']), 'master_table');
            if(!$model_r) return array();
            $master_table = $model_r['master_table'];
        } else {
            if(empty($this->categorys[$cid])) return array();
            $modelid = $this->categorys[$cid]['modelid'];
            $model_r = $this->db->get_one('model', array('modelid'=>$modelid), 'master_table');
            if(!$model_r) return array();
            $master_table = $model_r['master_table'];
        }
        if(defined('HTML')) {
            $catdir = $GLOBALS['catdir'];
            $categorydir = $GLOBALS['categorydir'];
        } else {
            $catdir = '';
            $categorydir = '';
        }
        if($c['where']) {
            $where = $c['where'];
            $where = str_replace("\t",'',$where);
            $where = str_replace("%20",'',$where);
            $where = str_replace("%27",'',$where);
            $where = str_replace("*",'',$where);
            $where = str_replace("\"",'',$where);
            $where = str_replace("/",'',$where);
            $where = str_replace(";",'',$where);
            $where = str_replace("#",'',$where);
            $where = str_replace("--",'',$where);
            $where = '`status`=9 AND '.$where;
        } elseif($cid) {
            if($this->categorys[$cid]['child']) {
                $this->childs = '';
                $this->get_child($cid);
                if($this->childs) {
                    $cids = implode(',',$this->childs);
                    $where = '`cid` IN ('.$cids.') AND `status`=9';
                } else {
                    $where = '`cid`='.$cid.' AND `status`=9';
                }
            } else {
                $where = '`cid`='.$cid.' AND `status`=9';
            }

        } else {
            $where = '`status`=9';
        }
        if(isset($c['eliteflag']) && $c['eliteflag']) {
            $where .= " AND `eliteflag`='".$c['eliteflag']."'";
        } elseif(isset($c['uid'])) {
             $where .= " AND `uid`='".intval($c['uid'])."'";
        }
        $order = isset($c['order']) ? $c['order'] : 'id DESC';
        $colspan = isset($c['colspan']) ? $c['colspan'] : 10;
        $rule_arr = array('cid'=>$cid,'page'=>$c['page'],'catdir'=>$catdir,'categorydir'=>$categorydir);
        if(isset($c['variables'])) $rule_arr = array_merge($rule_arr,$c['variables']);
        $result = $this->db->get_list($master_table, $where, '*', $c['start'], $c['pagesize'], $c['page'],$order,'','',$urlrule,$rule_arr,$colspan);

        if(empty($result)) $GLOBALS['result_lists'] = 0;
        $GLOBALS['pagesize'] = $c['pagesize'];
        $GLOBALS['pages'] = 1;
        if($c['page']) {
            $this->pages = $this->db->pages;
            $GLOBALS['pages'] = $this->pages;
        }

        return $result;
	}

    /**
     * 栏目列表标签
     *
     * @param $c
     * @return mixed
     */
    public function category($c) {
        if(isset($c['cid'])) {
            $cid = intval($c['cid']);
            $where = '`pid`='.$cid;
        } else {
            $where = '';
        }
        if(isset($c['mshow']) && $c['mshow']) {
            $where = $where ? " AND `mshow`=1" : "`mshow`=1";
        }
        $order = isset($c['order']) ? $c['order'] : 'id DESC';
        $result = $this->db->get_list('category', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        return $result;
    }

    /**
     * 相关内容标签
     *
     * @param $c
     * @return mixed
     */
    public function relation($c) {
        //cid="24" id="78"
        $order = isset($c['order']) ? $c['order'] : 'id DESC';
        $id = isset($c['id']) ? intval($c['id']) : 0;
        $cid = isset($c['cid']) ? intval($c['cid']) : 0;
        if($id && $cid) {
            $where = "`id`='$id' AND `cid`='$cid'";
            $result = $this->db->get_list('content_relation', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        } elseif(!empty($c['keywords'])) {
            $modelid = $this->categorys[$cid]['modelid'];
            $model_r = $this->db->get_one('model', array('modelid'=>$modelid), 'master_table');
            if(!$model_r) return array();

            $keywords_arr = explode(',',$c['keywords']);
            $merge_result = $result = array();
            foreach($keywords_arr as $keyword) {
                if(count($result)>$c['pagesize']) break;
                $where = "`keywords` LIKE '%$keyword%'";
                $result = $this->db->get_list($model_r['master_table'], $where, '*', $c['start'], $c['pagesize'], 0,$order);
                if(!empty($result)) $merge_result = array_merge($merge_result,$result);
            }
            $result = array();
            $i = 0;

            foreach($merge_result as $rs) {
                if($rs['id']==$id && $rs['cid']==$cid) continue;
                if($i>$c['pagesize']) break;
                $result[$rs['id']] = $rs;
                $i++;
            }
           // print_r($result);
        } else {
            $result = array();
        }
        return $result;
    }

    /**
     * 排行榜
     * @param $c
     */
    public function rank($c) {
       //总排行，当日，昨日排行，周排行，月排行
        $order = isset($c['order']) ? $c['order'] : 'views DESC';
        $id = isset($c['id']) ? intval($c['id']) : 0;
        $cid = isset($c['cid']) ? intval($c['cid']) : 0;
        if($cid) {
            if($this->categorys[$cid]['child']) {
                $this->get_child($cid);
                $cids = implode(',',$this->childs);
                $where = '`cid` IN ('.$cids.')';
            } else {
                $where = array('cid'=>$cid);
            }
        } else {//cid为空时，为调用全部排行
            $where = '';
        }

        $rank_result = $this->db->get_list('content_rank', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        $result = array();
        foreach($rank_result as $rs) {
            if(empty($this->categorys[$rs['cid']])) {
                $master_table = 'content_share';
            } else {
                if(empty($this->categorys[$rs['cid']])) return array();
                $modelid = $this->categorys[$rs['cid']]['modelid'];
                $model_r = $this->db->get_one('model', array('modelid'=>$modelid), 'master_table');
                if(!$model_r) return array();
                $master_table = $model_r['master_table'];
            }
            $r = $this->db->get_one($master_table,array('id'=>$rs['id']));
            $result[] = $r;
        }
        return $result;
    }
    public function block($c) {
        if($c['type']==1) {
            if(isset($c['cid'])) {
                if($this->categorys[$c['cid']]['child']) {
                    $this->get_child($c['cid']);
                    $cids = implode(',',$this->childs);
                    $where = "`blockid`='".$c['blockid']."' AND `cid` IN ($cids) AND `status`=9";
                } else {
                    $where = array('blockid'=>$c['blockid'],'cid'=>$c['cid'],'status'=>9);
                }

            } else {
                $siteid = isset($c['siteid']) ? $c['siteid'] : 1;
                $where = array('blockid'=>$c['blockid'],'status'=>9,'siteid'=>$siteid);
            }
            $order = isset($c['order']) ? $c['order'] : 'sort DESC,id DESC';
            $result = $this->db->get_list('block_data', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        }elseif($c['type']==3) {
            $url = $c['url'];
            $data = file_get_contents($url);
            $xml = load_class('xml');
            $result = $xml->xml_unserialize($data);
        } elseif($c['type']==4) {
            $url = $c['url'];
            $data = @file_get_contents($url);
            $result = json_decode($data,true);
        }
        return $result;
    }
    private function get_child($k_id) {
        foreach($this->categorys as $id => $value) {
            if($value['pid'] == $k_id) {
                $this->childs[] = $id;
                $this->get_child($id);
            }
        }
    }

    /**
     * 体检区域
     * @param $c
     */
    public function quyu($c) {
        $order = isset($c['order']) ? $c['order'] : 'sort DESC';
        $pid = isset($c['pid']) ? intval($c['pid']) : 0;
        if($pid) {
            $where = array('pid'=>$pid);
        } else {//cid为空时，为调用全部排行
            $where = '';
        }
        $result = $this->db->get_list('quyu', $where, '*', $c['start'], $c['pagesize'], 0,$order);
        return $result;
    }


}