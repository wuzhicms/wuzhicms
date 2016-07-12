<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 采集url
 */
//Example: php /workspace/wwwroot/project/h1jk.cn/coreframe/crontab.php collect collect_url
/*
/Applications/XAMPP/bin/php-5.4.31 /workspace/wwwroot/project/h1jk.cn/coreframe/crontab.php collect collect_url
*/
load_function('curl');

function wz_paseurl($linkurl,$config) {
    $html = get_curl($linkurl,'',$config['cookie']);

    $html = str_replace(array("\r", "\n"), '', $html);
    $html = str_replace(array("</a>", "</A>"), "</a>\n", $html);
    preg_match_all('/<a([^>]*)>([^\/a>].*)<\/a>/i', $html, $out);
    $out[1] = array_unique($out[1]);
    $out[2] = array_unique($out[2]);
    $data = array();
    foreach ($out[1] as $k=>$v) {
        if (preg_match('/href=[\'"]?([^\'" ]*)[\'"]?/i', $v, $match_out)) {
            if ($config['url_include']) {
                if (strpos($match_out[1], $config['url_include']) === false) {

                    continue;
                }
            }

            if ($config['url_uninclude']) {
                if (strpos($match_out[1], $config['url_uninclude']) !== false) {
                    continue;
                }
            }

            $url2 = $match_out[1];
            $url2 = fillurl($url2, $linkurl, $config);


            preg_match('/title=[\'"]?([^\'" ]*)[\'"]?/i', $v, $match_out2);
            $title = strip_tags($match_out2[1]);
            if($title=='') continue;

            $data[$k]['url'] = $url2;
            $data[$k]['title'] = $title;
        } else {
            continue;
        }
    }
    return $data;
}

/**
 * 补全地址
 *
 * @param $url
 * @param $baseurl
 * @param $config
 * @return string
 */
function fillurl($url, $baseurl, $config) {
    $urlinfo = parse_url($baseurl);

    $baseurl = $urlinfo['scheme'].'://'.$urlinfo['host'].(substr($urlinfo['path'], -1, 1) === '/' ? substr($urlinfo['path'], 0, -1) : str_replace('\\', '/', dirname($urlinfo['path']))).'/';
    if (strpos($url, '://') === false) {
        if ($url[0] == '/') {
            $url = $urlinfo['scheme'].'://'.$urlinfo['host'].$url;
        } else {
            if ($config['page_base']) {
                $url = $config['page_base'].$url;
            } else {
                $url = $baseurl.$url;
            }
        }
    }
    return $url;
}

//开始配置

$config['url_include'] = 'physical';
$config['url_uninclude'] = 'TrafficMap';
$config['fillurl'] = 'http://www.rkang.cn/';
$config['cookie'] = 'Cookie:pgv_pvi=9899584512; Cart_rkang=YTo0OntzOjk6ImNhcnRfbnVtcyI7aTowO3M6MTE6ImNhcnRfcHJpY2VzIjtpOjA7czo5OiJjYXJ0X3RpbWUiO2k6MTQyMzQ1NDAzOTtzOjk6ImNhcnRfbGlzdCI7YTowOnt9fQ%3D%3D; rdagencys=YToxMzp7aTowO3M6MzoiODUwIjtpOjE7czoxOiIxIjtpOjI7czoxOiIzIjtpOjM7czo0OiIxODUwIjtpOjQ7czo0OiIzODUwIjtpOjU7czo0OiI0MjUwIjtpOjY7czo0OiI0MjgwIjtpOjc7czo0OiI0MjkwIjtpOjg7czo0OiI0Mjk5IjtpOjk7czo0OiI0MzAwIjtpOjEwO3M6NDoiNDMxOCI7aToxMTtzOjQ6IjQzMTciO2k6MTI7czo0OiI0MzE2Ijt9; PHPSESSID=nn304ps9sndjvbccvavtqinmj5; IESESSION=alive; pgv_si=s7454238720; BRIDGE_R5233821=; VERSION=2,0,0,0; BRIDGE_INVITE_0=0; Copy_priv=MYADARO; icity=YToyNjp7aTowO3M6MjoiMTEiO3M6NToidGJfaWQiO3M6MjoiMTEiO2k6MTtzOjY6IuWMheWktCI7czoxMToidGJfY2l0eW5hbWUiO3M6Njoi5YyF5aS0IjtpOjI7czoxOiIzIjtzOjc6InRiX3R5cGUiO3M6MToiMyI7aTozO3M6MzoiYmF2IjtzOjk6InRiX3VybHN0ciI7czozOiJiYXYiO2k6NDtzOjY6IkJBT1RPVSI7czo5OiJ0Yl9hbGxwaW4iO3M6NjoiQkFPVE9VIjtpOjU7czozOiJCQVYiO3M6MTE6InRiX2NpdHljb2RlIjtzOjM6IkJBViI7aTo2O3M6MToiQiI7czoxMToidGJfaW5pdGlhbHMiO3M6MToiQiI7aTo3O3M6MToiMCI7czoxMDoidGJfd2VpZ2h0cyI7czoxOiIwIjtpOjg7czoxOiIwIjtzOjEwOiJ0Yl9ib29rbnVtIjtzOjE6IjAiO2k6OTtzOjE6IjAiO3M6NjoidGJfaG90IjtzOjE6IjAiO2k6MTA7czoxOiIxIjtzOjc6InRiX3ZpZXciO3M6MToiMSI7aToxMTtOO3M6NjoidGJfdHh0IjtOO2k6MTI7czoxOiIwIjtzOjEwOiJ0Yl9hZGR0aW1lIjtzOjE6IjAiO30%3D; Hm_lvt_17f69b58d4a990165d55a24f54db70c2=1422417201,1422498782,1423454040,1423485855; Hm_lpvt_17f69b58d4a990165d55a24f54db70c2=1423495682

';

$configid = 32;
$db=load_class('db');

for($start=1;$start<8;$start++) {
    $linkurl = 'http://www.rkang.cn/agency.php?url=soagencys&orderby=weight&sequence=desc&p='.$start;

    $data = wz_paseurl($linkurl,$config);

    foreach($data as $rs) {
        $urlkey = md5($rs['url']);
        $r = $db->get_one('collect_url', array('urlkey' => $urlkey));
        if($r) continue;
        $formdata = array();
        $formdata['urlkey'] = $urlkey;
        $formdata['url'] = $rs['url'];
        $formdata['title'] = $rs['title'];
        $formdata['configid'] = $configid;
        $db->insert('collect_url', $formdata);

    }
    print_r($data);
}

exit("OK\r\n");