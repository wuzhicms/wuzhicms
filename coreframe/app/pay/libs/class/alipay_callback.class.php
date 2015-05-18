<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

load_function('alipay_core','pay');


class WUZHI_alipay_callback {
    /**
     * HTTPS形式消息验证地址
     */
    var $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    /**
     * HTTP形式消息验证地址
     */
    var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    var $alipay_config;

    //根据返回状态返回系统存储的值
    var $status;
    //从支付平台返回的商户订单号，做记录
    var $response_order_no;

    function __construct($alipay_config){
        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('MD5');

        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']= strtolower(CHARSET);

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']    = '';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';
        $this->alipay_config = $alipay_config;
    }
    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    function verify(){
        //生成签名结果
        $isSign = $this->getSignVeryfy($GLOBALS, $GLOBALS["sign"]);

        //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
        $responseTxt = 'true';
        if (! empty($GLOBALS["notify_id"])) {$responseTxt = $this->getResponse($GLOBALS["notify_id"]);}

        //写日志记录
        //if ($isSign) {
        //	$isSignStr = 'true';
        //}
        //else {
        //	$isSignStr = 'false';
        //}
        //$log_text = "responseTxt=".$responseTxt."\n notify_url_log:isSign=".$isSignStr.",";
        //$log_text = $log_text.createLinkString($_POST);
        //logResult($log_text);

        //验证
        //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
        //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关

        if (preg_match("/true$/i",$responseTxt) && $isSign) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 处理
     */
    function response_status($verify_result) {
        if($verify_result) {//验证成功

            //商户订单号
            $out_trade_no = $this->response_order_no = $GLOBALS['out_trade_no'];

            //支付宝交易号
            $trade_no = $GLOBALS['trade_no'];

            //交易状态
            $trade_status = $GLOBALS['trade_status'];


            if($trade_status == 'WAIT_BUYER_PAY') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 6;
                return "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if($trade_status == 'WAIT_SELLER_SEND_GOODS') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 7;
                return "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
                //该判断表示卖家已经发了货，但买家还没有做确认收货的操作

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 8;
                return "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if($trade_status == 'TRADE_FINISHED') {
                //该判断表示买家已经确认收货，这笔交易完成

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 1;
                return "success";		//请不要修改或删除

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if($trade_status == 'TRADE_SUCCESS') {
                //该判断表示买家已经确认收货，这笔交易完成

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 1;
                return "success";		//请不要修改或删除
            } else if($trade_status == 'TRADE_CLOSED') {
                //卖家未发货而退款成功

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->status = 9;
                return "success";		//请不要修改或删除
            } else {
                //其他状态判断
                $this->status = 10;
                return "success";

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            //――请根据您的业务逻辑来编写程序（以上代码仅作参考）――

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            $this->status = -1;
            return "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    function getSignVeryfy($para_temp, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);

        $isSgin = false;
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
            case "MD5" :
                $isSgin = md5Verify($prestr, $sign, $this->alipay_config['key']);
                break;
            default :
                $isSgin = false;
        }

        return $isSgin;
    }

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    function getResponse($notify_id) {
        $transport = strtolower(trim($this->alipay_config['transport']));
        $partner = trim($this->alipay_config['partner']);
        $veryfy_url = '';
        if($transport == 'https') {
            $veryfy_url = $this->https_verify_url;
        }
        else {
            $veryfy_url = $this->http_verify_url;
        }
        $veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
        $responseTxt = getHttpResponseGET($veryfy_url, $this->alipay_config['cacert']);

        return $responseTxt;
    }
}
?>
