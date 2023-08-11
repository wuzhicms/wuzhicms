<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 15:13
 */
defined('IN_WZ') or exit('No direct script access allowed');
class set_up{
    public function __construct()
    {
        $this->db = load_class('db');
    }

    public function up(){
        $content_id = isset($GLOBALS['id']) ? intval($GLOBALS['id']) : 0;
        $user_id = isset($GLOBALS['userid']) ? intval($GLOBALS['userid']) : 0;
        $title = isset($GLOBALS['title']) ? $GLOBALS['title'] : '';
        $signage = isset($GLOBALS['signage']) ? intval($GLOBALS['signage']) : '';

        $record = array(
            'content_id'=>$content_id,
            'signage'=>$signage,
            'user_id'=>$user_id,
            'addtime'=>SYS_TIME,
            'title'=>$title,
            'status'=>1
        );
        $res = $this->db->insert('thumbs_up_record',$record);
        if($res){
            $res_c = $this->db->get_one('thumbs_up',array('content_id'=>$content_id,'signage'=>$signage));
            if($res_c){
                $temp = '`sum`=sum+1';
                $result = $this->db->update('thumbs_up',$temp,array('content_id'=>$content_id,'signage'=>$signage));
            }else{
                $result = $this->db->insert('thumbs_up',array('content_id'=>$content_id,'sum'=>1,'addtime'=>SYS_TIME,'signage'=>$signage));
            }
        }
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    }
    public function revocation(){

        $content_id = $GLOBALS['content_id'];
        $signage = isset($GLOBALS['signage']) ? intval($GLOBALS['signage']) : '';
        $where = array('content_id'=>$content_id,'signage'=>$signage);
        $result = $this->db->get_one('thumbs_up',$where,'sum');
        if($result){
            echo $result['sum'];
        }else{
            echo 0;
        }
    }


}