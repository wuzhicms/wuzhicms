<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/2/10
 * Time: 14:05
 */
defined('IN_WZ') or exit('No direct script access allowed');
class WUZHI_FtpUploader
{

/*    private static $ftp_host = '123.57.5.67';
    private static $ftp_user = 'wuzhi';
    private static $ftp_pwd = 'wuzhi@2020';
    private static $ftp_port = 21;
    private static $ftp_timeout = 30;*/
    private $link;
    private static $img_ext = array('jpg','jpeg','png','gif');
    private $formatName = '{yyyy}/{mm}/{dd}/{time}{rand:6}';


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
        $configs = get_config('ftp_config');
        $config = $configs['default'];

        $this->link = @ftp_connect($config['ftp_host'],$config['ftp_port'],$config['ftp_timeout']);
        if(! $this->link){
            return false;
        }
        if(!@ftp_login($this->link,$config['ftp_user'],$config['ftp_pwd'])){
            return false;
        }
        //解决了ftp_nlist返回false问题
        ftp_set_option($this->link, FTP_USEPASVADDRESS, false);
        ftp_pasv($this->link,true);
        if(@ftp_get_option($this->link,FTP_TIMEOUT_SEC) < $config['ftp_timeout']){
            @ftp_set_option($this->link,FTP_TIMEOUT_SEC,$config['ftp_timeout']);
        }

        return true;
    }

    public function putContents($file,$contents,$model = false)
    {
        $tempfile = tempnam(WWW_ROOT.'uploadfile','ftp_');
        $temp = fopen($tempfile,'wb+');

        if(!$temp){
            unlink($tempfile);
            return false;
        }

        $dataLength   = strlen($contents);
        $bytesWritten = fwrite($temp,$contents);

        if($dataLength !== $bytesWritten){
            fclose($temp);
            unlink($tempfile);
            return false;
        }

        fseek($temp,0);

        $res = ftp_fput($this->link,$file,$temp,FTP_BINARY);

        fclose($temp);
        unlink($tempfile);
        $this->chmod($file,$model);

        return $res;
    }
    public function chmod($file, $mode = false, $recursive = false)
    {
        if(!$mode){
            if( $this->is_file($file) ){
                $mode = 0777;
            }elseif ( $this->is_dir($file) ){
                $mode = 0777;
            }else{
                return false;
            }
        }

        if( $recursive && $this->is_dir($file) ){

            $fileList = $this->directoryList($file);
            foreach($fileList as $filename => $filemate){
                $this->chmod($file . '/' . $filename, $mode, $recursive);
            }

        }

        return ftp_chmod($this->link, $mode, $file);
        
    }

    function directoryList($path = '.', $include_hidden = true, $recursive = false)
    {
        if( $this->is_file($path) ){
            $limit_file = basename($path);
            $path = dirname($path). '/';
        }else{
            $limit_file = false;
        }

        $pwd = ftp_pwd($this->link);
        //Can't change to folder = folder doesn't exist.
        if( ! @ftp_chdir($this->link,$path) ){
            return false;
        }

        $list = ftp_rawlist($this->link,'-a',false);
        @ftp_chdir($this->link,$pwd);

        if( empty($list) ){
            return false;
        }
        $dirlist = array();
        foreach ( $list as $k => $v ) {
            $entry = $this->parselisting( $v );
            if ( empty( $entry ) ) {
                continue;
            }

            if ( '.' == $entry['name'] || '..' == $entry['name'] ) {
                continue;
            }

            if ( ! $include_hidden && '.' == $entry['name'][0] ) {
                continue;
            }

            if ( $limit_file && $entry['name'] != $limit_file ) {
                continue;
            }

            $dirlist[ $entry['name'] ] = $entry;
        }

        $ret = array();
        foreach ( (array) $dirlist as $struc ) {
            if ( 'd' == $struc['type'] ) {
                if ( $recursive ) {
                    $struc['files'] = $this->dirlist( $path . '/' . $struc['name'], $include_hidden, $recursive );
                } else {
                    $struc['files'] = array();
                }
            }

            $ret[ $struc['name'] ] = $struc;
        }
        return $ret;
    }
    public function parselisting( $line ) {
        static $is_windows = null;
        if ( is_null( $is_windows ) ) {
            $is_windows = stripos( ftp_systype( $this->link ), 'win' ) !== false;
        }

        if ( $is_windows && preg_match( '/([0-9]{2})-([0-9]{2})-([0-9]{2}) +([0-9]{2}):([0-9]{2})(AM|PM) +([0-9]+|<DIR>) +(.+)/', $line, $lucifer ) ) {
            $b = array();
            if ( $lucifer[3] < 70 ) {
                $lucifer[3] += 2000;
            } else {
                $lucifer[3] += 1900; // 4-digit year fix.
            }
            $b['isdir'] = ( $lucifer[7] == '<DIR>' );
            if ( $b['isdir'] ) {
                $b['type'] = 'd';
            } else {
                $b['type'] = 'f';
            }
            $b['size']   = $lucifer[7];
            $b['month']  = $lucifer[1];
            $b['day']    = $lucifer[2];
            $b['year']   = $lucifer[3];
            $b['hour']   = $lucifer[4];
            $b['minute'] = $lucifer[5];
            $b['time']   = mktime( $lucifer[4] + ( strcasecmp( $lucifer[6], 'PM' ) == 0 ? 12 : 0 ), $lucifer[5], 0, $lucifer[1], $lucifer[2], $lucifer[3] );
            $b['am/pm']  = $lucifer[6];
            $b['name']   = $lucifer[8];
        } elseif ( ! $is_windows ) {
            $lucifer = preg_split( '/[ ]/', $line, 9, PREG_SPLIT_NO_EMPTY );
            if ( $lucifer ) {
                // echo $line."\n";
                $lcount = count( $lucifer );
                if ( $lcount < 8 ) {
                    return '';
                }
                $b           = array();
                $b['isdir']  = $lucifer[0][0] === 'd';
                $b['islink'] = $lucifer[0][0] === 'l';
                if ( $b['isdir'] ) {
                    $b['type'] = 'd';
                } elseif ( $b['islink'] ) {
                    $b['type'] = 'l';
                } else {
                    $b['type'] = 'f';
                }
                $b['perms']  = $lucifer[0];
                $b['permsn'] = $this->getnumchmodfromh( $b['perms'] );
                $b['number'] = $lucifer[1];
                $b['owner']  = $lucifer[2];
                $b['group']  = $lucifer[3];
                $b['size']   = $lucifer[4];
                if ( $lcount == 8 ) {
                    sscanf( $lucifer[5], '%d-%d-%d', $b['year'], $b['month'], $b['day'] );
                    sscanf( $lucifer[6], '%d:%d', $b['hour'], $b['minute'] );
                    $b['time'] = mktime( $b['hour'], $b['minute'], 0, $b['month'], $b['day'], $b['year'] );
                    $b['name'] = $lucifer[7];
                } else {
                    $b['month'] = $lucifer[5];
                    $b['day']   = $lucifer[6];
                    if ( preg_match( '/([0-9]{2}):([0-9]{2})/', $lucifer[7], $l2 ) ) {
                        $b['year']   = gmdate( 'Y' );
                        $b['hour']   = $l2[1];
                        $b['minute'] = $l2[2];
                    } else {
                        $b['year']   = $lucifer[7];
                        $b['hour']   = 0;
                        $b['minute'] = 0;
                    }
                    $b['time'] = strtotime( sprintf( '%d %s %d %02d:%02d', $b['day'], $b['month'], $b['year'], $b['hour'], $b['minute'] ) );
                    $b['name'] = $lucifer[8];
                }
            }
        }

        // Replace symlinks formatted as "source -> target" with just the source name.
        if ( isset( $b['islink'] ) && $b['islink'] ) {
            $b['name'] = preg_replace( '/(\s*->\s*.*)$/', '', $b['name'] );
        }

        return $b;
    }

    function is_file($file)
    {
        return $this->exists($file) && !$this->is_dir($file);
    }

    public function currentWorkDirectory()
    {
        $cwd = ftp_pwd($this->link);

        if($cwd){
            $cwd = rtrim($cwd,'/\\').'/';
        }

        return $cwd;
    }

    public function is_dir($path)
    {
        $cwd    = $this->currentWorkDirectory();
        $result = @ftp_chdir( $this->link,  rtrim($path,'/\\').'/');
        if ( $result && $path == $this->currentWorkDirectory() || $this->currentWorkDirectory() != $cwd ) {
            @ftp_chdir( $this->link, $cwd );
            return true;
        }
        return false;
    }

    public function mkdir($path,$chmod = false)
    {
        if(empty($path)){
            return false;
        }
        if( !@ftp_mkdir($this->link,$path) ){
            return false;
        }
        return true;
    }

    public function exists($file)
    {
        $list = @ftp_nlist($this->link,$file);
        if( empty($list) && $this->is_dir($file) ){
            return true;
        }
        return !empty($list);
    }

    function checkFtpConnect()
    {



    }
    public function getFullName($file)
    {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->formatName;
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($file, 0, strrpos($file, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt($file);
        return $format . $ext;
    }

    private function getFileExt($file)
    {
        return strtolower(strrchr($file, '.'));
    }










}