<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/23 0023
 * Time: 14:05
 */
load_class('admin');
class infopush extends WUZHI_admin
{
    private $db;
    private $jddb;
    private $categorys = array(
        43 => '网络安全防护中心',
        32 => '部队新闻',
    );

    function __construct()
    {
        $this->db = load_class('db');
        $this->jddb = new WUZHI_db('mysql_jd_config');
    }

    function push()
    {
        $id = intval($GLOBALS['id']);
        $cid = intval($GLOBALS['cid']);
        if(isset($GLOBALS['submit']) && !empty($GLOBALS['submit'])){
            $data = $this->db->get_one('content_share',array('id'=>$id));
            $dataAttached = $this->db->get_one('news_data',array('id'=>$id));
            $thumb = strstr($data['thumb'],'/uploadfile');
            $formdata = [];
            $formdata = [
                'cid' => $cid,
                'title' => $data['title'],
                'thumb' => $thumb,
                'remark' => $data['remark'],
                'modelid' => $data['modelid'],
                'status' => '1',
                'publisher' => $data['publisher'],
                'addtime' => SYS_TIME,
                'updatetime' => SYS_TIME,
                'signature' =>$data['signature'],
                'videosRemote' => $data['videosRemote'],
            ];

            $contengId = $this->jddb->insert('content_share',$formdata);
            $url = "http://xxtxjd.qjw.zy/news/$cid/$contengId.html";
            $this->jddb->update('content_share',array('url'=>$url),array('id'=>$contengId));
            $formdataAttached = [
                'id' => $contengId,
                'content' => $dataAttached['content'],
                'copyfrom' => 18,
            ];
            $this->jddb->insert('news_data',$formdataAttached);
            echo '推送成功';
        }else{
            include $this->template('infopush');
        }
    }





}