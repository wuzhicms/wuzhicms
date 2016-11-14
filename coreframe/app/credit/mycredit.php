<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('foreground', 'member');
class mycredit extends WUZHI_foreground{
    private $payments;
    private $status_arr;
	function __construct() {
		$this->member = load_class('member', 'member');
		$this->setting = get_cache('setting', 'member');
		parent::__construct();
	}
	public function listing(){
        $seo_title = '账户积分';
		$memberinfo = $this->memberinfo;
        $payments = $this->payments;
        $status_arr = $this->status_arr;
        $status = isset($GLOBALS['status']) ? intval($GLOBALS['status']) : -1;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('credit', "`uid`='".$memberinfo['uid']."'", '*', 0, 20,$page,'jid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $point_config = get_cache('point_config');
		include T('credit','listing');
	}
    //积分购买
    public function exchange() {
        $memberinfo = $this->memberinfo;
        $money = intval($GLOBALS['money']);
        if($money>$memberinfo['money']) MSG('您的剩余金额不足');
		if($money<0)  {
			MSG('金额错误哦!');
			exit;
		}
        $point_config = get_cache('point_config');
        if($point_config['exchange_point']) {
            $credit_api = load_class('credit_api','credit');
            $point = $money*$point_config['exchange_point'];
            $credit_api->handle($memberinfo['uid'], '+',$point, '积分购买');
            $this->db->update('member', "`money`=`money`-$money", array('uid' => $memberinfo['uid']));
            MSG('积分购买成功',HTTP_REFERER);//?m=credit&f=mycredit&v=listing $GLOBALS['forward']
        } else {
            MSG('没有开启积分兑换功能，请联系客服！');
        }
    }
}