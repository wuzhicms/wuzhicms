<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: sendsms.inc.php 1124 2011-12-06 11:03:23Z pmonkey_w $
*/

!defined('IN_UC') && exit('Access Denied');

if($sms_setting['smssilent']) {
	error_reporting(0);
}


if($sms_setting['smstype'] == 1) {
	 return @sendmsg_by_alidayu($sms_setting['smsauth_username'], $sms_setting['smsauth_passwd'], $sms['sms_to'], $sms['message'], $sms_setting['template']);
}

function sendmsg_by_alidayu($key,$secret,$sms,$content,$template){
    $url = "https://eco.taobao.com/router/rest";
    $preg = $msg;
    $param = $arr = array();
    if(preg_match_all('/\$\{(\w+)\}/', $msg, $match)){
        foreach ($match[1] as $k=>$v){
            $preg = str_ireplace($match[0][$k], '(.*)', $preg);
            $arr[$k] = $v;
        }
        if(preg_match('/^'.$preg.'$/', $content, $match2)){
            array_shift($match2);
            foreach ($arr as $k=>$v){
                $param[$v] = $match2[$k];
            }
        }
        $data = array(
            'method'=>'alibaba.aliqin.fc.sms.num.send',
            'app_key'=>$key,
            'timestamp'=>date('Y-m-d H:i:s'),
            'format'=>'json',
            'v'=>'2.0',
            'sign_method'=>'md5',
            'sign'=>'',//API输入参数签名结果
            'sms_type'=>'normal',
            'sms_free_sign_name'=>$sign,
            'sms_param'=>json_encode($param),
            'rec_num'=>$sms,
            'sms_template_code'=>$msgid,
        );

        $signparam = $data;
        unset($signparam['sign']);
        ksort($signparam);
        $stringToBeSigned = $secret;
        foreach ($signparam as $k => $v){
            if(is_string($v) && "@" != substr($v, 0, 1)){
                $stringToBeSigned .= "$k$v";
            }
        }
        $stringToBeSigned .= $secret;
        $data['sign'] = strtoupper(md5($stringToBeSigned));
        return post_by_alidayu($url,$data);
    }else{
        return false;
    }
}

function post_by_alidayu($url, $post = array()) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    if (is_array($post) && 0 < count($post)){
        $postBodyString = "";
        $postMultipart = false;
        foreach ($post as $k => $v){
            if(!is_string($v)){
                continue ;
            }
            if("@" != substr($v, 0, 1)){
                $postBodyString .= "$k=" . urlencode($v) . "&";
            }else{
                $postMultipart = true;
                if(class_exists('\CURLFile')){
                    $postFields[$k] = new \CURLFile(substr($v, 1));
                }
            }
        }
        unset($k, $v);
        curl_setopt($curl, CURLOPT_POST, true);//post方式提交
        if ($postMultipart){
            if (class_exists('\CURLFile')) {
                curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
            } else {
                if (defined('CURLOPT_SAFE_UPLOAD')) {
                    curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
                }
            }
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        }else{
            $header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
            curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
            curl_setopt($curl, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
        }
    }
    $rs = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($rs,true);
    if($result && !isset($result['error_response']) && $result['alibaba_aliqin_fc_sms_num_send_response']['result']['err_code']==0){
        return true;
    }else{
        return false;
    }
}

?>