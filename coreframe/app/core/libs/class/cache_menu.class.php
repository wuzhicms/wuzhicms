<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 缓存菜单
 */
class WUZHI_cache_menu {
	private $db;
	public function __construct() {
		$db = load_class('db');
		$where = "`display` IN(1,2)";
		$result = $db->get_list('menu', $where, 'menuid,name', 0, 2000, 0, 'menuid ASC', '', 'menuid');

		$data = '<?php'."\r\n";
        foreach ($result as $key => $value) {
            $data .= '$MENU['.$key.']='."'$value[name]';\r\n";
        }
		file_put_contents(COREFRAME_ROOT.'languages/zh-cn/admin_menu.lang.php', $data);
	}
}