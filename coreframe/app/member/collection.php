<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/3/11
 * Time: 15:25
 */
defined('IN_WZ') or exit('No direct script access allowed');
class collection
{
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
        include T('member','collection',TPLID);
    }

    public function getCollectionList()
    {
        $page       = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page       = max($page, 1);
        $pagesize   = 20;
        $where      = array('uid' => $this->uid);
        $collection = $this->commonList($where, $page, $pagesize);
        $count = isset($collection['number']) ? intval($collection['number']) : 0;
        $list  = $collection['list'];
        $this->Response->exitJson('加载成功', 0, $count, $list);
    }

    protected function commonList($where, $page = 1, $pagesize = 100)
    {
        $order    = 'addtime DESC';
        $result   = $this->db->get_list('collection', $where, 'id,title,addtime,url', 0, $pagesize, $page, $order);
        foreach ($result as $k => $v) {
            $result[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }
        $number = $this->db->number;
        $data   = array('number' => $number, 'list' => $result);
        return $data;
    }
    public function delete()
    {
        $id = $GLOBALS['id'];
        $this->db->delete( 'collection', array('id' => $id) );
        $this->Response->exitJson('删除成功');

    }

}