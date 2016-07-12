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
//Example: php /workspace/wwwroot/project/h1jk.cn/coreframe/crontab.php collect collect_content
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
    $html = get_curl($url);
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
        'start'=>'<title>【',
        'end'=>'】',
    ),
    'address'=>array(
        'start'=>'gray">地址：</span>',
        'end'=>'<a class="maps_ico',
    ),
    'days'=>array(
        'start'=>'该医院需提前<em class="orange">',
        'end'=>'天',
    ),
    'worktime'=>array(
        'start'=>'gray">时间：</span>',
        'end'=>'</div>',
    ),
    'huanjing'=>array(
        'start'=>'<div class="slider clearfix">',
        'end'=>'<div class="text fr">',
        'func'=>'get_more_image',
        'func_result'=>'http://www.rkang.cn/',
    ),
    'jibie'=>array(
        'start'=>'<em class="green">[',
        'end'=>']</em>',
        'func'=>'r2id',
        'func_result'=>array('1'=>'专业体检中心','2'=>'高端体检中心','3'=>'公立医院体检中心'),
    ),
    'fuwu'=>array(
        'start'=>'div class="agency_icons fr">',
        'end'=>'</div>',
        'func'=>'group_search_string',
        'func_result'=>array('1'=>'体检报告','2'=>'早餐','3'=>'VIP体检区','4'=>'周末体检','5'=>'停车位','6'=>'体检服','7'=>'一对一陪检','8'=>'快递报告','9'=>'DIY定制','10'=>'可两天内预约'),
    ),
    'content'=>array(
        'start'=>'<div class="order_way_cont">',
        'end'=>'</div>',
        'replace_code'=>' style="line-height:3em;"',
    ),
    'thumb'=>array(
        'start'=>'slider clearfix"> <img',
        'end'=>'class="bigimg"',
        'func'=>'get_image_in_string',
        'func_result'=>'http://www.rkang.cn/',
    ),

);

$db=load_class('db');


$cid = 32;

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

$result = $db->get_list('collect_url', array('status'=>0), '*', 0, 1000, 0, 'id DESC');
//todo 标题为空时或者长度验证不通过时，处理方式
foreach($result as $rs) {
    $url = $rs['url'];

    $formdata = get_content($url,$config);
    print_r($formdata);
    if(strlen($formdata['title'])<3) continue;

    $formdata = $form_add->execute($formdata);

    //插入时间，更新时间，如果用户设置了时间。则按照用户设置的时间
    $addtime = empty($formdata['addtime']) ? SYS_TIME : strtotime($formdata['addtime']);
    $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $addtime;
    //如果是共享模型，那么需要在将字段modelid增加到数据库
    if($formdata['master_table']=='content_share') {
        $formdata['master_data']['modelid'] = $modelid;
    }
    $formdata['master_data']['cid'] = $cid;
    //默认状态 status ,9为通过审核，1-4为审核的工作流，0为回收站
    $formdata['master_data']['status'] = isset($GLOBALS['form']['status']) ? intval($GLOBALS['form']['status']) : 9;

    $formdata['master_data']['route'] = 0;
    $formdata['master_data']['publisher'] = get_cookie('username') ? get_cookie('username') : '智能发布';

    if(empty($formdata['master_data']['remark']) && isset($formdata['attr_data']['content'])) {
        $formdata['master_data']['remark'] = mb_strcut(strip_tags($formdata['attr_data']['content']),0,255);
    }

    $id = $db->insert($formdata['master_table'],$formdata['master_data']);
    //生成url

    $urls = $urlclass->showurl(array('id'=>$id,'cid'=>$cid,'addtime'=>$addtime,'page'=>1,'route'=>$formdata['master_data']['route']));


    $db->update($formdata['master_table'],array('url'=>$urls['url']),array('id'=>$id));
    if(!empty($formdata['attr_table'])) {
        $formdata['attr_data']['id'] = $id;
        // print_r($formdata['attr_data']);exit;
        $db->insert($formdata['attr_table'],$formdata['attr_data']);
    }
    $formdata['master_data']['url'] = $urls['url'];
    //执行更新

    $data = $form_update->execute($formdata);

    //统计表加默认数据
    $db->insert('content_rank',array('cid'=>$cid,'id'=>$id,'updatetime'=>SYS_TIME));
    //生成静态
    if($cate_config['showhtml'] && $formdata['master_data']['status']==9) {
        $data = $db->get_one($formdata['master_table'],array('id'=>$id));
        if(!empty($formdata['attr_table'])) {
            $attrdata = $db->get_one($formdata['attr_table'],array('id'=>$id));
            $data = array_merge($data,$attrdata);
        }
        //上一页
        $data['previous_page'] = $db->get_one($formdata['master_table'],"`cid` = '$cid' AND `id`<'$id' AND `status`=9",'*',0,'id DESC');
        //下一页
        $data['next_page'] = '';

        $createhtml->set_category($cate_config);
        $createhtml->set_categorys();
        $createhtml->load_formatcache();
        $createhtml->show($data,1,1,$urls['root']);
    }
    $collecttime = date('Y-m-d H:i:s');
    $db->update('collect_url',array('status'=>1,'collecttime'=>$collecttime),array('id'=>$rs['id']));
}


/**
 * 专业体检中心|1
高端体检中心|2
公立医院体检中心|3
 *
 *
 * 电子报告|1
早餐|2
vip体检区|3
周末体检|4
停车位|5
体检服|6
一对一陪检|7
快递报告|8
DIY定制|9
可两天内预约|10
 */
exit("OK\r\n");

//http://api.gpsspg.com/convert/latlng/?oid=515&key=A3B8B66FEE4E5D53C529571DA61633C2&from=3&to=2&latlng=39.957530,116.395952


//http://restapi.amap.com/v3/geocode/geo?address=%E5%8C%97%E4%BA%AC%E5%B8%82%E4%B8%9C%E5%9F%8E%E5%8C%BA%E5%AE%89%E5%BE%B7%E9%87%8C%E5%8C%97%E8%A1%9721%E5%8F%B7&key=5c69e3f99ef28981d0bf78caf4f26073&s=rsv3&callback=AMap._67523_

//AMap._67523_({"status":"1","info":"OK","count":"1","geocodes":[{"formatted_address":"北京市东城区安德里北街21号","province":"北京市","citycode":"010","city":"北京市","district":"东城区","township":[],"neighborhood":{"name":[],"type":[]},"building":{"name":[],"type":[]},"adcode":"110101","street":"安德里北街","number":"21号","location":"116.395952,39.957530","level":"门牌号"}]})