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
 * 预约管理
 */
load_class('foreground', 'member');
class order_form extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 开始预定
     */
    public function order_workflow(){

        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        //检查用户是否有可用的预约卡，如果没有则需要提醒用户需要购买。
        $r = $this->db->get_one('order_card',array('uid'=>$memberinfo['uid'],'status'=>1));
        if(!$r) MSG('您还没有购买体检套餐，无法预约');
        load_class('form');
        $result = $this->db->get_list('order_card', array('uid'=>$memberinfo['uid'],'status'=>1), '*', 0, 20,0,'cardid DESC');
        foreach($result as $key=>$rs) {
            $tr = $this->db->get_one('tuangou',array('id'=>$rs['id']));
            $result[$key]['title'] = $tr['title'];
            $result[$key]['url'] = $tr['url'];
        }
        load_function('global','order');
        if($memberinfo['birthday']!='') {
            $b_arr = explode('-',$memberinfo['birthday']);
            $birth_year = $b_arr[0];
            $birth_month = $b_arr[1];
            $birth_day = $b_arr[2];
        }
        $birthday_year = '';
        $year = date('Y');
        for($i=$year;$i>1920;$i--) {
            $selected = $birth_year==$i ? 'selected' : '';
            $birthday_year .= '<option '.$selected.'>'.$i.'</option>';
        }
        $birthday_month = '';
        for($i=1;$i<13;$i++) {
            $selected = $birth_month==$i ? 'selected' : '';
            $birthday_month .= '<option '.$selected.'>'.$i.'</option>';
        }
        $birthday_day = '';
        for($i=1;$i<32;$i++) {
            $selected = $birth_day==$i ? 'selected' : '';
            $birthday_day .= '<option '.$selected.'>'.$i.'</option>';
        }

        include T('order','order_workflow');
    }
    /**
     * 第二步
     */
    public function step2(){
        if(isset($GLOBALS['submit'])) {
            // 保存体检信息
           header("Location:index.php?m=order&f=order_form&v=step3&acbar=3&status=0");
        }
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        load_class('form');
        include T('order','step2');
    }
    public function step3(){

        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $result = $this->db->get_list('order_card', array('uid'=>$memberinfo['uid'],'status'=>1), '*', 0, 20,0,'cardid DESC');
        foreach($result as $key=>$rs) {
            $tr = $this->db->get_one('tuangou',array('id'=>$rs['id']));
            $result[$key]['title'] = $tr['title'];
        }
        load_function('global','order');
        include T('order','step3');
    }
    public function save(){

        $memberinfo = $this->memberinfo;
//orderid  city => 30 [mecid] => 2 [tjtime] => 2015-1-27
        if(isset($GLOBALS['submit'])) {
            $form_data = array();
            $form_data['cardid'] = intval($GLOBALS['cardid']);
            $mform = remove_xss($GLOBALS['mform']);
            $mform['birthday'] = $GLOBALS['birthday_year'].'-'.$GLOBALS['birthday_month'].'-'.$GLOBALS['birthday_day'];
            $this->db->update('member', $mform, array('uid' => $this->uid));


            $rs = $this->db->get_one('order_card',array('cardid'=>$form_data['cardid'],'uid'=>$memberinfo['uid']));
            if($rs['status']==2) {
                MSG('您的预约卡已使用，请勿重复提交','index.php?m=order&v=listing&acbar=3',3000);
            } elseif($rs['status']!=1) {
                MSG('您的预约卡信息有误，请核实','index.php?m=order&v=listing&acbar=3',3000);
            }

            $mecid = intval($GLOBALS['mecid']);
            $r = $this->db->get_one('mec', array('id'=>$mecid));
            $tjtime = $GLOBALS['tjtime'];

            $form_data['uid'] = $memberinfo['uid'];
            $form_data['mecid'] = $mecid;
            $form_data['tjtime'] = $tjtime;
            $form_data['addtime'] = SYS_TIME;
            $form_data['status'] = 6;//等体检中心确定套餐
            $form_data['tid'] = $rs['id'];//套餐id

            $id = $this->db->insert('order_subscribe',$form_data);
            $card_no = $rs['card_no'];
            $this->db->update('order_subscribe',array('card_no'=>$card_no),array('id'=>$id));
            //status =2 已预约
            $this->db->update('order_card',array('status'=>2),array('cardid'=>$form_data['cardid']));
            header("Location:index?m=order&f=order_form&v=subscribe&acbar=3&id=".$id);
        } else {
            MSG('未设置submit name="submit"');
        }
    }
    //预约管理
    public function subscribe() {
        $status = array();
        $status[1] = '待使用';
        $status[2] = '已到检';
        $status[3] = '已取消';
        $status[6] = '等待确定';//等体检中心确定
        $status[7] = '已点评';
        $memberinfo = $this->memberinfo;
        $result = $this->db->get_list('order_subscribe', array('uid'=>$memberinfo['uid']), '*', 0, 50,0,'id DESC');
        foreach($result as $key=>$r) {
            $rs = $this->db->get_one('order_card', array('cardid'=>$r['cardid']));
            $rs = $this->db->get_one('tuangou', array('id'=>$rs['id']));
            $result[$key]['remark'] = $rs['title'];
            $rs2 = $this->db->get_one('mec', array('id'=>$r['mecid']));
            $result[$key]['mecname'] = $rs2['title'];
            //查询有没有体检报告
            $br = $this->db->get_one('medical_record',array('card_no'=>$r['card_no']));
            //$fileurl = private_file($r['fileurl']);
            if($br) {
                $result[$key]['fileurl'] = private_file($br['fileurl']);
            }
        }
        include T('order','subscribe');
    }
    //取消预定
    public function cancel() {
        $memberinfo = $this->memberinfo;
        $id = intval($GLOBALS['id']);
        $this->db->update('order_subscribe',array('status'=>3),array('id'=>$id,'uid'=>$memberinfo['uid']));
        $r = $this->db->get_one('order_subscribe',array('id'=>$id,'uid'=>$memberinfo['uid']));
        $this->db->update('order_card',array('status'=>1),array('cardid'=>$r['cardid']));

        MSG("预约取消成功，欢迎再次预约",'?m=order&f=order_form&v=subscribe&acbar=3',3000);

    }
}
?>