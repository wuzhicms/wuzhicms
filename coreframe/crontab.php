<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------

/**
 * 定时计划任务入口
 */

require 'configs/wz_config.php';

//判断配置是否正确

if(!file_exists(WWW_ROOT.'configs/web_config.php')) exit('/coreframe/configs/wz_config.php config error!');

//-------------------------------------------------
/*
php /workspace/wwwroot/dev.phpip.cn/src/coreframe/crontab.php modulename file --help --dest=/var/ -result1 -result2 --option mew arf moo -z
Array
(
    [input] => Array
        (
            [0] => modulename
            [1] => file
        )

    [commands] => Array
        (
            [help] => 1
            [dest] => /var/
            [option] => mew arf moo
        )

    [flags] => Array
        (
            [0] => result1
            [1] => result2
            [2] => z
        )

)

*/

if(PHP_VERSION < '5.2.0') die('Require PHP > 5.2.0 ');

if(PHP_SAPI!=='cli') {
    exit("Error:Only support cli!\n");
}
require WWW_ROOT.'configs/web_config.php';
require COREFRAME_ROOT.'core.php';

function _arguments($args) {
    array_shift( $args );
    $args = join( $args, ' ' );

    preg_match_all('/ (--\w+ (?:[= ] [^-]+ [^\s-] )? ) | (-\w+) | (\w+) /x', $args, $match );
    $args = array_shift( $match );

    $ret = array(
        'input'    => array(),
        'commands' => array(),
        'flags'    => array()
    );

    foreach ( $args as $arg ) {

        // Is it a command? (prefixed with --)
        if ( substr( $arg, 0, 2 ) === '--' ) {

            $value = preg_split( '/[= ]/', $arg, 2 );
            $com   = substr( array_shift($value), 2 );
            $value = join($value);

            $ret['commands'][$com] = !empty($value) ? $value : true;
            continue;

        }

        // Is it a flag? (prefixed with -)
        if ( substr( $arg, 0, 1 ) === '-' ) {
            $ret['flags'][] = substr( $arg, 1 );
            continue;
        }

        $ret['input'][] = $arg;
        continue;

    }

    return $ret;
}

$_argv = _arguments( $argv );

if(isset($_argv['input'][0])) {
    define('M',$_argv['input'][0]);
} else {
    MSG('app does not define!');
}

if(isset($_argv['input'][1])) {
    define('F',$_argv['input'][1]);
} else {
    MSG('control file does not define!');
}

$crontab_file = COREFRAME_ROOT.'crontab/'.M.'/'.F.'.php';
if(file_exists($crontab_file)) {
    include $crontab_file;
} else {
    M("Control file does not exists!\r\n\t".$crontab_file);
}
?>