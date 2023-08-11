<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 采集配置
 */
load_class('admin');

final class index extends WUZHI_admin {

    function __construct() {
        $this->db = load_class('db');
        $this->app_update = load_class('app','appupdate');
    }

    /**
     * 规则列表
     */
    function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);

        $result = $this->db->get_list('collect_config','', '*', 0, 20,$page, 'configid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;

        $status = array('未采集或已完成','采集中');
        $pub_status = array('规则编写中','已发布');

        include $this->template('listing');
    }
    function get_list(){
        $url = 'http://www.qjw.zy/index.php?v=listing&cid=28';
        $rs = file_get_contents($url);

        $preg_title = '/<div\s+class=\"conTit ellipsisB\">(.*)<\/div>/i';
        preg_match_all($preg_title,$rs,$title);

        $rs = preg_replace("/[\t\n\r]+/",'',$rs);


        $preg_time = '/<div[\s]+class=\"conTime\">(.[^<>]+)<span><img/i';
        preg_match_all($preg_time,$rs,$time);

        foreach($title[1] as $k=>$v){
            preg_match_all('/>(.*)</i',$v,$_title);
            preg_match_all('/<a[\s]+href=\"(.*)\">/',$v,$url);
            $result[$k]['title'] = $_title[1][0];
            $result[$k]['addtime'] = $time[1][$k];
            $result[$k]['url'] = $url[1][0];
        }
        include $this->template('listing');
    }
    function get_content(){

        $url = $GLOBALS['url'];
        $url = urldecode($url);

        $rs = file_get_contents($url);
        $rs = preg_replace("/[\t\n\r]+/",'',$rs);

        $pregTitle = '/<div class=\"xlBTit\">(.*?)<\/div>/';
        preg_match_all($pregTitle,$rs,$title);

        $pregContent = '/<div[\s]+class=\"xlBconHTML\">(.*)<!-- xlBconHTML e -->/';
        preg_match_all($pregContent,$rs,$content);

        //替换为本地图片
        load_function('ext','collect');
        $imgUlr =  get_more_image($content[1][0],'http://www.qjw.zy');
        $result = $content[1][0];

        foreach($imgUlr as $k=>$v){
            $result = preg_replace('/<img.*?[\s]src=\"?(.*?\.(jpg|gif|bmp|bnp|png))\".*?/','<IMG src='.$v['url'],$result,1);
        }

        preg_match_all('/<video.*?src=[\'"]?([^\'" ]*)[\'"]?/i',$result,$video);
        if(isset($video) && !empty($video)){
            $video = 'http://www.qjw.zy'.$video[1][0];
            $video = '<video id="videoctr" controls="controls" preload="preload" autoplay="autoplay" src="'.$video.'" style="width: 100%; ">';
            $result = preg_replace('/<video.*?src=[\'"]?([^\'" ]*)[\'"]?/i',$video,$result);
        }

        $contentOut = [
            'title' => $title[1][0],
            'content' => $result,
        ];
        $cid = 35;
        $formdata = [
            'cid' => $cid,
            'title' => $this->change($contentOut['title']),
            'remark' => strip_tags(substr($contentOut['content'],0,200)),
            'modelid' => 1,
            'status' => '9',
            'publisher' => get_cookie('username'),
            'addtime' => SYS_TIME,
            'updatetime' => SYS_TIME,
        ];

        $contengId = $this->db->insert('content_share',$formdata);
        $url = "http://zhsqjw.ht/show-".$cid."-".$contengId.".html";
        $this->db->update('content_share',array('url'=>$url),array('id'=>$contengId));
        $formdataAttached = [
            'id' => $contengId,
            'content' => rtrim($contentOut['content'],'<p><br/></p>'),
            'copyfrom' => 1,
        ];
        $this->db->insert('news_data',$formdataAttached);
        MSG('采集成功',HTTP_REFERER);

    }

    function change($str){
        $result = str_replace('&ldquo;',"“",$str);
        $result = str_replace('&rdquo;',"”",$result);
        return $result;
    }
}
?>