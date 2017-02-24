<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('Access Denied');
/**
 *app管理（模块管理）
*/
load_class('admin');
load_function('dir','core');
class app extends WUZHI_admin {
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
		$setting_datas = $this->db->get_list('setting',array('keyid'=>'install'), '*', 0, 100,0,'id ASC','','m');
		$install_apps = array_keys($setting_datas);

		$settings = array();
		foreach ($dirs_arr as $_m) {
			$tmp = array();
			//是否已经安装
			if(in_array($_m,$install_apps)) {
				$tmp['appname'] = $setting_datas[$_m]['title'];
				$tmp['install'] = 1;//已经安装
				$tmp['allow_uninstall'] = $setting_datas[$_m]['data'];//是否允许卸载,0 ：禁止卸载
			} else {
				$tmp['install'] = 0;//未安装
				$tmp['allow_uninstall'] = 0;
				$apppath = COREFRAME_ROOT.'app/'.$_m.'/admin/install/config.php';
				if(file_exists($apppath)) {
					$appconfig = include $apppath;
					if(isset($appconfig['unpublish'])) continue;//开发中的模块，不显示
					$tmp['appname'] = $appconfig['appname'];
				} else {
					$tmp['appname'] = $_m;
				}
			}
			$tmp['m'] = $_m;
			$settings[] = $tmp;
		}
		//print_r($settings);
        include $this->template('app_list');
    }

    /**
     * 模块安装
     */
    public function install(){
        $appkey = $GLOBALS['appkey'];
		if(preg_match('/([^a-z0-9_]+)/i',$appkey)) {
			MSG('安装目录错误');
		}
        $module_array = $this->db->get_one('setting', array('keyid'=>'install','m'=>$appkey));
		if($module_array) {
			MSG('模块已经安装过！');
		}
		$install_sql = COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/'.$appkey . '.sql';
        //执行sql语句
        if (!file_exists($install_sql)) {
            MSG('安装SQL：文件不存在:'.$install_sql);
        }
        $sql = file_get_contents($install_sql);
        if(empty($sql))MSG('SQL文件中必须有其对应的SQL语句，方可安装模块！');
        $this->sql_execute($sql);

        //模板html文件的拷贝
        if(file_exists(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/'.'templates/') && !file_exists(COREFRAME_ROOT . 'templates/default/'. $appkey .'/')){
            dir_copy(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/'.'templates/',COREFRAME_ROOT . 'templates/default/'. $appkey .'/');
        }

        //缓存菜单语音包
        load_class('cache_menu');

		$this->db->insert('setting', array('keyid'=>'install','m'=>$appkey,'data'=>1));
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
        //if(!is_dir(COREFRAME_ROOT . 'templates/default/'. $appkey))MSG('指定文件夹不存在！');
        //创建文件夹
        if (!is_dir(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install')) {

            mkdir(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install');
            mkdir(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/templates');
            fopen(COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/'.$appkey . '.sql','a+');

        }
        if (!is_dir(COREFRAME_ROOT . 'app/' . $appkey . '/admin/uninstall/')) {

            mkdir(COREFRAME_ROOT . 'app/' . $appkey . '/admin/uninstall');
            fopen(COREFRAME_ROOT . 'app/' . $appkey . '/admin/uninstall/'.$appkey . '.sql','a+');
        }
        if (is_dir(COREFRAME_ROOT . 'templates/default/'. $appkey)){
            dir_copy(COREFRAME_ROOT . 'templates/default/'. $appkey,COREFRAME_ROOT . 'app/' . $appkey . '/admin/install/templates');
            dir_delete(COREFRAME_ROOT . 'templates/default/'. $appkey);
        }

        if (!file_exists(COREFRAME_ROOT . 'app/' . $appkey . '/admin/uninstall/'.$appkey . '.sql')) {
            MSG('文件名错误不存在！');
        }
        $sql = file_get_contents(COREFRAME_ROOT . 'app/' . $appkey . '/admin/uninstall/'.$appkey . '.sql');
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