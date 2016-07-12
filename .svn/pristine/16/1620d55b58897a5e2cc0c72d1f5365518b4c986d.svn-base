<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 抢拍名单
 */
load_class('admin');
class qiangpai extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $id = intval($GLOBALS['id']);
        $data_r = $this->db->get_one('qiangpai', array('id' => $id));
        $cid = intval($GLOBALS['cid']);
        $where = '';
        if($id) {
            $where = "status=1 AND `keytype`=8 AND `original_id`='$id'";
        } else {
            $where = '';
        }
        $result = $this->db->get_list('pay', $where, '*', 0, 20,$page,'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('qiangpai_listing');
    }
    /**
     * set_winner
     */
    public function set_winner(){
        $id = intval($GLOBALS['id']);
        $payid = intval($GLOBALS['payid']);
        $cid = intval($GLOBALS['cid']);
        $r = $this->db->get_one('pay', array('id' => $payid));
        $formdata = array();
        $formdata['payid'] = $r['id'];
        $formdata['username'] = $r['username'];
        $formdata['id'] = $r['original_id'];
        $formdata['mobile'] = $r['telephone'];
        $this->db->insert('qiangpai_winner', $formdata);

        MSG('设置成功','?m=order&f=qiangpai&v=listing&id='.$id.'&cid='.$cid.$this->su());
    }
    //发布中奖结果
    public function publish() {
        $id = intval($GLOBALS['id']);
        $payid = intval($GLOBALS['payid']);
        $cid = intval($GLOBALS['cid']);
        $wr = $this->db->get_one('qiangpai_winner', array('id'=>$id));
        if(!$wr) MSG('请先设置中奖人');
        $this->db->update('qiangpai', array('cron_status'=>2), array('id' => $id));
        MSG('中奖结果已发布!','?m=order&f=qiangpai&v=listing&id='.$id.'&cid='.$cid.'&payid='.$payid.$this->su());
    }
    public function delete_winner(){
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        $winnerid = intval($GLOBALS['winnerid']);

        $this->db->delete('qiangpai_winner', array('winnerid'=>$winnerid));

        MSG('奖励删除成功','?m=order&f=qiangpai&v=listing&id='.$id.'&cid='.$cid.$this->su());
    }

}