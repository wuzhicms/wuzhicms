<?php

/// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * 生成sql模板 eg  php bin/sqlgenerate.php
 */
require 'command.php';
echo WWW_ROOT;
$sql_path = WWW_ROOT . 'upgrade/migrations/' .VERSION."/".time().".sql";
$sql_create_date = date('Y-m-d H:i:s');

$sql_file = fopen($sql_path, "w") or die("Unable to generate sql file!");;
fwrite($sql_file, "//+----------------------------------------------------------------------\n");
fwrite($sql_file, "// | wuzhicms [ 五指互联网站内容管理系统 ]\n");
fwrite($sql_file, "// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.\n");
fwrite($sql_file, "// | Licensed ( http://www.wuzhicms.com/licenses/ )\n");
fwrite($sql_file, "// | Licensed ( http://www.wuzhicms.com/licenses/ )\n");
fwrite($sql_file, "// | Author: wangcanjia <phpip@qq.com>\n");
fwrite($sql_file, "// | createTime: {$sql_create_date}\n");
fwrite($sql_file, "//+----------------------------------------------------------------------\n");
fclose($sql_file);

echo "模板已生成, 路径: {$sql_path}\n";