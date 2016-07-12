<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 发送文本信息
 *
 * @param int $money
 * @param int $len
 * @param string $sign
 * @return string
 */
function send_text($uid,$text){
    $db = load_class('db');
    $mr = $db->get_one('member',array('uid' => $uid),'openid,lasttime');
    if((SYS_TIME-$mr['lasttime'])>172200) {//86400*2-600大于48小时，微信禁止给用户发送信息
        return false;
    }
    $token = get_cache('token','weixin');
    $PostUrl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token['access_token'];//POST的url
    $text = '{
    "touser":"'.$mr['openid'].'",
    "msgtype":"text",
    "text":
    {
         "content":"'.$text.'"
    }
}';

    $data = post_curl($PostUrl,$text);//将菜单结构体POST给微信服务器
    $data = json_decode($data,true);
    //{"errcode":45015,"errmsg":"response out of time limit or subscription is canceled"}
    if($data['errcode']) {

    }
    return $data;
}
function weixin_shorturl($url){
    $token = get_cache('token','weixin');
    $PostUrl = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=".$token['access_token'];//POST的url
    $text = '{
    "action":"long2short",
    "long_url":"'.$url.'"
    }';

    $data = post_curl($PostUrl,$text);//将菜单结构体POST给微信服务器
    $data = json_decode($data,true);
    //{"errcode":45015,"errmsg":"response out of time limit or subscription is canceled"}
    if($data['errcode']) {
        return $url;
    } else {
        return $data['short_url'];
    }
}


//
function make_nonceStr()
{
    $codeSet = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i<16; $i++) {
        $codes[$i] = $codeSet[mt_rand(0, strlen($codeSet)-1)];
    }
    $nonceStr = implode($codes);
    return $nonceStr;
}

function make_signature($nonceStr,$timestamp,$jsapi_ticket,$url)
{
    $tmpArr = array(
        'noncestr' => $nonceStr,
        'timestamp' => $timestamp,
        'jsapi_ticket' => $jsapi_ticket,
        'url' => $url
    );
    ksort($tmpArr, SORT_STRING);
    $string1 = http_build_query( $tmpArr );
    $string1 = urldecode( $string1 );
    $signature = sha1( $string1 );
    return $signature;
}

function make_token($appid = '',$secret = '')
{
    if($appid=='' || $secret=='') {
        $weixin_config = get_config('weixin_config');
    } else {
        $weixin_config['appid'] = $appid;
        $weixin_config['secret'] = $secret;
    }

    $data = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$weixin_config['appid']."&secret=".$weixin_config['secret']);
    $db=load_class('db');
    $data = json_decode($data,true);
    $access_token = $data['access_token'];
    if($access_token) {
        $db->update('setting', array('data'=>$access_token),array('keyid' => 'access_token','m'=>'weixin'));
        $ticket_URL="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi";
        $json = file_get_contents($ticket_URL);
        $result = json_decode($json,true);
        $ticket = $result['ticket'];
        $db->update('setting', array('data'=>$ticket),array('keyid' => 'jsapi_ticket','m'=>'weixin'));
        $token = array('access_token'=>$access_token,'jsapi_ticket'=>$ticket);
        set_cache('token',$token,'weixin');
        return $token;
    }
    return false;
}