<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 安装程序
 */
set_time_limit(300);
//检测PHP环境
if(PHP_VERSION < '5.2.0') die('PHP配置需要大于 5.2.0 ');
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);


//定义当前的网站物理路径
define('INSTALL_ROOT',dirname(__FILE__).'/');

define('WWW_ROOT',str_replace('\\','/',substr(INSTALL_ROOT,0,-8)));
$reinstall = '';
if(!file_exists(WWW_ROOT.'configs/web_config.php')) {
    $reinstall = 'default_';
}
$web_configfile = WWW_ROOT.'configs/'.$reinstall.'web_config.php';
if(!file_exists($web_configfile)) exit('文件不存在：'.$web_configfile);

$step = isset($_GET['step']) ? intval($_GET['step']) : 1;
$step = max(1,$step);
$support = true;
$charset = 'utf-8';
$dbcharset = 'utf8';

header('Content-type: text/html; charset='.$charset);

$best_iframe = substr(INSTALL_ROOT,0,-12).'coreframe/';
$best_cache = substr(INSTALL_ROOT,0,-12).'caches/';

if(file_exists($best_cache.'install.check')) {
    $current_cache = $best_cache;
} elseif(file_exists(WWW_ROOT.'caches/install.check')) {
    $current_cache = WWW_ROOT . 'caches/';
} else {
    exit('caches 缓存目录不存在');
}
if(file_exists($best_iframe.'core.php')) {
    $current_iframe = $best_iframe;
} elseif(file_exists(WWW_ROOT.'coreframe/core.php')) {
    $current_iframe = WWW_ROOT.'coreframe/';
}
if(file_exists($current_cache.'lock.install')) exit('已经安装过wuzhicms，如需重装请删除caches/lock.install');

function get_cfg($var,$type=0,$must = 1) {
    switch ($result = get_cfg_var($var)) {
        case 0:
            if($must) $support = false;
            return '<div class="error"></div>';
            break;
        case 1:
            return '<div class="right"></div>';
            break;
        default:
            return $result;
            break;
    }
}
function get_func($var,$type = 0,$must = 1) {
    if(function_exists($var)) {
        if($type) {
            return '支持';
        } else {
            return '<div class="right"></div>';
        }
    } else {
        if($must) $support = false;
        if($type) {
            return '不支持';
        } else {
            return '<div class="error"></div>';
        }
    }
}
function is_email($email) {
    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

function set_config($res,$key,$value) {
    $res = preg_replace("/define\('$key',([0-9a-z\/\,\._':]+)\);/is","define('$key',$value);",$res);
    return $res;
}

function install_rand($length, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

function sql_execute($link,$sql,$tablepre = '') {
    global $dbcharset;
    $sql = preg_replace("/ENGINE=(InnoDB|MyISAM|MEMORY) DEFAULT CHARSET=([^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$dbcharset,$sql);
    if($tablepre != 'wz_') $sql = str_replace('`wz_', '`'.$tablepre, $sql);
    $sql = str_replace("\r", "\n", $sql);
    $ret = array();
    $num = 0;
    $queriesarray = explode(";\n", trim($sql));
    unset($sql);
    foreach($queriesarray as $query) {
        $ret[$num] = '';
        $queries = explode("\n", trim($query));
        $queries = array_filter($queries);
        foreach($queries as $query) {
            $str1 = substr($query, 0, 1);
            if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
        }
        $num++;
    }

    if(is_array($ret)) {
        foreach($ret as $sql) {
            if(trim($sql) != '') {
                //echo $sql."\r\n";

                if(mysql_query($sql,$link)) {

                } else {
                    mysql_error();
                }
            }
        }
    } else {
        if(mysql_query($ret,$link)) {

        } else {
            mysql_error();
        }
    }
    return true;
}

function import_sql($id){
    global $dbcharset;
    $db = include WWW_ROOT.'configs/mysql_config.php';
    $db = $db['default'];
    $link = mysql_connect($db['dbhost'], $db['username'], $db['password']) or die ('Not connected : ' . mysql_error());
    $version = mysql_get_server_info();
    mysql_query("SET NAMES '$dbcharset'",$link);

    if($version > '5.0') {
        mysql_query("SET sql_mode=''");
    }
    mysql_select_db($db['dbname']);
    if(file_exists(WWW_ROOT."install/sql/install-$id.sql")) {
        $sql = file_get_contents(WWW_ROOT."install/sql/install-$id.sql");
        sql_execute($link,$sql,$db['tablepre']);
    }
}


function edit_filename($dir,$cache_ext) {
    global $current_cache;
    if(is_dir($dir)) {
        if($dir == $current_cache.'templates') {
            return '';
        }
        $tmp = glob($dir.'/*');
        if($tmp!==false){
            foreach($tmp as $t) {
                edit_filename($t,$cache_ext);
            }
        }
    } else {
        $filename = basename($dir);
        if(strpos($filename,'H_1_a')!==false) {
            $name = str_replace('H_1_a',$cache_ext,$filename);
            if(is_writable($dir)) {
                rename($dir,dirname($dir).'/'.$name);
            } else {
                return false;
            }
        }
    }
}
switch($step) {
    case 1:

        break;
    case 2:


        if(file_exists($best_iframe.'core.php')) {
            $current_iframe = $best_iframe;
            $iframe_status = '<div class="right"></div>';
        } elseif(file_exists(WWW_ROOT.'coreframe/core.php')) {
            $current_iframe = WWW_ROOT.'coreframe/';
            $iframe_status = '<div class="right"></div>';
        } else {
            $iframe_status = '<div class="error"></div>';
            $current_iframe = '</div><div class="error-div">未找到核心目录</div>';
        }
        if($best_iframe==$current_iframe) {
            $best_iframe_status = '=';
        } else {
            $best_iframe_status = '≠';
        }

        if(file_exists($best_cache.'install.check')) {
            $current_cache = $best_cache;
            $cache_status = '<div class="right"></div>';
        } elseif(file_exists(WWW_ROOT.'caches/install.check')) {
            $cache_status = '<div class="right"></div>';
            $current_cache = WWW_ROOT.'caches/';
        } else {
            $cache_status = '<div class="error"></div>';
            $current_cache = '<div class="error-div">未找到缓存目录</div>';
        }
        if($best_cache==$current_cache) {
            $best_cache_status = '=';
        } else {
            $best_cache_status = '≠';
        }
        //php
        //可写目录文件检查
        $filelist = array();
        if(!is_writable(WWW_ROOT.'index.html')) {
            $filelist[] = WWW_ROOT.'index.html';
        }
        if(!is_writable(WWW_ROOT.'configs/'.$reinstall.'web_config.php')) {
            $filelist[] = WWW_ROOT.'configs/'.$reinstall.'web_config.php';
        }
        if(!is_writable(WWW_ROOT.'configs/'.$reinstall.'mysql_config.php')) {
            $filelist[] = WWW_ROOT.'configs/'.$reinstall.'mysql_config.php';
        }
        if(!is_writable(WWW_ROOT.'configs/'.$reinstall.'uc_mysql_config.php')) {
            $filelist[] = WWW_ROOT.'configs/'.$reinstall.'uc_mysql_config.php';
        }
        if(!is_writable(WWW_ROOT.'configs/'.$reinstall.'weixin_config.php')) {
            $filelist[] = WWW_ROOT.'configs/'.$reinstall.'weixin_config.php';
        }
        if(!is_writable(WWW_ROOT.'configs/'.$reinstall.'route_config.php')) {
            $filelist[] = WWW_ROOT.'configs/'.$reinstall.'route_config.php';
        }
        if(!is_writable($current_iframe.'configs/'.$reinstall.'wz_config.php')) {
            $filelist[] = $current_iframe.'configs/'.$reinstall.'wz_config.php';
        }
        if(!is_writable($current_cache)) {
            $filelist[] = $current_cache;
        }
        if(!is_writable($current_cache.'model/content_add.H_1_a.php')) {
            $filelist[] = '重新安装需要删除caches/目录，重新上传';
            $filelist[] = $current_cache.'*';
        }
        if(!is_writable(WWW_ROOT.'uploadfile')) {
            $filelist[] = WWW_ROOT.'uploadfile';
        }
        if(!is_writable(WWW_ROOT.'uploadfile/qr_image/mobile.png')) {
            $filelist[] = WWW_ROOT.'uploadfile/qr_image/mobile.png';
        }
        if(!empty($filelist)) $support = false;
        break;
    case 3:
        if(isset($_POST['admin_username'])) {
            extract($_POST,EXTR_SKIP);
            if(empty($admin_username)) exit('5');
            if(empty($admin_password)) exit('6');
            if($admin_password!=$repassowrd) exit('8');
            if(empty($admin_email)) exit('7');
            if(!is_email($admin_email)) exit('9');

            if(!@mysql_connect($dbhost, $username, $password)) {
                exit('2');
            }

            if(!mysql_select_db($dbname)) {
                if(!@mysql_query("CREATE DATABASE `$dbname`")) exit('3');
                mysql_select_db($dbname);
            }
            $tables = array();
            $query = mysql_query("SHOW TABLES FROM `$dbname`");
            while($r = mysql_fetch_row($query)) {
                $tables[] = $r[0];
            }


            $datas = $_POST;
            $datas['cache_ext'] = install_rand(5);
            $datas = '<?php'."\r\n return ".var_export($datas, TRUE).'?>';
            file_put_contents($current_cache.'install_cache.php',$datas);
            if($tables && in_array($tablepre.'admin', $tables)) {
                exit('1');
            } else {
                exit('ok');
            }
            exit;
        }
        break;
    case 4:
        if(isset($_GET['startid'])) {
            $startid = intval($_GET['startid']);
            $startid = max($startid,1);
            $configs = include ($current_cache.'install_cache.php');
            switch($startid) {
                case 1://mysql_config.php
                    if (function_exists('mysqli_connect') && version_compare(PHP_VERSION, '5.5.0') >= 0) {
                        $type = 'mysqli';
                    } else {
                        $type = 'mysql';
                    }
                    $config = array (
                        'default' => array (
                            'dbhost' => ''.$configs['dbhost'].'',
                            'dbname' => ''.$configs['dbname'].'',
                            'username' => ''.$configs['username'].'',
                            'password' => ''.$configs['password'].'',
                            'tablepre' => ''.$configs['tablepre'].'',
                            'dbcharset' => ''.$dbcharset.'',
                            'type' => $type,
                            'pconnect' => 0,
                        ),
                    );
                    $data = '<?php'."\r\n defined('IN_WZ') or exit('No direct script access allowed');\r\nreturn ".var_export($config, TRUE)."\r\n?>";

                    file_put_contents(WWW_ROOT.'configs/'.$reinstall.'mysql_config.php',$data);
                    if($reinstall) {
                        rename(WWW_ROOT.'configs/'.$reinstall.'mysql_config.php',WWW_ROOT.'configs/mysql_config.php');
                        rename(WWW_ROOT.'configs/'.$reinstall.'uc_mysql_config.php',WWW_ROOT.'configs/uc_mysql_config.php');
                        rename(WWW_ROOT.'configs/'.$reinstall.'weixin_config.php',WWW_ROOT.'configs/weixin_config.php');
                        rename(WWW_ROOT.'configs/'.$reinstall.'route_config.php',WWW_ROOT.'configs/route_config.php');
                    }
                    echo '1';
                    break;
                case 2://开始配置文件：coreframe/configs/wz_config.php
                    $res = file_get_contents($current_iframe.'configs/'.$reinstall.'wz_config.php');
                    $res = set_config($res,'WWW_ROOT',"'".WWW_ROOT."'");
                    file_put_contents($current_iframe.'configs/'.$reinstall.'wz_config.php',$res);
                    if($reinstall) {
                        rename($current_iframe.'configs/'.$reinstall.'wz_config.php',$current_iframe.'configs/wz_config.php');
                    }

                    echo '2';
                    break;
                case 3://web_config.php
                    $res = file_get_contents(WWW_ROOT.'configs/'.$reinstall.'web_config.php');

                    $res = set_config($res,'COREFRAME_ROOT',"'".$current_iframe."'");
                    $res = set_config($res,'CACHE_ROOT',"'".$current_cache."'");
                    $randstr = $configs['cache_ext'];
                    $res = set_config($res,'CACHE_EXT',"'".$randstr."'");
                    $PHP_SELF = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : (isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['ORIG_PATH_INFO']);
                    $www_path = str_replace('\\','/',dirname($PHP_SELF));
                    $www_path = substr($www_path,0,-7);
                    $www_path = strlen($www_path)>1 ? $www_path : "/";
                    $res = set_config($res,'WWW_PATH',"'".$www_path."'");

                    $http_url = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
                    if(isset($_SERVER['HTTP_HOST'])) {
                        $http_url .= $_SERVER['HTTP_HOST'];
                    } else {
                        $http_url .= $_SERVER["SERVER_NAME"];
                    }

                    if(isset($_SERVER['REQUEST_URI'])) {
                        $http_url .= $_SERVER['REQUEST_URI'];
                    } else {
                        if(isset($_SERVER['PHP_SELF'])) {
                            $http_url .= $_SERVER['PHP_SELF'];
                        } else {
                            $http_url .= $_SERVER['SCRIPT_NAME'];
                        }
                    }
                    $pos = strripos($http_url,'/');
                    $weburl = substr($http_url,0,$pos-7);

                    $res = set_config($res,'WEBURL',"'".$weburl."'");
                    $cookie_pre =install_rand(3, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
                    $res = set_config($res,'COOKIE_PRE',"'".$cookie_pre."_'");
                    $res = set_config($res,'ATTACHMENT_URL',"'".$weburl."uploadfile/'");
                    $res = set_config($res,'R',"'".$weburl."res/'");
                    $key1 =install_rand(1, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
                    $key2 =install_rand(7);
                    $res = set_config($res,'_KEY',"'".$key1.$key2."'");
                    $res = set_config($res,'CHARSET',"'".$charset."'");

                    file_put_contents(WWW_ROOT.'configs/'.$reinstall.'web_config.php',$res);
                    if($reinstall) {
                        rename(WWW_ROOT.'configs/'.$reinstall.'web_config.php',WWW_ROOT.'configs/web_config.php');
                    }
                    echo '3';
                    break;
                case 4://开始导入数据库文件 1
                    define('IN_WZ',true);
                    import_sql(1);
                    echo '4';
                    break;
                case 5://开始导入数据库文件 2
                    define('IN_WZ',true);
                    import_sql(2);
                    echo '5';
                    break;
                case 6://开始导入数据库文件 3
                    define('IN_WZ',true);
                    import_sql(3);
                    echo '6';
                    break;
                case 7://开始初始化数据
                    define('IN_WZ',true);
                    $db = include WWW_ROOT.'configs/mysql_config.php';
                    $db = $db['default'];
                    $link = mysql_connect($db['dbhost'], $db['username'], $db['password']) or die ('Not connected : ' . mysql_error());
                    $version = mysql_get_server_info();
                    mysql_query("SET NAMES '$dbcharset'",$link);

                    if($version > '5.0') {
                        mysql_query("SET sql_mode=''");
                    }
                    mysql_select_db($db['dbname']);
                    //插入管理员账号
                    $factor = install_rand(6);
                    $password = md5(md5($configs['admin_password']).$factor);
                    mysql_query("INSERT INTO `".$db['tablepre']."member` (`uid`, `ucuid`, `username`, `password`, `factor`, `points`, `money`, `mobile`, `email`, `modelid`, `groupid`, `vip`, `viptime`, `lock`, `locktime`, `regip`, `lastip`, `regtime`, `lasttime`, `loginnum`) VALUES
(1, 0, '".$configs['admin_username']."', '$password', '$factor', 0, '0.00', '0', '".$configs['admin_email']."', 10, 3, 0, 0, 0, 0, '', '127.0.0.1', 0, 0, 0)");
                    mysql_query("INSERT INTO `".$db['tablepre']."member_detail_data` (`uid`) VALUES ('1')");
                    mysql_query("INSERT INTO `".$db['tablepre']."admin` (`uid`, `role`, `truename`, `password`, `factor`, `lang`, `department`, `face`, `email`, `tel`, `mobile`, `remark`) VALUES ('1', '1', '".$configs['admin_username']."', '$password', '$factor', 'zh-cn', '', '', '', '', '', '')");

                    echo '7';
                    break;
                case 8://即将完成安装
                    //修改缓存文件名
                    if(edit_filename(substr($current_cache,0,-1),$configs['cache_ext'])!==false) {
                        echo '8';
                    } else {
                        echo 'cache_error';
                    }

                    break;
                default:
                    echo 'error';
                    break;

            }
            exit;
        }
        break;
    case 5:
        require WWW_ROOT.'configs/web_config.php';

        file_put_contents($current_cache.'lock.install',' ');
        @unlink($current_cache.'install_cache.php');
        break;
}
include INSTALL_ROOT.'steps/step'.$step.'.php';
?>