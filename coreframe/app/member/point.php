<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/3/13
 * Time: 10:12
 */
defined('IN_WZ') or exit('No direct script access allowed');
class point
{
    public function __construct()
    {
        $status = load_class('authentication',M);
        if( ! $status->checkLogin() ){
            header('Location: index.php?m=member&f=sign&v=login');
        }
        $this->db = load_class('db');
        $this->Response = load_class('jsonResponse');
        $this->uid = $_SESSION['_uid'];
    }

    public function lists()
    {
        $totalWhere = '`uid`='.$this->uid;
        //总积分
        $total = [];
        $total['total'] = $this->db->count('credit', $totalWhere, 'SUM(point) AS total');
        //本年度积分
        $yearWhere = '`uid`='.$this->uid.  ' AND YEAR(FROM_UNIXTIME(addtime))=YEAR(CURDATE())';
        $total['year'] = $this->db->count('credit', $yearWhere, 'SUM(point) AS year');
        //本月积分
        $monthWhere = '`uid`='.$this->uid. ' AND YEAR(FROM_UNIXTIME(addtime))=YEAR(CURDATE()) AND MONTH(FROM_UNIXTIME(addtime))=MONTH(CURDATE())';
        $total['month'] = $this->db->count('credit', $monthWhere, 'SUM(point) AS month');
        //当天积分
        $dayWhere = '`uid`='.$this->uid. ' AND DATE(FROM_UNIXTIME(addtime))=CURDATE()';
        $total['day'] = $this->db->count('credit', $monthWhere, 'SUM(point) AS day');

        include T('member','point',TPLID);
    }
    public function getLists()
    {
        $page     = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page     = max($page, 1);
        $pagesize = 15;
        $order    = "addtime DESC";
        $where    = "uid=".$this->uid;
        $points   = $this->db->get_list('credit', $where, '*', 0, $pagesize, $page, $order);
        foreach ($points as $k=>$v) {
            $points[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }
        $count    = $this->db->number;
        $count    = isset($count) ? intval($count) : 0;
        $this->Response->exitJson('加载成功', 0, $count, $points);
    }

}