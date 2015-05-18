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
 * 收货地址管理
 */
load_class('foreground', 'member');
class address extends WUZHI_foreground{
    function __construct() {
        $this->member = load_class('member', 'member');
        load_function('common', 'member');
        $this->member_setting = get_cache('setting', 'member');
        parent::__construct();
    }

    public function listing() {
        $memberinfo = $this->memberinfo;

        $result = $this->db->get_list('express_address',array('uid'=>$memberinfo['uid']), '*', 0, 100,0,'addressid DESC');

        $forward = intval($GLOBALS['forward']);
        include T('order','address_listing');
    }
    public function setdefault() {
        $addressid = intval($GLOBALS['addressid']);
        $memberinfo = $this->memberinfo;
        $this->db->update('express_address',array('isdefault'=>0),array('uid'=>$memberinfo['uid']));
        $this->db->update('express_address',array('isdefault'=>1),array('addressid'=>$addressid));
        MSG('默认地址设置成功','index.php?m=order&f=address&v=listing');
    }
    public function add() {
        $memberinfo = $this->memberinfo;
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['addressee'] = remove_xss($GLOBALS['addressee']);
            $formdata['address'] = remove_xss($GLOBALS['address']);
            $formdata['uid'] = $memberinfo['uid'];
            if($GLOBALS['LK1_1']=='0') MSG('请选择所在地区省份',HTTP_REFERER);
            if($GLOBALS['LK1_2']=='0') MSG('请选择所在地区市级',HTTP_REFERER);
            $formdata['province'] = remove_xss($GLOBALS['LK1_1']);
            $formdata['city'] = remove_xss($GLOBALS['LK1_2']);
            $formdata['area'] = remove_xss(trim($GLOBALS['LK1_3'],'0'));
            $formdata['mobile'] = remove_xss($GLOBALS['mobile']);
            $formdata['tel'] = remove_xss($GLOBALS['tel1']).'-'.remove_xss($GLOBALS['tel2']).'-'.remove_xss($GLOBALS['tel2']);
            $formdata['tel'] = rtrim($formdata['tel'],'-');
            $formdata['zipcode'] = intval($GLOBALS['zipcode']);
            $formdata['isdefault'] = intval($GLOBALS['isdefault']);

            $GLOBALS['addressid'] = $this->db->insert('express_address',$formdata);
            if($formdata['isdefault']) {
                $this->setdefault();
            }
            if($GLOBALS['forward']==1) {
                MSG(L('operation_success'),'/index?m=order&f=order_goods&v=cart');
            } else {
                MSG(L('operation_success'),'/index.php?m=order&f=address&v=listing&acbar=1');
            }
        }
        include T('order','address_add');
    }
    public function delete() {
        $addressid = intval($GLOBALS['addressid']);
        $memberinfo = $this->memberinfo;
        $this->db->delete('express_address',array('addressid'=>$addressid));
        MSG('删除成功！','index.php?m=order&f=address&v=listing');
    }
}
?>