<?php
/**
 * Created by PhpStorm.
 * User: 86186
 * Date: 2020/2/22
 * Time: 17:39
 */
defined('IN_WZ') or exit('No direct script access allowed');

load_class('session');
class centre
{
    public function __construct()
    {
        $status = load_class('authentication',M);
        $this->db = load_class('db');


        if( ! $status->checkLogin() ){
            header('Location: index.php?m=member&f=sign&v=login');
        }

    }

    public function index()
    {
        $user = $this->db->get_one( 'member',array('uid'=>$_SESSION['_uid'] ) );
        $username = $user['username'];
        include  T('member','index',TPLID);
    }

    public function home()
    {
        $user = $this->db->get_one( 'member',array('uid'=>$_SESSION['_uid'] ) );
        $username = $user['username'];
        include T('member','home');
    }

    public function console()
    {
        include  T('member','console',TPLID);
    }
}