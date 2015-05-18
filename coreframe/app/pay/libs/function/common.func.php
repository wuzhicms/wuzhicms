<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 格式化金额
 *
 * @param int $money
 * @param int $len
 * @param string $sign
 * @return string
 */
function format_money($money, $len=2, $sign='￥'){
    $negative = $money > 0 ? '' : '-';
    $int_money = intval(abs($money));
    $len = intval(abs($len));
    $decimal = '';//小数
    if ($len > 0) {
        $decimal = '.'.substr(sprintf('%01.'.$len.'f', $money),-$len);
    }
    $tmp_money = strrev($int_money);
    $strlen = strlen($tmp_money);
    for ($i = 3; $i < $strlen; $i += 3) {
        $format_money .= substr($tmp_money,0,3).',';
        $tmp_money = substr($tmp_money,3);
    }
    $format_money .= $tmp_money;
    $format_money = strrev($format_money);
    return $sign.$negative.$format_money.$decimal;
}

function create_order_no() {
    mt_srand((double )microtime() * 1000000 );
    return date("YmdHis" ).str_pad( mt_rand( 1, 99999 ), 5, "0", STR_PAD_LEFT );
}