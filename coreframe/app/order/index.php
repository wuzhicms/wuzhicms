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
 * 积分兑换订单处理
 */
load_class('foreground', 'member');
class index extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 积分兑换商品，每次只能兑换一个商品
     */
    public function init(){

        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $order_api = load_class('order_api',$module);
        $goods = $order_api->get();
        $quantity = intval($GLOBALS['quantity']);

        //字段中必须是point字段。
        if(!$goods || !$goods['point']) MSG('商品不存在，可能已经下架！');
        if($quantity>$goods['surplus']) {
            MSG('剩余数量不足'.$quantity.'件,请重新选择',HTTP_REFERER,3000);
        }
        $type = intval($GLOBALS['type']);
        if($type) {
            $goods['point'] = $goods['point_money'];
            if(($goods['price']*$quantity)>$memberinfo['money']) {
                set_cookie('pay_url',URL());
                MSG('您的余额不足'.$goods['price']*$quantity.'元，请先充值','index.php?m=pay&f=payment&v=pay');
            }
        } else {
            $goods['price'] = '0';
        }
        //$setting = get_cache('setting','ppc');
        $form_fields = $goods['form_fields'];
        $secret_key = md5($memberinfo['uid'].$goods['point']);
        if($memberinfo['points']<$goods['point']) MSG('您的积分不足！无法兑换该商品');

        $result = $this->db->get_list('express_address',array('uid'=>$memberinfo['uid']), '*', 0, 20,0,'addressid DESC');
        $address_result = array();
        $i = 1;
        $addressid = 0;
        foreach($result as $key=>$rs) {
            if($rs['isdefault']) {
                $address_result[0] = $rs;
                $addressid = $rs['addressid'];
            } else {
                $address_result[$i] = $rs;
            }
            $i++;
        }
        include T('order','index');
    }

    public function confirm() {
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $order_api = load_class('order_api',$module);
        $goods = $order_api->get();
        //字段中必须是point字段。
        $quantity = intval($GLOBALS['quantity']);

        if(!$goods || !$goods['point']) MSG('商品不存在，可能已经下架！');
        if($goods['surplus']<1) MSG('该商品已经兑换完了，看看其他商品吧！','/index.php?v=listing&cid=26',3000);
        if($memberinfo['points']<($goods['point']*$quantity)) MSG('您的积分不足！无法兑换该商品');

        $type = intval($GLOBALS['type']);
        if($type) {
            $goods['point'] = $goods['point_money'];
            if(($goods['price']*$quantity)>$memberinfo['money']) {
                MSG('您的余额不足'.$goods['price']*$quantity.'元，请先充值','index.php?m=pay&f=payment&v=pay');
            }
        } else {
            $goods['price'] = '0';
        }

        $secret_key = md5($memberinfo['uid'].$goods['point']);
        if($secret_key!=$GLOBALS['secret_key']) MSG('订单错误，请重新下单');
        //验证完成
        //积分扣除并记录
        $credit_api = load_class('credit_api','credit');
        $credit_api->handle($memberinfo['uid'], '-', $goods['point']*$quantity, $goods['title'],'积分兑换商品消费');
        //更新商品信息
        $order_api->surplus($goods['cid'],$goods['id'],$quantity);

        load_function('common', 'pay');
        $formdata = array();
        $formdata['username'] = remove_xss($memberinfo['username']);
        $formdata['uid'] = $memberinfo['uid'];
        $plus_minus = intval($GLOBALS['plus_minus']);
        $money = $formdata['money'] = sprintf("%.2f", substr(sprintf("%.3f", $goods['price']*$quantity), 0, -2));

        $order_no = $formdata['order_no'] = create_order_no();
        $formdata['note'] = remove_xss($GLOBALS['note']);
        $formdata['plus_minus'] = -1;
        $formdata['adminuid'] = $_SESSION['uid'];
        $formdata['addtime'] = SYS_TIME;
        $formdata['paytime'] = SYS_TIME;
        $formdata['endtime'] = SYS_TIME;
        $formdata['quantity'] = $quantity;
        $formdata['status'] = 1;
        $formdata['payment'] = 1;
        $formdata['keytype'] = 3;
        $username = get_cookie('username');
        $plus_minus_type = '扣款';
        $formdata['payname'] = '购买'.$goods['title'];
        $this->db->insert('pay', $formdata);
        $this->db->update('member', "`money`=(`money`-$money)", array('uid' => $memberinfo['uid']));

        $formdata = array();
        $formdata['remark'] = $goods['title'];
        $formdata['order_no'] = $order_no;
        $formdata['point'] = $goods['point'];
        $formdata['uid'] = $memberinfo['uid'];
        $formdata['addtime'] = SYS_TIME;
        $formdata['ip'] = get_ip();
        $formdata['status'] = 1;
        $formdata['addressid'] = intval($GLOBALS['addressid']);
        $formdata['thumb'] = $goods['thumb'];
        $formdata['url'] = $goods['url'];
        $formdata['quantity'] = $quantity;

        $orderid = $this->db->insert('order_point',$formdata);
        //if($type) {

        //}
        MSG('订单完成',WEBURL.'index.php?m=order&v=order_point_detail&orderid='.$orderid);
    }
    public function order_point_detail() {
        $memberinfo = $this->memberinfo;
        $status = array();
        $status[1] = '待发货';
        $status[2] = '已发货';
        $status[3] = '订单完成';
        if(isset($GLOBALS['order_no'])) {
            $order_no = strip_tags($GLOBALS['order_no']);
            $goods = $this->db->get_one('order_point',array('order_no'=>$order_no,'uid'=>$this->uid));
        } else {
            $orderid = intval($GLOBALS['orderid']);
            $goods = $this->db->get_one('order_point',array('orderid'=>$orderid,'uid'=>$this->uid));
        }

        $addr = $this->db->get_one('express_address',array('addressid'=>$goods['addressid']));
        $goods['address'] = $addr['province'].' '.$addr['city'].' '.$addr['address'].' '.$addr['addressee'].'（收）'.$addr['mobile'];

        include T('order','order_point_detail');
    }

    /**
     * 实物订单列表
     */
    public function listing() {
        $memberinfo = $this->memberinfo;
        $status = array();
        $status[1] = '已付款';
        $status[2] = '待付款';
        $status[3] = '已取消';

        $orderid = intval($GLOBALS['orderid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('order_goods',array('uid'=>$memberinfo['uid']), '*', 0, 10,$page,'orderid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        include T('order','listing');
    }
    /**
     * 积分换购列表
     */
    public function point_listing() {
        $memberinfo = $this->memberinfo;
        $status = array();
        $status[1] = '待发货';
        $status[2] = '已发货';
        $status[3] = '订单完成';

        $orderid = intval($GLOBALS['orderid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('order_point',array('uid'=>$memberinfo['uid']), '*', 0, 10,$page,'orderid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        include T('order','listing');
    }
}
?>