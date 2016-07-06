<?php

/// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 升级包制作命令
 */
require 'command.php';

if (count($argv) !== 4) die("use: php bin/build.php code version  diff-file-path  eg. php bin/build.php MAIN 3.0.1 diff-3.0.1\n");

$app = load_class('build_package', $m = 'command');

$app->run($argv[1], $argv[2], $argv[3]);