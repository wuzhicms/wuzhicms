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
//Example: php /workspace/wwwroot/sendmail.wuzhicms.net/coreframe/crontab.php domain_collect collect_url
/*
/Applications/XAMPP/bin/php-5.4.31 /workspace/wwwroot/project/h1jk.cn/coreframe/crontab.php collect collect_url
*/
load_function('curl');

function wz_paseurl($linkurl,$config) {
    $html = get_curl($linkurl,'',$config['cookie']);
	//echo $html;exit;
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

$config['url_include'] = 'site_';
$config['url_uninclude'] = '';
$config['fillurl'] = 'http://top.chinaz.com/';
$config['cookie'] = 'BDTUJIAID=315c5a9edbc9251fc4e86dc8d870758a; bbsmax_user=hfKyj%2B0mbuyz1VDrM0hLcqBaf%2Fp%2Brse3uyl6hFGiV563Pz5C%2BZvZm5t1RZ1K6X%2Fe; 8MLP_5753_auth=f03cwO0QXbG%2F900luNcVFvRu5Fsb6civHxa7rIbbT%2FBG5N2jZ1zABUot6tlwhEkglJbZkbqTJfNsKsCTGVjaPYlPQCa3; tma=254185178.48281481.1473066215794.1473066215794.1473066215794.1; tmd=2.254185178.48281481.1473066215794.; bfd_g=8a7bc81f66bd068d00006c59001c6375569c5b08; Hm_lvt_aecc9715b0f5d5f7f34fba48a3c511d6=1476874232; qHistory=aHR0cDovL3dob2lzLmNoaW5hei5jb20vK1dob2lz5p+l6K+ifGh0dHA6Ly90b29sLmNoaW5hei5jb20vdG9vbHMvdW5peHRpbWUuYXNweCtVbml45pe26Ze05oizfGh0dHA6Ly90b29sLmNoaW5hei5jb20r56uZ6ZW/5bel5YW3fGh0dHA6Ly90b29sLmNoaW5hei5jb20vc3BlZWR0ZXN0LmFzcHgr5Zu95YaF572R56uZ5rWL6YCffGh0dHA6Ly9waW5nLmNoaW5hei5jb20rUGluZ+ajgOa1iw==; bdshare_firstime=1478861156362; chinaz_csrf_cookie_name=953b48568a5a5040b316a7b0b579cf87; CNZZDATA433095=cnzz_eid%3D1327389997-1478859063-http%253A%252F%252Falexa.chinaz.com%252F%26ntime%3D1478909072; CNZZDATA5936831=cnzz_eid%3D617021112-1478858075-http%253A%252F%252Falexa.chinaz.com%252F%26ntime%3D1478912079';

$configid = 32;
$db=load_class('db');

$start = 100;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
while(1) {
	ob_end_clean();
	$linkurl = 'http://top.chinaz.com/hangye/index_'.$start.'.html';
	echo $start."\r\n";
	$data = wz_paseurl($linkurl,$config);
	foreach($data as $rs) {
		echo '【'.$rs['title'].'】 '.$rs['url']."\r\n";

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
	if($start>1762) {
		$e_time = time();
		$r_time = $e_time-$c_time."s\r\r";

		exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
	}
	$start += 1;
	echo "running...\r\n";
	sleep(1);
}
