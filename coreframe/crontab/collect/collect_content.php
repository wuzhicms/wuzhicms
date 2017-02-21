<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 采集内容
 */
//Example: php /workspace/wwwroot/sendmail.wuzhicms.net/coreframe/crontab.php domain_collect collect_content
/*
/Applications/XAMPP/bin/php-5.4.31 /workspace/wwwroot/project/h1jk.cn/coreframe/crontab.php collect collect_content
*/
load_function('curl');
load_function('ext','collect');

/**
 * 补全地址
 *
 * @param $url
 * @param $baseurl
 * @param $config
 * @return string
 */
function fillurl($url, $baseurl, $config = '') {
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
function cut_html($html, $start, $end) {
    if (empty($html)) return false;

    $start = str_replace(array("\r", "\n"), "", $start);
    $end = str_replace(array("\r", "\n"), "", $end);
    $html = explode(trim($start), $html);
    if(is_array($html)) $html = explode(trim($end), $html[1]);
    return $html[0];
}

function replace_code($html, $config) {
    if (empty($config)) return $html;
    $config = explode("\n", $config);
    $patterns = $replace = array();
    $p = 0;
    foreach ($config as $k=>$v) {
        if (empty($v)) continue;
        $c = explode('[|]', $v);
        $patterns[$k] = '/'.str_replace('/', '\/', $c[0]).'/i';
        $replace[$k] = $c[1];
        $p = 1;
    }
    return $p ? @preg_replace($patterns, $replace, $html) : false;
}

function get_content($url,$config) {
	$ip1 = rand(1,211).'.'.rand(1,211).'.'.rand(1,211).'.'.rand(1,211);
	$ip2 = rand(1,211).'.'.rand(1,211).'.'.rand(1,211).'.'.rand(1,211);
	$header = array(
		'CLIENT-IP:'.$ip1,
		'X-FORWARDED-FOR:'.$ip2,
	);
    $html = get_curl($url,$header);
    $html = str_replace(array("\r", "\n"), "", $html);
    foreach($config['fields'] as $field=>$_c) {
        if(isset($_c['func'])) {
            $tmp = cut_html($html, $_c['start'], $_c['end']);
            $func = $_c['func'];
            $data[$field] = $func($tmp,$_c['func_result']);
        } else {
            $data[$field] = cut_html($html, $_c['start'], $_c['end']);
            if(isset($_c['replace_code'])) {
                $data[$field] = replace_code($data[$field],$_c['replace_code']);
            }
        }
    }
    return $data;
}

//开始配置


$config['fields'] = array(
    'title'=>array(
        'start'=>'h2Title fl">',
        'end'=>'</h2>',
    ),
    'domain'=>array(
        'start'=>'plink ml5 fl"><a href="http://',
        'end'=>'"',
    ),
    'top'=>array(
        'start'=>'.html?#obj_',
        'end'=>'"',
    ),
    'thumb'=>array(
        'start'=>'Centleft fl mt5"><img',
        'end'=>'onerror="this',
        'func'=>'get_image_in_string',
        'func_result'=>'http://www.rkang.cn/',
    ),
	'remark'=>array(
		'start'=>'class="webIntro">',
		'end'=>'</p>',
	),
	'content'=>array(
		'start'=>'class="webIntro">',
		'end'=>'</p>',
	),
	'icp_dwmc'=>array(
		'start'=>'<p>单位名称：',
		'end'=>'</p>',
	),
	'icp_dwxz'=>array(
		'start'=>'<p>单位性质：',
		'end'=>'</p>',
	),
	'icp_wzba'=>array(
		'start'=>'<p>网站备案：',
		'end'=>'</p>',
	),
	'server_ip'=>array(
		'start'=>'<p>Ip地址：',
		'end'=>'</p>',
	),
	'server_address'=>array(
		'start'=>'<p>服务器地址：',
		'end'=>'</p>',
	),
	'server_lx'=>array(
		'start'=>'<p>服务器类型：',
		'end'=>'</p>',
	),
	'server_xysj'=>array(
		'start'=>'<p>响应时间：',
		'end'=>'</p>',
	),
	'domain_ymzcs'=>array(
		'start'=>'<p>域名注册商：',
		'end'=>'</p>',
	),
	'domain_ymfwq'=>array(
		'start'=>'<p>域名服务器：',
		'end'=>'</p>',
	),
	'domain_zcsj'=>array(
		'start'=>'<p>创建时间：',
		'end'=>'</p>',
	),
	'domain_dqsj'=>array(
		'start'=>'<p>到期时间：',
		'end'=>'</p>',
	),
);

$db=load_class('db');


$cid = 57;

$cate_config = get_cache('category_'.$cid,'content');
if(!$cate_config) MSG(L('category not exists'));
$categorys = get_cache('category','content');

$createhtml = load_class('html','content');
$urlclass = load_class('url','content',$cate_config);

$urlclass->set_category($cate_config);
$urlclass->set_categorys($categorys);

//如果设置了modelid，那么则按照设置的modelid。共享模型添加必须数据必须指定该值。
$modelid = $cate_config['modelid'];

require get_cache_path('content_add','model');
$form_add = new form_add($modelid);

require get_cache_path('content_update','model');
$form_update = new form_update($modelid);

$start = 1;
$starttime = date('Y-m-d H:i:s');
$c_time = time();
while(1) {
	ob_end_clean();
	$result = $db->get_list('collect_url', array('status' => 0), '*', 0, 5, $start, 'id ASC');
	foreach ($result as $rs) {
		$url = $rs['url'];

		$formdata = get_content($url, $config);
		if (strlen($formdata['title']) < 1) continue;
		echo $formdata['title']."\r\n";
		$formdata = $form_add->execute($formdata);

		//插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
		$addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
		$formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;
		//如果是共享模型，那么需要在将字段modelid增加到数据库
		if ($formdata['master_table'] == 'content_share') {
			$formdata['master_data']['modelid'] = $modelid;
		}
		$formdata['master_data']['cid'] = $cid;
		//默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
		$formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 9;

		$formdata['master_data']['route'] = 0;
		$formdata['master_data']['publisher'] = get_cookie('username') ? get_cookie('username') : '智能发布';

		if (empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
			$formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']), 0, 255);
		}

		$id = $db->insert($formdata['master_table'], $formdata['master_data']);
		//生成url

		$urls = $urlclass->showurl(array('id' => $id, 'cid' => $cid, 'addtime' => $addtime, 'page' => 1, 'route' => $formdata['master_data']['route']));


		$db->update($formdata['master_table'], array('url' => $urls['url']), array('id' => $id));
		if (!empty($formdata['attr_table'])) {
			$formdata['attr_data']['id'] = $id;
			// print_r($formdata['attr_data']);exit;
			$db->insert($formdata['attr_table'], $formdata['attr_data']);
		}
		$formdata['master_data']['url'] = $urls['url'];
		//执行更新

		$data = $form_update->execute($formdata);

		//统计表加默认数据
		//$db->insert('content_rank', array('cid' => $cid, 'id' => $id, 'updatetime' => SYS_TIME));
		//生成静态
		if ($cate_config['showhtml'] && $formdata['master_data']['status'] == 9) {
			$data = $db->get_one($formdata['master_table'], array('id' => $id));
			if (!empty($formdata['attr_table'])) {
				$attrdata = $db->get_one($formdata['attr_table'], array('id' => $id));
				$data = array_merge($data, $attrdata);
			}
			//上一页
			$data['previous_page'] = $db->get_one($formdata['master_table'], "`cid` = '$cid' AND `id`<'$id' AND `status`=9", '*', 0, 'id DESC');
			//下一页
			$data['next_page'] = '';

			$createhtml->set_category($cate_config);
			$createhtml->set_categorys();
			$createhtml->load_formatcache();
			$createhtml->show($data, 1, 1, $urls['root']);
		}
		$collecttime = date('Y-m-d H:i:s');
		$db->update('collect_url', array('status' => 1, 'collecttime' => $collecttime), array('id' => $rs['id']));
	}
	if(empty($result)) {
		$e_time = time();
		$r_time = $e_time-$c_time."s\r\r";

		exit("\r\nFinish!!!\r\nStart Time:".$starttime."\r\nEnd   Time:".date('Y-m-d H:i:s')."\r\nTotal Time:".$r_time."\r\n");
	}
	$start += 1;
	echo "running...\r\n";
	//sleep(1);
}
exit("OK\r\n");