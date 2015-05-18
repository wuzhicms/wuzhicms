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
        //字段中必须是point字段。
        if(!$goods || !$goods['point']) MSG('商品不存在，可能已经下架！');
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
        if(!$goods || !$goods['point']) MSG('商品不存在，可能已经下架！');
        if($goods['surplus']<1) MSG('该商品已经兑换完了，看看其他商品吧！','/list-79/',3000);
        if($memberinfo['points']<$goods['point']) MSG('您的积分不足！无法兑换该商品');
        $secret_key = md5($memberinfo['uid'].$goods['point']);
        if($secret_key!=$GLOBALS['secret_key']) MSG('订单错误，请重新下单');
        //验证完成
        //积分扣除并记录
        $credit_api = load_class('credit_api','credit');
        $credit_api->handle($memberinfo['uid'], '-', $goods['point'], $goods['title'],'积分兑换商品消费');
        //更新商品信息
        $order_api->surplus($goods['cid'],$goods['id']);

        $formdata = array();
        $formdata['remark'] = $goods['title'];
        $formdata['point'] = $goods['point'];
        $formdata['uid'] = $memberinfo['uid'];
        $formdata['addtime'] = SYS_TIME;
        $formdata['ip'] = get_ip();
        $formdata['status'] = 1;
        $formdata['addressid'] = intval($GLOBALS['addressid']);
        $formdata['thumb'] = $goods['thumb'];
        $formdata['url'] = $goods['url'];

        $orderid = $this->db->insert('order_point',$formdata);
        MSG('订单完成',WEBURL.'index.php?m=order&v=order_point_detail&orderid='.$orderid);
    }
    public function order_point_detail() {
        $memberinfo = $this->memberinfo;
        $status = array();
        $status[1] = '待发货';
        $status[2] = '已发货';
        $status[3] = '订单完成';

        $orderid = intval($GLOBALS['orderid']);
        $goods = $this->db->get_one('order_point',array('orderid'=>$orderid));
        $goods['address'] = '收件人地址';

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