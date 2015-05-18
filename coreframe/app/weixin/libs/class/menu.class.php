<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 微信菜单创建
 */
class WUZHI_menu {
	public function __construct() {
        $this->db = load_class('db');
	}

    private function getAccessToken() //获取access_token
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".AppId."&secret=".AppSecret;
        $data = get_curl_https($url);//通过自定义函数getCurl得到https的内容
        $resultArr = json_decode($data, true);//转为数组
        if($resultArr["access_token"]) {
            $this->db->update('setting', array('data'=>$resultArr["access_token"]),array('keyid' => 'access_token','m'=>'weixin'));
        }
        return $resultArr["access_token"];//获取access_token
    }
    public function creatMenu($string)//创建菜单
    {
        $accessToken = $this->getAccessToken();//获取access_token
        /*
        $string = '{
    "button": [
        {
            "type": "click",
            "name": "五指互联",
            "key": "V1001_TODAY_MUSIC"
        },
        {
            "name": "菜单",
            "sub_button": [
                {
                    "type": "view",
                    "name": "搜索",
                    "url": "http://www.soso.com/"
                },
                {
                    "type": "view",
                    "name": "视频",
                    "url": "http://v.qq.com/"
                },
                {
                    "type": "click",
                    "name": "赞一下我们",
                    "key": "V1001_GOOD"
                }
            ]
        }
    ]
}';
        */
        $menuPostUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accessToken;//POST的url
        $data = post_curl($menuPostUrl,$string);//将菜单结构体POST给微信服务器
        return $data;
    }

}