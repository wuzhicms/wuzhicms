<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_class('form');
/**
 * 内容模块函数库
 */
function catpos($cid, $symbol=' &gt; ', $target = ''){
    static $categorys;
    if(empty($categorys)) {
        $categorys = get_cache('category','content');
    }
    $pid = $categorys[$cid]['pid'];
    if($pid!=0) {
        catpos($pid, $symbol,$target);
    }
    echo '<a href="'.$categorys[$cid]['url'].'" '.$target.'>'.$categorys[$cid]['name'].'</a>';
    echo $symbol;
}
function elasticid($cid) {
    static $categorys;
    if(empty($categorys)) {
        $categorys = get_cache('category','content');
    }
    if($categorys[$cid]['child']) {
        return $cid;
    } elseif($categorys[$cid]['pid']) {
        return $categorys[$cid]['pid'];
    } else {
        return $cid;
    }
}

/**
 * 私密文件下载链接生成
 * @param $file
 * @param $output 1 直接显示
 *
 */
function private_file($file,$output = 0) {
    if(strpos($file, ATTACHMENT_URL) !== false) {
        $filetype = get_ext($file);
        if($output && in_array($filetype,array('jpg','jpeg','gif','bmp','png'))) {
            $file = str_replace(ATTACHMENT_URL,ATTACHMENT_ROOT,$file);
            download($file,'',1);
            exit;
        } else {
            $file = str_replace(ATTACHMENT_URL,'wZ:',$file);
        }
    }
    return WEBURL.'index.php?f=down&v=d&s='.urlencode(encode($file));
}

/**
 * 文件下载／或输出显示
 * @param $filepath 文件路径
 * @param $filename 文件名称
 */

function download($filepath, $filename = '',$output = 0) {
    if(!$filename) $filename = basename($filepath);
    if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie ') !== false) {
        $filename = rawurlencode($filename);
    }
    $filetype = get_ext($filename);
    if(!file_exists($filepath)) MSG('文件不存在');
    $filesize = sprintf("%u", filesize($filepath));
    if(ob_get_length() !== false) @ob_end_clean();
    header('Pragma: public');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: pre-check=0, post-check=0, max-age=0');
    header('Content-Transfer-Encoding: binary');
    header('Content-Encoding: none');
    header('Content-type: '.$filetype);

    if(!$output) header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Content-length: '.$filesize);
    readfile($filepath);
    exit;
}

/**
 * @param $field 要筛选的字段
 * @param $value 值
 */
function filter($field,$value) {
    $page_fields = $_POST['page_fields'];
    $page_fields[$field] = $value;
    return _pageurl($_POST['page_urlrule'],1,$page_fields);
}

/**
 * 获取机构信息
 */
function get_mec($id) {
    $id = intval($id);
    $db = load_class('db');
    return $db->get_one('mec',array('id'=>$id));
}
//获取城市机构列表
function city_mec($city,$glpp) {
    $city1 = trim($city,',');
    $city = explode(',',$city1);
    if(in_array('0',$city)) {
        $where = "status=9 AND glpp='$glpp'";
    } elseif(in_array('-1',$city)) {
        return array();
    } else {
        $where = "status=9 AND cid IN ($city1) AND glpp='$glpp'";
    }

    $db = load_class('db');

    $result = $db->get_list('mec', $where, '*', 0, 100, 0, 'sort ASC');
    return $result;
}
function hotcity($type = 1) {
    $db = load_class('db');
    $result = $db->get_list('category', array('modelid'=>3,'ishot'=>1), '*', 0, 100, 0, 'sort ASC');
    if($type==1) {
        $result = key_value($result,'cid','name');
        return WUZHI_form::select($result, 0, 'name="cityid" class="form-control input-sm"', '请选择城市');
    } else {
        return $result;
    }
}

function allcity($str = '') {
    $db = load_class('db');
    $categorys = get_cache('category','content');
    $tmp = array();
    foreach($categorys as $cid=>$cate) {
        if($cate['modelid']==3) {
            $cate['cid'] = $cid;
            $tmp[$cid] = $cate;
        }
    }
    return WUZHI_form::tree_select($tmp, 0, 'name="cityid" class="form-control input-sm" '.$str, '请选择城市');
}
function fuwuicon($ids) {
    $ids = trim($ids,',');
    if(empty($ids)) return '';
    $icons = array(
        1=>'<a class="bg_ico" title="体检报告"></a>',
        2=>'<a class="zc_ico" title="早餐"></a>',
        3=>'<a class="vip_ico" title="VIP体检区"></a>',
        4=>'<a class="sunday_ico" title="周末体检"></a>',
        5=>'<a class="free_ico" title="停车位"></a>',
        6=>'<a class="cloth_ico" title="体检服"></a>',
    );
    $str = '';
    $ids = explode(',',$ids);
    foreach($ids as $id) {
        $str.= $icons[$id];
    }
    return $str;
}
function mecinfo($username) {
    if(empty($username)) return '';
    $db = load_class('db');
    $r = $db->get_one('member',array('username'=>$username),'mecid');
    if(!$r) return '';
    return $db->get_one('mec',array('id'=>$r['mecid']));
}

/**
 * 获取文章点击数
 *
 * @param $cid
 * @param $id
 * @param string $view
 * @return string
 */
function get_hits($cid,$id,$view = '') {
    if(empty($cid) || empty($id)) return '0';
    $db = load_class('db');
    $r = $db->get_one('content_rank',array('cid'=>$cid,'id'=>$id));
    if($view) {
        return $r[$view];
    } else {
        return $r;
    }
}

/**
 * 获取栏目下内容数量
 * @param $cid
 */
function get_category_item($cid) {
    $categorys = get_cache('category','content');
    if(!isset($categorys[$cid])) return '0';
    $db = load_class('db');
    $modelid = $categorys[$cid]['modelid'];
    $models = get_cache('model_content','model');
    $master_table = $models[$modelid]['master_table'];
    return $db->count_result($master_table,array('cid'=>$cid));
}

function get_memberinfo($publisher) {

    $db = load_class('db');
    $models = get_cache('model_member','model');
    $r = $db->get_one('member', array('username' => $publisher));
    if($r) {
        $r['password'] = '';
        $attr_table = $models[$r['modelid']]['attr_table'];
        $rs = $db->get_one($attr_table, array('uid' => $r['uid']));
        if($rs) $r = array_merge($r,$rs);

        return $r;
    } else {
        return '';
    }
}

function get_member_field($uid,$field = 'username') {
    $db = load_class('db');
    $r = $db->get_one('member', array('uid' => $uid),$field);
    if($r) {
        return $r[$field];
    } else {
        return '';
    }
}

/**
 * 获取单网页内容
 *
 * @param $table
 * @param $id
 * @return mixed
 */
function get_pageinfo($cid) {
    $cid = intval($cid);
    $db = load_class('db');
    $model_r = get_cache('model_content','model');
    $category = get_cache('category_'.$cid,'content');
    $master_table = $model_r[$category['modelid']]['master_table'];
    if($category['type']==1) {
        $r = $db->get_one($master_table,array('cid'=>$cid));
        if($r && $attr_table = $model_r[$category['modelid']]['attr_table']) {
            $r2 = $db->get_one($attr_table,array('id'=>$r['id']));
            if($r2) $r = array_merge($r,$r2);
            return $r;
        }
    }
    return array();
}
/**
 * 获取指定模型下的信息
 */
function get_info($id,$modelid) {
    $id = intval($id);
    $models = get_cache('model_content','model');
    $master_table = $models[$modelid]['master_table'];
    $db = load_class('db');
    return $db->get_one($master_table,array('id'=>$id));
}

/**
 * 获图片的宽高
 *
 * @param string $url 远程图片的链接
 * @return false|array
 */
function imagesize($url,$return_type = 1) {
    if(strpos($url,ATTACHMENT_URL)!==false) {
        $url = str_replace(ATTACHMENT_URL,ATTACHMENT_ROOT,$url);
    }
    $size = getimagesize($url);
    if (empty($size)) {
        return false;
    }
    if($return_type==1) {
        return $size[0].'x'.$size[1];
    } elseif($return_type==2) {
        $result['width'] = $size[0];
        $result['height'] = $size[1];
        return $result;
    } else {
        //width="1024" height="891"
        return $size[3];
    }
}
