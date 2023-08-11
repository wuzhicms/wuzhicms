<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/2/22
 * Time: 17:39
 */
defined('IN_WZ') or exit('No direct script access allowed');

class message
{
    private  $uid;
    public function __construct()
    {
        $status = load_class('authentication',M);
        if( ! $status->checkLogin() ){
            header('Location: index.php?m=member&f=sign&v=login');
        }
        $this->db  = load_class('db');
        $this->uid = $_SESSION['_uid'];
        $this->Response = load_class('jsonResponse');

    }

    public function listing()
    {
        include  T('member','message',TPLID);
    }

    public function detail()
    {
        include  T('member','messageDetail',TPLID);
    }

    public function getAllList()
    {
        try {
            if (!$this->uid)
                throw new Exception('参数错误', 0);
            if (intval($GLOBALS['msgtype']) === 1) {
                $where  = array('msgtype' => 1);
            } elseif (intval($GLOBALS['msgtype']) === 2) {
                $where = array('msgtype' => 0, 'touid' => $this->uid);
            } else {
                $where = '`touid`='. $this->uid . ' OR  `msgtype`=1';
            }
            $pageNo = $GLOBALS['pageNo'];
            $pageSize = $GLOBALS['pageSize'];
            $this->list  = $this->db->get_list('message', $where, '*', $pageNo*$pageSize, 100000, $pageNo);
            $this->count = $this->db->number;
            throw new Exception('加载成功', 0);
        } catch (Exception $e) {
            $code    = $e->getCode();
            $message = $e->getMessage();
            $count   = $this->count;
            $data    = $this->list;

            $this->Response->json( array('code' => $code, 'msg' => $message, 'count' => $count, 'data' => $data) );
        }
    }

    public function getMessageDetail()
    {
        try {
            $id      = $GLOBALS['id'];
            $where   = array('id' => $id);
            $this->message = $this->db->get_one('message', $where);
            throw new Exception('请求成功', 0);
        } catch (Exception $e) {
            $code    = $e->getCode();
            $message = $e->getMessage();
            $data    = $this->message;

            $this->Response->json( array('code' => $code, 'msg' => $message, 'data' => $data) );
        }


    }
}