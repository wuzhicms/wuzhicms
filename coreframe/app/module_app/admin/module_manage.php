<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('Access Denied');
/**
 *模板管理
*/
load_class('admin');
load_function('dir','core');
class module_manage extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
		$this->m = isset($GLOBALS['app']) ? $GLOBALS['app'] : 'content';
		$this->core_path = COREFRAME_ROOT.'app/core/fields/';
		$this->m_path = COREFRAME_ROOT.'app/'.$this->m.'/fields/';
	}
    function init() {
        $dirs = $module = $dirs_arr = $directory = array();
        $dirs = glob(COREFRAME_ROOT.'app'.DIRECTORY_SEPARATOR.'*');
        foreach ($dirs as $d) {
            if (is_dir($d)) {
                $d = basename($d);
                $dirs_arr[] = $d;
            }
        }
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('module_app','', '*', 0, 20,$page,'menuid ASC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('module_list');
    }

    /**
     * 模块安装
     */
    public function install(){
        $moduleid = intval($GLOBALS['moduleid']);
        $module_array = $this->db->get_one('module_app', array('menuid' => $moduleid));

        //执行sql语句
        if (!file_exists(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/'.$module_array['m'] . '.sql')) {
            MSG('文件名错误不存在！');
        }
        $sql = file_get_contents(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/'.$module_array['m'] . '.sql');
        if(empty($sql))MSG('SQL文件中必须有其对应的SQL语句，方可安装模块！');
        $this->sql_execute($sql);

        //模板html文件的拷贝
        if(file_exists(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/'.'templates/')){
            dir_copy(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/'.'templates/',COREFRAME_ROOT . 'templates/default/'. $module_array['m'] .'/');
        }

        //更新缓存;
        $uid = $_SESSION['uid'];
        $where = array('keyid'=>'cache_all');
        $result = $this->db->get_list('setting', $where, '*', 0, 100);
        $ids = array();
        foreach($result as $r) {
            $ids[] = $r['id'];
        }
        set_cache('cache_all-'.$uid,$ids);

        //缓存菜单语音包
        load_class('cache_menu');

        $this->db->update('module_app',array('isinstall'=>1),array('menuid'=>$moduleid));
        MSG('模块安装成功',HTTP_REFERER,2000);

    }
    /**
     * 模块卸载
     */
    public function uninstall(){
        $moduleid = intval($GLOBALS['moduleid']);
        $module_array = $this->db->get_one('module_app', array('menuid' => $moduleid));

        //执行sql语句

        //删除模板html文件
        //if(!is_dir(COREFRAME_ROOT . 'templates/default/'. $module_array['m']))MSG('指定文件夹不存在！');
        //创建文件夹
        if (!is_dir(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install')) {

            mkdir(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install');
            mkdir(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/templates');
            fopen(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/'.$module_array['m'] . '.sql','a+');

        }
        if (!is_dir(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/uninstall/')) {

            mkdir(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/uninstall');
            fopen(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/uninstall/'.$module_array['m'] . '.sql','a+');
        }
        if (is_dir(COREFRAME_ROOT . 'templates/default/'. $module_array['m'])){
            dir_copy(COREFRAME_ROOT . 'templates/default/'. $module_array['m'],COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/install/templates');
            dir_delete(COREFRAME_ROOT . 'templates/default/'. $module_array['m']);
        }

        if (!file_exists(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/uninstall/'.$module_array['m'] . '.sql')) {
            MSG('文件名错误不存在！');
        }
        $sql = file_get_contents(COREFRAME_ROOT . 'app/' . $module_array['m'] . '/admin/uninstall/'.$module_array['m'] . '.sql');
        if(empty($sql))MSG('SQL文件中必须有其对应的SQL语句，方可卸载模块！');
        $this->sql_execute($sql);

        //更新模块数据表信息
        $this->db->update('module_app',array('isinstall'=>0),array('menuid'=>$moduleid));



        //更新缓存;
        $uid = $_SESSION['uid'];
        $where = array('keyid'=>'cache_all');
        $result = $this->db->get_list('setting', $where, '*', 0, 100);
        $ids = array();
        foreach($result as $r) {
            $ids[] = $r['id'];
        }
        set_cache('cache_all-'.$uid,$ids);

        MSG('模块卸载成功',HTTP_REFERER,2000);
    }




    /**
     * 执行mysql.sql文件，创建数据表等
     * @param string $sql sql语句
     */

    function sql_execute($sql) {
        $db=load_class('db');
        $sql = preg_replace("/ENGINE=(InnoDB|MyISAM|MEMORY) DEFAULT CHARSET=([^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8",$sql);
        if($db->tablepre != 'wz_') $sql = str_replace('`wz_', '`'.$db->tablepre, $sql);
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
                    $db->query($sql);
                }
            }
        } else {
            $db->query($ret);
        }
        return true;
    }
}
?>