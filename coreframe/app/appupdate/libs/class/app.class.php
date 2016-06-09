<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') || exit('No direct script access allowed');

/**
 * 系统升级
 */
class WUZHI_app
{
    public function __construct()
    {
        $this->db = load_class('db');
    }

    public function checkAppUpgrades()
    {
        $systemApp = $this->db->get_one('cloud_app', array('code' => 'MAIN'));

        if (empty($systemApp)) {
            $this->addSystemApp();
            $systemApp = $this->db->get_one('cloud_app', array('code' => 'MAIN'));
        }
        return $systemApp;
    }


    private function addSystemApp()
    {
        $system = load_class('system');

        $app = array(
            'code'          => 'MAIN',
            'name'          => 'WUZHICMS',
            'description'   => 'WUZHICMS主系统',
            'icon'          => '',
            'version'       => $system::VERSION,  //可以使用全局定义的 VERSION
            'fromVersion'   => '0.0.0',
            'developerId'   => 1,
            'developerName' => 'WUZHICMS官方',
            'installedTime' => time(),
            'updatedTime'   => time()
        );

        $this->db->insert('cloud_app', $app);
    }

}
