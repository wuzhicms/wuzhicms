<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 积分操作类
 * 积分获取，消费
 */
class WUZHI_credit_api {
    public function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 积分操作类
     *
     * @param $uid 用户id
     * @param $method , + , -
     * @param $point 积分数，正整数
     * @param $remark 简单描述
     * @param string $note 详情备注
     */
    public function handle($uid, $method,$point, $remark,$note = '',$keyid = '',$cid = 0) {
        $point = intval($point);
        if($point<0) {
            return false;
        } elseif($point==0) {
            return true;
        }
        if($method=='+') {
            $this->db->update('member', "`points`=(`points`+$point)",array('uid'=>$uid));
            $j_type = 1;
        } elseif($method=='-') {
            $this->db->update('member', "`points`=(`points`-$point)",array('uid'=>$uid));
            $j_type = 2;
        } else {
            return false;
        }
        $jid = $this->db->insert('credit',array('uid'=>$uid,'remark'=>$remark,'j_type'=>$j_type,'point'=>$point,'addtime'=>SYS_TIME,'keyid'=>$keyid,'cid'=>$cid));
        $this->db->insert('credit_data',array('jid'=>$jid,'content'=>$note));
        return $jid;
    }

    /**
     * 根据keyid获取记录
     * @param $keyid
     * @return mixed
     */
    public function get($keyid,$addtime = 0) {
        if($addtime) {
            $r = $this->db->get_one('credit', "`keyid`='$keyid' AND `addtime`='$addtime'");
        } else {
            $r = $this->db->get_one('credit', array('keyid' => $keyid));
        }
        return $r;
    }

	/**
	 * @param $uid
	 * @param $method
	 * @param $point
	 * @param $remark
	 * @param string $note
	 * @param string $keyid
	 */
    public function set_credit($action,$uid,$cid = 0,$id = 0, $note = '') {
		$setting = $this->db->get_one('credit_set', array('action' => $action,'cid'=>$cid));
		if(!$setting) {
			$cate = $this->db->get_one('category', array('cid' => $cid));
			$setting = $this->db->get_one('credit_set', array('action' => $action,'cid'=>$cate['pid']));
			if(!$setting) return '';
		}
		$keyid = $id;
		//限制时间 一天时间
		$starttime = SYS_TIME-86400;
		$total = $this->db->count_result('credit',"`keyid`='$keyid' AND `cid`='$cid' AND `addtime`>$starttime");
		if($total>=$setting['quantity']) {
			return '';
		}
		if($setting['type']==1) {
			$method = '+';
		} else {
			$method = '+';
		}
		$point = $setting['point'];
		$remark = $setting['name'];

		$this->handle($uid, $method,$point, $remark,$note,$keyid,$cid);
	}
}