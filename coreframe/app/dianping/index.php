<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

load_function('content','content');
/**
 * 点评
 */
load_class('foreground', 'member');
class index extends WUZHI_foreground {
	function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
	}
    /**
     * 点评页面
     */
    public function comment() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        if(!isset($GLOBALS['keyid']) || empty($GLOBALS['keyid'])) MSG('keyid参数错误');
        $keyid = $GLOBALS['keyid'];
        if(!preg_match('/^([a-z]{1,}[a-z0-9]+)/',$keyid)) MSG('keyid参数错误');
        if(isset($GLOBALS['submit'])) {
            $r = $this->db->get_one('dianping', array('keyid' => $keyid,'uid'=>$memberinfo['uid']));
            if($r) MSG('您已经点评过当前信息，感谢您的参与！',HTTP_REFERER,2500);
            $formdata = array();
            $fields = array_keys($GLOBALS['form']);
            foreach($fields as $_fields) {
                if(!in_array($_fields,array('field1','field2','field3','field4','field5','field6','data'))) MSG('参数错误');
            }
            
            $formdata = remove_xss($GLOBALS['form']);
            $formdata['field4'] = min($formdata['field4'],10000);
            $formdata['keyid'] = $keyid;
            $formdata['uid'] = $memberinfo['uid'];
            $formdata['ip'] = get_ip();
            $formdata['addtime'] = SYS_TIME;

            $data = $GLOBALS['form']['data'];
            //print_r($formdata);exit;
            //print_r($data);
            //exit;
           // $data = explode(",",$data);
            if(!empty($data)) {
                $data_arr = array();
                foreach($data as $rs) {
                    $data_arr[] = $rs['url'];
                }
                $data_arr = implode("\r\n",$data_arr);
                $formdata['data'] = $data_arr;
            }
            //赠送积分,TODO 点评配置
            $this->db->insert('dianping',$formdata);
            //@h1jk 私有
            //$where = "`avg_price ,avg_total,avg_env,avg_service,hits";
            $query = $this->db->query("SELECT COUNT(*) as hits,SUM(field1) as field1,SUM(field2) as field2,SUM(field3) as field3,SUM(field4) as field4 FROM wz_dianping");
            $statics = $this->db->fetch_array($query);
/*
 *
Array
(
    [hits] => 37
    [field1] => 158
    [field2] => 131
    [field3] => 113
    [field4] => 48972
)

 */

            $id = substr($keyid,3);
            $formdata = array();
            $formdata['avg_price'] = $statics['field4']/$statics['hits'];
            $formdata['avg_total'] = sprintf("%.1f",$statics['field1']/$statics['hits']);
            $formdata['avg_env'] = sprintf("%.1f",$statics['field2']/$statics['hits']);
            $formdata['avg_service'] = sprintf("%.1f",$statics['field3']/$statics['hits']);
            $formdata['hits'] = $statics['hits'];
            //print_r($formdata);exit;
            $this->db->update('mec', $formdata, array('id' => $id));

            MSG('感谢您的点评',HTTP_REFERER);
        } else {
            $categorys = get_cache('category','content');
            $key = substr($keyid,0,3);
            $id = substr($keyid,3);
            $dianping_api = load_class($key.'_api','dianping');
            $data = $dianping_api->get($id);

            include T('dianping','comment');
        }
    }

    /**
     * 我的点评
     */
    public function mydianping() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $memberinfo = $this->memberinfo;
        $uid = $this->memberinfo['uid'];
        $result = $this->db->get_list('dianping', "`uid`='$uid' AND `keyid` LIKE 'mec%'", '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        load_function('global','dianping');
        include T('dianping','mydianping');
    }
    public function delete() {
        $id = intval($GLOBALS['id']);
        $this->db->delete('dianping',array('id'=>$id));
        MSG('删除成功',HTTP_REFERER,3000);

    }

    /**
     * 点评页面
     */
    public function dianping() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        if(!isset($GLOBALS['keyid']) || empty($GLOBALS['keyid'])) MSG('keyid参数错误');
        $keyid = $GLOBALS['keyid'];
        if(!preg_match('/^([a-z]{1,}[a-z0-9]+)/',$keyid)) MSG('keyid参数错误');
        if(isset($GLOBALS['submit'])) {
            $r = $this->db->get_one('dianping', array('keyid' => $keyid,'uid'=>$memberinfo['uid']));
            if($r) MSG('您已经点评过当前信息，感谢您的参与！',HTTP_REFERER,2500);
            $formdata = array();
            $fields = array_keys($GLOBALS['form']);
            foreach($fields as $_fields) {
                if(!in_array($_fields,array('field1','field2','field3','field4','field5','field6','data'))) MSG('参数错误');
            }

            $formdata = remove_xss($GLOBALS['form']);
            $formdata['field4'] = min($formdata['field4'],10000);
            $formdata['keyid'] = $keyid;
            $formdata['uid'] = $memberinfo['uid'];
            $formdata['ip'] = get_ip();
            $formdata['addtime'] = SYS_TIME;

            $data = $GLOBALS['form']['data'];
            //print_r($formdata);exit;
            //print_r($data);
            //exit;
            // $data = explode(",",$data);
            if(!empty($data)) {
                $data_arr = array();
                foreach($data as $rs) {
                    $data_arr[] = $rs['url'];
                }
                $data_arr = implode("\r\n",$data_arr);
                $formdata['data'] = $data_arr;
            }
            //赠送积分,TODO 点评配置
            $this->db->insert('dianping',$formdata);
            //@h1jk 私有
            //$where = "`avg_price ,avg_total,avg_env,avg_service,hits";
            $query = $this->db->query("SELECT COUNT(*) as hits,SUM(field1) as field1,SUM(field2) as field2,SUM(field3) as field3,SUM(field4) as field4 FROM wz_dianping");
            $statics = $this->db->fetch_array($query);
            /*
             *
            Array
            (
                [hits] => 37
                [field1] => 158
                [field2] => 131
                [field3] => 113
                [field4] => 48972
            )

             */


            $id = substr($keyid,2);
            $formdata = array();
            $formdata['avg_price'] = $statics['field4']/$statics['hits'];
            $formdata['avg_total'] = sprintf("%.1f",$statics['field1']/$statics['hits']);
            $formdata['avg_env'] = sprintf("%.1f",$statics['field2']/$statics['hits']);
            $formdata['avg_service'] = sprintf("%.1f",$statics['field3']/$statics['hits']);
            $formdata['hits'] = $statics['hits'];
            $query = $this->db->query("SHOW COLUMNS FROM wz_tuangou");
            while($r = $this->db->fetch_array($query)) {
                $fields[] = $r['Field'];
            }
            $new_formdata = array();
            foreach($formdata as $key=>$value) {
                if(in_array($key,$fields)) {
                    $new_formdata[$key] = $value;
                }
            }
            $this->db->update('tuangou', $new_formdata, array('id' => $id));
            $orderid = intval($GLOBALS['orderid']);
            $this->db->update('order_subscribe', array('status'=>7), array('id' => $orderid,'uid'=>$uid));

            MSG('感谢您的点评',HTTP_REFERER);
        } else {
            $categorys = get_cache('category','content');
            $key = substr($keyid,0,2);
            $id = substr($keyid,2);
            $dianping_api = load_class($key.'_api','dianping');
            $data = $dianping_api->get($id);

            include T('dianping','comment_'.$key);
        }
    }
}