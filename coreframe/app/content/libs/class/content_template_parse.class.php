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
        $this->models = get_cache('model_content','model');
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
            $model_r = $this->models[$c['modelid']];
            if(!$model_r) return array();
            $master_table = $model_r['master_table'];
            $attr_table = $model_r['attr_table'];
            if(LANGUAGE=='en') $attr_table.='_en';
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
        $colspan = isset($c['colspan']) ? $c['colspan'] : 8;
        $rule_arr = array('cid'=>$cid,'page'=>$c['page'],'catdir'=>$catdir,'categorydir'=>$categorydir);
        if(isset($c['variables'])) $rule_arr = array_merge($rule_arr,$c['variables']);

        if($attr_table && ($this->categorys[$cid]['yearfield'] || $c['moredata'])) {
            if($c['where']) {
                $where = 'a.`status`=9 AND '.$where;
            } elseif($cid) {
                if($this->categorys[$cid]['child']) {
                    $this->childs = '';
                    $this->get_child($cid);
                    if($this->childs) {
                        $cids = implode(',',$this->childs);
                        $where = 'a.`cid` IN ('.$cids.') AND a.`status`=9';
                    } else {
                        $where = 'a.`cid`='.$cid.' AND a.`status`=9';
                    }
                } else {
                    $where = 'a.`cid`='.$cid.' AND a.`status`=9';
                }

            } else {
                $where = 'a.`status`=9';
            }
            if(isset($c['eliteflag']) && $c['eliteflag']) {
                $where .= " AND a.`eliteflag`='".$c['eliteflag']."'";
            } elseif(isset($c['uid'])) {
                $where .= " AND a.`uid`='".intval($c['uid'])."'";
            } elseif(isset($c['typeid'])) {
                $where .= " AND a.`typeid`='".intval($c['typeid'])."'";
            }
            $order = isset($c['order']) ? $c['order'] : 'a.id DESC';
            $colspan = isset($c['colspan']) ? $c['colspan'] : 8;
            $rule_arr = array('cid'=>$cid,'page'=>$c['page'],'catdir'=>$catdir,'categorydir'=>$categorydir);
            if(isset($c['variables'])) $rule_arr = array_merge($rule_arr,$c['variables']);
            if(LANGUAGE=='en') $master_table .= '_en';

            //$result = $this->db->get_list($master_table, $where, '*', $c['start'], $c['pagesize'], $c['page'],$order,'','',$urlrule,$rule_arr,$colspan);
            $yearfield = $this->categorys[$cid]['yearfield'];
            if($yearfield) {
                $order = 'b.'.$yearfield.' DESC';
            }
            //($sql,$startid = 0, $pagesize = 200, $page = 0, $keyfield = ''
            $sql = "SELECT * FROM `wz_$master_table` a LEFT JOIN `wz_$attr_table` b ON a.id=b.id WHERE $where ORDER BY $order";
            $sql2 = "SELECT count(*) as num FROM `wz_$master_table` a LEFT JOIN `wz_$attr_table` b ON a.id=b.id WHERE $where";
            $result = $this->db->get_page_list($sql,$c['start'],$c['pagesize'],$c['page']);

            $number_rs  = $this->db->get_page_list_count($sql2,'');
            $this->number = $number_rs['num'];

            $this->db->pages = pages($this->number, $c['page'], $c['pagesize'],$urlrule,$rule_arr,$colspan);

        } else {
            if($c['where']) {
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
            } elseif(isset($c['typeid'])) {
                $where .= " AND `typeid`='".intval($c['typeid'])."'";
            }
            $order = isset($c['order']) ? $c['order'] : 'id DESC';

            if(LANGUAGE=='en') $master_table .= '_en';

            $result = $this->db->get_list($master_table, $where, '*', $c['start'], $c['pagesize'], $c['page'],$order,'','',$urlrule,$rule_arr,$colspan);
            $this->number = $this->db->number;
        }



        //print_r($tmp);

        if(empty($result)) {
            $GLOBALS['result_lists'] = 0;
        } else {
            if(LANGUAGE=='en') {
                foreach($result as $_key=>$_value) {
                    if(strpos($_value['url'],'://')===false) {
                        $result[$_key]['url'] = '/en'.$_value['url'];
                    }
                }
            }
        }
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
        $where = "`keyid`='content'";
        if(isset($c['siteid'])) {
            $siteid = intval($c['siteid']);
            $where .= ' AND `siteid`='.$siteid;
        } else {
            $where .= ' AND `siteid`=1';
        }
        if(isset($c['cid'])) {
            $cid = intval($c['cid']);
            $where .= ' AND `pid`='.$cid;
        }
        if(isset($c['mshow']) && $c['mshow']) {
            $where .= " AND `mshow`=1";
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
			$r = array_merge($r,$rs);
            $result[] = $r;
        }
        return $result;
    }
    public function block($c) {
        $this->childs = array();
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
            if(!empty($result)) {
                foreach ($result as $_key=>$_v) {
                    if($_v['attach']!='') {
                        $attach=unserialize($_v['attach']);
                        foreach($attach as $__key=>$__v) {
                            $result[$_key][$__key]=$__v;
                        }
                    }
                }
            }
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