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
 * 实物订单处理
 */
load_class('foreground', 'member');
class order_goods extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    /**
     * 添加到购物车
     */
    public function addto(){

        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        //检查是否验证过手机 ischeck_mobile
        //if($memberinfo['ischeck_mobile']==0) {
          //  MSG('您的手机还未验证，请先验证手机！',WEBURL.'index.php?m=member&f=index&v=edit_mobile');
        //}
        $order_api = load_class('order_api',$module);
        $goods = $order_api->get();

        //字段中必须是price字段。
        if(!$goods || !$goods['price']) MSG('商品不存在，可能已经下架！');
        if($goods['surplus']<1) MSG('商品库存不足！');
        //$setting = get_cache('setting','ppc');
        $form_fields = $goods['form_fields'];
        $secret_key = md5($memberinfo['uid'].$goods['price']);
        //将内容添加到购物车中，如果存在，则将更新时间改为最新，查询时，按照更新时间排序
        $keyid = $goods['keyid'];
        $r = $this->db->get_one('order_cart', array('keyid' => $keyid,'uid'=>$uid));
        $quantity_arr = array(1=>10,2=>20,3=>50,4=>100);
        $quantity_type = intval($GLOBALS['quantity_type']);
        $quantity_type = max($quantity_type,1);
        $quantity = $quantity_arr[$quantity_type];
        if($goods['type']==1) $quantity = 1;
        if($r) {
            $this->db->update('order_cart', array('updatetime'=>SYS_TIME,'quantity'=>$quantity), array('cartid' => $r['cartid']));
        } else {


            $formdata = array();
            $formdata['keyid'] = $keyid;
            $formdata['uid'] = $this->uid;
            $formdata['remark'] = $goods['title'];
            $formdata['updatetime'] = SYS_TIME;
            $formdata['quantity'] = $quantity;
            $formdata['url'] = $quantity;
            $this->db->insert('order_cart', $formdata);
        }
        if(isset($GLOBALS['isjs'])) {
            exit('1');
        }
        //查询购物车中的商品
        $result_rs = $this->db->get_list('order_cart', array('uid'=>$this->uid), '*', 0, 20, 0, 'updatetime DESC');
        $result = array();
        $total_price = 0;
        foreach($result_rs as $r) {
            $goods = $order_api->get($r['keyid']);
            $quantity = $r['quantity'];
            if($quantity<20) {
                $price = $goods['price'];
                $price_old = $goods['price_old'];
            } elseif($quantity>19 && $quantity<50) {
                $price = $goods['price2'];
                $price_old = $goods['price_old2'];
            } elseif($quantity>49 && $quantity<100) {
                $price = $goods['price3'];
                $price_old = $goods['price_old3'];
            } else {
                $price = $goods['price4'];
                $price_old = $goods['price_old4'];
            }

            $goods['price'] = $r['price'] = $price;
            $goods['price_old'] = $r['price_old'] = $price_old;

            $r['goods_detail'] = $goods;
            $r['jr_price'] = sprintf("%.2f",($goods['price_old']-$goods['price'])*$r['quantity']);
            $r['min_quantity'] = $goods['type']=='2' ? 10 : 1;
            $r['max_quantity'] = $goods['surplus'] ? $goods['surplus'] : 999;
            $total_price += $goods['price']*$r['quantity'];
            $result[] = $r;
        }
        $total_price = sprintf("%.2f",$total_price);
        $number = count($result);
        $categorys = get_cache('category','content');
        include T('order','addto');
    }

    /**
     * 购物车
     */
    public function cart() {
        $categorys = get_cache('category','content');
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $order_api = load_class('order_api',$module);
        //查询购物车中的商品
        $result_rs = $this->db->get_list('order_cart', array('uid'=>$this->uid), '*', 0, 20, 0, 'updatetime DESC');
        $result = array();
        $total_price = 0;
        foreach($result_rs as $r) {
            $goods = $order_api->get($r['keyid']);
            $quantity = $r['quantity'];
            if($goods['type']==1) {
                $price = $goods['price'];
                $price_old = $goods['price_old'];
            } else {
                if($quantity<20) {
                    $price = $goods['price'];
                    $price_old = $goods['price_old'];
                } elseif($quantity>19 && $quantity<50) {
                    $price = $goods['price2'];
                    $price_old = $goods['price_old2'];
                } elseif($quantity>49 && $quantity<100) {
                    $price = $goods['price3'];
                    $price_old = $goods['price_old3'];
                } else {
                    $price = $goods['price4'];
                    $price_old = $goods['price_old4'];
                }
            }

            $goods['price'] = $r['price'] = $price;
            $goods['price_old'] = $r['price_old'] = $price_old;
            $r['goods_detail'] = $goods;
            $r['jr_price'] = sprintf("%.2f",$goods['price_old']-$goods['price']);
            $r['min_quantity'] = $goods['type']=='2' ? 10 : 1;
            $total_price += $price*$r['quantity'];
            $result[] = $r;
        }
        $total_price = sprintf("%.2f",$total_price);
        $number = count($result);
        include T('order','addto');
    }

    /**
     * 计算价格
     */
    public function count_price() {
        if(empty($GLOBALS['cartids'])) {
            $return = array('total_price'=>'0');
            echo json_encode($return);
        } else {
            $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
            $memberinfo = $this->memberinfo;
            $order_api = load_class('order_api',$module);

            $ids = implode(',',$GLOBALS['cartids']);
            //查询购物车中的商品
            $where = "`uid`=".$this->uid." AND `cartid` IN ($ids)";
            $result_rs = $this->db->get_list('order_cart', $where, '*', 0, 20, 0, 'updatetime DESC');
            $result = array();
            $total_price = 0;
            foreach($result_rs as $key=>$r) {
                $goods = $order_api->get($r['keyid']);

                $quantity = $GLOBALS['quantity'][$key];
                if($goods['type']==1) {
                    $price = $goods['price'];
                    $price_old = $goods['price_old'];
                } else {
                    if($quantity<20) {
                        $price = $goods['price'];
                        $price_old = $goods['price_old'];
                    } elseif($quantity>19 && $quantity<50) {
                        $price = $goods['price2'];
                        $price_old = $goods['price_old2'];
                    } elseif($quantity>49 && $quantity<100) {
                        $price = $goods['price3'];
                        $price_old = $goods['price_old3'];
                    } else {
                        $price = $goods['price4'];
                        $price_old = $goods['price_old4'];
                    }
                }

                $r['price'] = $price;
                $r['price_old'] = $price_old;
                $r['jr_price'] = ($price_old-$price)*$quantity;
                $r['point'] = intval($price/2);

                $total_price += $price*$quantity;
                $result[$r['cartid']] = $r;
            }
            $return = array('total_price'=>$total_price,'result'=>$result);
            echo json_encode($return);
        }
    }
    /**
     * 删除购物车内容
     */
    public function del(){
        $id = intval($GLOBALS['id']);
        $this->db->delete('order_cart',array('cartid'=>$id,'uid'=>$this->uid));
        MSG('已移除选择','?m=order&f=order_goods&v=cart');
    }
    /**
     * 清空购物车
     */
    public function delete(){
        $this->db->delete('order_cart',array('uid'=>$this->uid));
        MSG('购物车已清空',WEBURL);
    }
    /**
     *
     */
    public function index(){
        if(empty($GLOBALS['cartids'])) {
            MSG('参数不正确');
        }
        //验证邮件，手机是否通过验证
        $memberinfo = $this->memberinfo;
        if($memberinfo['ischeck_mobile']==0) {
            MSG('您的手机还未验证！请先验证！','index.php?m=member&f=index&v=edit_mobile&buyer=1',3000);
        }
        if($memberinfo['ischeck_email']==0) {
            MSG('您的邮箱还未验证！请先验证！','index.php?m=member&f=index&v=edit_email&buyer=1',3000);
        }
        $categorys = get_cache('category','content');
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';

        $order_api = load_class('order_api',$module);

        $ids = implode(',',$GLOBALS['cartids']);

        //查询购物车中的商品
        $where = "`uid`=".$this->uid." AND `cartid` IN ($ids)";
        $result_rs = $this->db->get_list('order_cart', $where, '*', 0, 20, 0, 'updatetime DESC');
        $goods_result = array();
        $total_price = 0;
        $goods_ids = array();
        foreach($result_rs as $key=>$r) {
            $goods = $order_api->get($r['keyid']);
            $goods_ids[] = $goods['id'];
            $quantity = $GLOBALS['quantity'][$r['cartid']];
            if($goods['type']==1) {
                $price = $goods['price'];
                $price_old = $goods['price_old'];
            } else {
                if($quantity<20) {
                    $price = $goods['price'];
                    $price_old = $goods['price_old'];
                } elseif($quantity>19 && $quantity<50) {
                    $price = $goods['price2'];
                    $price_old = $goods['price_old2'];
                } elseif($quantity>49 && $quantity<100) {
                    $price = $goods['price3'];
                    $price_old = $goods['price_old3'];
                } else {
                    $price = $goods['price4'];
                    $price_old = $goods['price_old4'];
                }
            }
            $r['price'] = $price;
            $r['quantity'] = $quantity;
            $r['url'] = $goods['url'];
            $r['thumb'] = $goods['thumb'];
            $r['title'] = $goods['title'];
            $r['price_old'] = $price_old;
            $r['jr_price'] = sprintf("%.2f",($price_old-$price)*$quantity);
            $r['count_price'] = sprintf("%.2f",$price*$quantity);
            $r['point'] = intval($price/2);

            $total_price += $price*$quantity;
            $goods_result[$r['cartid']] = $r;
        }
        $point = intval($total_price/2);
        $total_price = sprintf("%.2f",$total_price);



        $result = $this->db->get_list('express_address',array('uid'=>$memberinfo['uid']), '*', 0, 20,0,'addressid DESC');
        $address_result = array();
        $i = 1;
        $addressid = 0;
        if($result) {
            foreach($result as $key=>$rs) {
                if($rs['isdefault']) {
                    $address_result[0] = $rs;
                    $addressid = $rs['addressid'];
                } else {
                    $address_result[$i] = $rs;
                }
                $i++;
            }
            if($addressid==0) {
                $addressid = $result[0]['addressid'];
            }
        }

        //列出未使用的，可以用的优惠券
        $goods_ids = implode(',',$goods_ids);
        $endtime = SYS_TIME;
        $uid = $memberinfo['uid'];
        if($goods_ids) {
            $where = "`uid`='$uid' AND `status`=0 AND `endtime`>$endtime AND id IN($goods_ids)";
            $cards_result = $this->db->get_list('coupon_card_active',$where, '*', 0, 50,0,'aid DESC');
        } else {
            $cards_result = array();
        }
        include T('order','goods_index');
    }

    public function confirm() {
        $categorys = get_cache('category','content');
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $uid = $this->memberinfo['uid'];
        $order_api = load_class('order_api',$module);

        $ids = implode(',',$GLOBALS['cartids']);

        //查询购物车中的商品
        $where = "`uid`=".$this->uid." AND `cartid` IN ($ids)";
        $result_rs = $this->db->get_list('order_cart', $where, '*', 0, 20, 0, 'updatetime DESC');
        $goods_result = array();
        $total_price = 0;

        foreach($result_rs as $key=>$r) {
            $goods = $order_api->get($r['keyid']);
            $quantity = $GLOBALS['quantity'][$r['cartid']];
            if($goods['type']==1) {
                $price = $goods['price'];
                $price_old = $goods['price_old'];
            } else {
                if($quantity<20) {
                    $price = $goods['price'];
                    $price_old = $goods['price_old'];
                } elseif($quantity>19 && $quantity<50) {
                    $price = $goods['price2'];
                    $price_old = $goods['price_old2'];
                } elseif($quantity>49 && $quantity<100) {
                    $price = $goods['price3'];
                    $price_old = $goods['price_old3'];
                } else {
                    $price = $goods['price4'];
                    $price_old = $goods['price_old4'];
                }
            }
            $r['price'] = $price;
            $r['quantity'] = $quantity;
            $r['url'] = $goods['url'];
            $r['id'] = $goods['id'];
            $r['thumb'] = $goods['thumb'];
            $r['title'] = $goods['title'];
            $r['price_old'] = $price_old;
            $r['jr_price'] = ($price_old-$price)*$quantity;
            $r['count_price'] = $price*$quantity;
            $r['point'] = intval($price/2);

            $total_price += $price*$quantity;
            $goods_result[$r['cartid']] = $r;
        }


        if(empty($goods_result)) MSG('购买出现问题，请重新购买！',WEBURL);
        $usepoint = 0;
        if(isset($GLOBALS['check_use'])) {
            $usepoint = intval($GLOBALS['usepoint']);
            $total_price = $total_price-$usepoint/100;
        }
        if($total_price<0) {
            MSG('支付金额不能少于0.01元！');
        }
        //优惠券
        $coupon_card = intval($GLOBALS['coupon_card']);

        //验证完成
        $ip = get_ip();
        $total_goods = count($goods_result);
        $order_no = date('YmdH').rand(100,999).date('is');
        $mynote = remove_xss($GLOBALS['mynote']);
        $addressid = intval($GLOBALS['addressid']);
        foreach($goods_result as $key=>$goods) {
            //插入订单数据
            $formdata = array();
            $coupon_card_r = '';
            if($coupon_card) {
                $coupon_card_r = $this->db->get_one('coupon_card_active', array('aid' => $coupon_card,'uid'=>$uid,'status'=>0));
                if($coupon_card_r && $coupon_card_r['endtime']>SYS_TIME) {
                    $formdata['coupon_card'] = $coupon_card_r['mount'];
                    $this->db->update('coupon_card_active', array('status'=>1), array('aid' => $coupon_card,'uid'=>$uid));
                    $this->db->update('coupon_card', array('status'=>3), array('cardid' => $coupon_card_r['cardid'],'status'=>2));
                    $total_price = $total_price-$coupon_card_r['mount'];
                }
            }
            $formdata['remark'] = $goods['title'];
            $formdata['money'] = $goods['price'];
            $formdata['id'] = $goods['id'];
            $formdata['uid'] = $memberinfo['uid'];
            $formdata['addtime'] = SYS_TIME;
            $formdata['ip'] = $ip;
            $formdata['status'] = 2;
            $formdata['quantity'] = $goods['quantity'];
            $formdata['addressid'] = $addressid;
            $formdata['thumb'] = $goods['thumb'];
            $formdata['point'] = $goods['point'];
            $formdata['url'] = $goods['url'];
            $formdata['note'] = $mynote;
            if($key==0) $formdata['usepoint'] = $usepoint;
            $formdata['order_no'] = $order_no;
            $formdata['cardtype'] = intval($GLOBALS['cardtype']);

            $orderids[] = $this->db->insert('order_goods',$formdata);
            //TODO
            $this->db->delete('order_cart',array('cartid'=>$goods['cartid'],'uid'=>$this->uid));
        }
        if($total_price<0) {
            $total_price = '0.01';
        }

/*
        //赠送积分
        $credit_api = load_class('credit_api','credit');
        $credit_api->handle($memberinfo['uid'], '+', $goods['point'], $goods['title'],'购买商品赠送积分');
*/
        //MSG('订单完成,',WEBURL.'index.php?m=order&&f=order_goods&v=pay');
        load_function('common','pay');
        load_function('preg_check');
        $memberinfo = $this->memberinfo;

        $pay_r = $this->db->get_one('payment',array('id'=>2,'status'=>1));
        if(!$pay_r) MSG('支付方式错误');

        $formdata = array();
        $formdata['email'] = $memberinfo['email'];
        $formdata['username'] = $memberinfo['username'];
        $formdata['uid'] = $memberinfo['uid'];
        $formdata['money'] = sprintf("%.2f",$total_price);
        $formdata['order_no'] = $order_no;
        $formdata['remark'] = $mynote;

        $formdata['plus_minus'] = 1;
        $formdata['addtime'] = SYS_TIME;
        $formdata['quantity'] = 1;
        $formdata['status'] = 6;
        $formdata['payment'] = 2;

        $formdata['payname'] = '合一体检套餐';
        $id = $this->db->insert('pay',$formdata);
        $setting = unserialize($pay_r['setting']);
        $address = $this->db->get_one('express_address', array('addressid' => $addressid,'uid'=>$this->uid));
        $_pay = load_class($pay_r['classname'],'pay',$setting);

        $parameter = array(
            "service_type"	=> $setting['service_type'],
            "payment_type"	=> 1,//支付类型
            "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment=2&module=order&file=pay_callback',//同步通知地址
            "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment=2&module=order&file=pay_callback',//同步通知地址
            "email"	=> $formdata['email'],
            "order_no"	=> $formdata['order_no'],
            "payname"	=> $formdata['payname'],
            "total_fee"	=> $total_price,
            "remark"	=> $formdata['remark'],
            "url"	=> WEBURL,
            //-------
            "price"	=> $total_price,
            "quantity"	=> 1,
            "logistics_fee"	=> '0.00',
            "logistics_type"	=> 'EXPRESS',
            "logistics_payment"	=> 'SELLER_PAY',
            "receive_name"	=> $address['addressee'],
            "receive_address"	=> $address['province'].$address['city'].$address['area'].$address['address'],
            "receive_zip"	=> $address['zipcode'],
            "receive_phone"	=> $address['tel'],
            "receive_mobile"	=> $address['mobile'],
        );

        $pay_link = $_pay->build_form($parameter,"get", "确认无误，前往支付页面",0,'target="_blank"');
//删除 购物车
        $where = "`uid`=".$this->uid." AND `cartid` IN ($ids)";
        $this->db->delete('order_cart', $where);
        include T('order','goods_pay');
    }

    /**
     * 会员中心付款
     */
    public function repay() {
        $categorys = get_cache('category','content');
        $module = isset($GLOBALS['module']) ? $GLOBALS['module'] : 'content';
        $memberinfo = $this->memberinfo;
        $order_api = load_class('order_api',$module);


        $order_no = sql_replace($GLOBALS['order_no']);
        //查询购物车中的商品
        $where = "`uid`=".$this->uid." AND `order_no`='$order_no'";
        $result = $this->db->get_list('order_goods', $where, '*', 0, 20, 0);
        $total_price = 0;
        $addressid = 0;
        foreach($result as $r) {
            $total_price += $r['money']*$r['quantity']-$r['coupon_card'];
            $addressid = $r['addressid'];
        }

        $total_price = sprintf("%.2f",$total_price);

        $address = $this->db->get_one('express_address', array('addressid' => $addressid,'uid'=>$this->uid));
        load_function('common','pay');
        load_function('preg_check');

        $pay_r = $this->db->get_one('payment',array('id'=>2,'status'=>1));
        if(!$pay_r) MSG('支付方式错误');

        $setting = unserialize($pay_r['setting']);

        $_pay = load_class($pay_r['classname'],'pay',$setting);

        $parameter = array(
            "service_type"	=> $setting['service_type'],
            "payment_type"	=> 1,//支付类型
            "notify_url"	=> WEBURL.'index.php?m=pay&f=callback&v=async_notify&payment=2&module=order&file=pay_callback',//同步通知地址
            "return_url"	=> WEBURL.'index.php?m=pay&f=callback&v=sync_notify&payment=2&module=order&file=pay_callback',//同步通知地址
            "email"	=> $memberinfo['email'],
            "order_no"	=> $order_no,
            "payname"	=> '合一体检套餐',
            "total_fee"	=> $total_price,
            "remark"	=> $order_no,
            "url"	=> WEBURL,
            //-------
            "price"	=> $total_price,
            "quantity"	=> 1,
            "logistics_fee"	=> '0.00',
            "logistics_type"	=> 'EXPRESS',
            "logistics_payment"	=> 'SELLER_PAY',
            "receive_name"	=> $address['addressee'],
            "receive_address"	=> $address['province'].$address['city'].$address['area'].$address['address'],
            "receive_zip"	=> $address['zipcode'],
            "receive_phone"	=> $address['tel'],
            "receive_mobile"	=> $address['mobile'],
        );

        $html_text = $_pay->build_form($parameter,"get", "正在跳转至支付平台...");
        echo $html_text;
    }

    public function listing() {
        $memberinfo = $this->memberinfo;
        $uid = $memberinfo['uid'];
        $status = intval($GLOBALS['status']);
        $status_arr = array();
        $status_arr[1] = '已付款（待预约）';
        $status_arr[2] = '待付款';
        $status_arr[3] = '交易取消';
        $status_arr[5] = '已付款（已预约）';
        $status_arr[6] = '已发货';


        $orderid = intval($GLOBALS['orderid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $express = get_cache('express','order');
        $result = $result2 = $result3 = $result4 = array();
        $result_r = $this->db->get_list('order_goods',array('uid'=>$uid), '*', 0, 10,$page,'orderid DESC','order_no');
        foreach($result_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']-$rs['coupon_card']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result[] = $r;
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        load_function('global','order');

        $result2_r = $this->db->get_list('order_goods',"`uid`='$uid' AND `status` IN(1,5)", '*', 0, 30,0,'orderid DESC','order_no');
        foreach($result2_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']-$rs['coupon_card']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result2[] = $r;
        }
        $result3_r = $this->db->get_list('order_goods',"`uid`='$uid' AND `status`=2", '*', 0, 30,0,'orderid DESC','order_no');
        foreach($result3_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']-$rs['coupon_card']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result3[] = $r;
        }
        $result4_r = $this->db->get_list('order_goods',"`uid`='$uid' AND `status`=3", '*', 0, 30,0,'orderid DESC','order_no');
        foreach($result4_r as $r) {
            $r['goodlist'] = $this->db->get_list('order_goods',array('order_no'=>$r['order_no']));
            $total_money = 0;
            foreach($r['goodlist'] as $rs) {
                $total_money = $total_money+sprintf("%.2f",$rs['money']*$rs['quantity']-$rs['coupon_card']);
            }
            $r['money'] = sprintf("%.2f",$total_money);
            $result4[] = $r;
        }
        include T('order','goods_listing');
    }

    /**
     * 取消订单
     */
    public function cancel() {
        if(empty($GLOBALS['order_no'])) MSG('参数错误');
        $order_no = sql_replace($GLOBALS['order_no']);
        $this->db->update('order_goods', array('status'=>3), array('uid'=>$this->uid,'order_no' => $order_no));
        MSG('订单取消成功！',HTTP_REFERER);
    }
}
?>