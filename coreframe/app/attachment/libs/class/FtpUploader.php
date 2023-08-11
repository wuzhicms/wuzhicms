<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/10
 * Time: 14:05
 */
defined('IN_WZ') or exit('No direct script access allowed');
class FtpUploader
{
    private static $img_ext = array('jpg','jpeg','png','gif');
    private static $ftp_host = '123.57.5.67';
    private static $ftp_user = 'wuzhi';
    private static $ftp_pwd = 'wuzhi@2020';
    private static $ftp_port = 21;
    private static $ftp_timeout = 30;
    private $link;


    function __construct()
    {

    }

    /**
     * connect filesystem by FTP.
     * @return bool
     *
     */
    function connect()
    {
        $this->link = @ftp_connect(self::$ftp_host,self::$ftp_port,self::$ftp_timeout);
        if(! $this->link){
            return false;
        }
        if(!@ftp_login($this->link,self::$ftp_user,self::$ftp_pwd)){
            return false;
        }
        //ftp_pasv($this->link,true);
        if(@ftp_get_option($this->link,FTP_TIMEOUT_SEC) < self::$ftp_timeout){
            @ftp_set_option($this->link,FTP_TIMEOUT_SEC,self::$ftp_timeout);
        }

        return true;
    }

    function checkFtpConnect()
    {

    }


}