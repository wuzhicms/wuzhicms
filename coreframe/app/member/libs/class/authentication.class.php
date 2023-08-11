<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/22
 * Time: 21:30
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('session');

class WUZHI_authentication
{
    public function __construct()
    {

    }

    public function checkLogin()
    {
        if( ! $_SESSION['_uid'] || !isset($_SESSION['_uid']) ){
            return false;
        }else{
            return true;
        }
    }

}