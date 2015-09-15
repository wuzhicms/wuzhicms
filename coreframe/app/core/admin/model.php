<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('Access Denied');
/**
 *1/全站统一字段
 *2/单独模块如果通过模型实现，则可以继承统一字段， 同时，可以覆盖字段。
 *3/全站模型统一缓存
*/
load_class('admin');

class model extends WUZHI_admin {
	private $db;
	private $m;
	function __construct() {
		$this->db = load_class('db');
		$this->m = isset($GLOBALS['app']) ? $GLOBALS['app'] : 'content';
		$this->core_path = COREFRAME_ROOT.'app/core/fields/';
		$this->m_path = COREFRAME_ROOT.'app/'.$this->m.'/fields/';
	}
	//模型列表
	public function model_listing() {
        $this->cache_form();//TODO 删除该行

		$m = $this->m;
		$where = array('m'=>$m);
		$result = $this->db->get_list('model', $where, '*', 0, 100,0,'modelid ASC');
		include $this->template('model_listing');
	}
	//添加模型
	public function model_add() {
        $module_config = '';
        if(file_exists(COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php')) {
            $module_config = include COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php';
        }
        $master_table = isset($module_config['master_table']) ? $module_config['master_table'] : $this->m.'_share';

        $share_model = isset($GLOBALS['share_model']) && $GLOBALS['share_model'] ? intval($GLOBALS['share_model']) : 0;
		if(isset($GLOBALS['submit'])) {
			if(empty($GLOBALS['tablename'])) MSG(L('database table name is empty'));
			
			if($share_model) $GLOBALS['att'] = 2;
			$formdata = '';
			$formdata['master_table'] = $share_model ? $master_table : $GLOBALS['tablename'];
			$formdata['m'] = $this->m;
			$formdata['name'] = $GLOBALS['name'];
			$formdata['css'] = input('css');
			$formdata['attr_table'] = intval($GLOBALS['att'])===2 ? $GLOBALS['tablename'].'_data' : '';
			$formdata['share_model'] = isset($GLOBALS['share_model']) ? intval($GLOBALS['share_model']) : 0;
			$formdata['template'] = $GLOBALS['template'];
			$formdata['remark'] = $GLOBALS['remark'];
			//检查表是否存在，若存在则不允许创建
			$tables = array();
			$query = $this->db->query("SHOW TABLES");
			while($r = $this->db->fetch_array($query)) {
				$tables[] = $r['Tables_in_'.$this->db->dbname];
			}
			//先创建表，然后执行下面的操作
			$basic_tablename = $this->db->tablepre.$GLOBALS['tablename'];
			$att_tablename = $this->db->tablepre.$formdata['attr_table'];
			$table_model_field = $this->db->tablepre.'model_field';
			if($share_model) {
				//获取共享表结构
				if(in_array($att_tablename, $tables)) MSG(L('database table exists'));
				$sqldata = file_get_contents($this->m_path.'db_share.sql');
			} elseif($formdata['attr_table']) {
				//选择了创建2个表
				if(in_array($basic_tablename, $tables) || in_array($att_tablename, $tables)) MSG(L('database table exists'));
				$sqldata = file_get_contents($this->m_path.'db2.sql');
			} else {
				//创建独立单表
				if(in_array($basic_tablename, $tables)) MSG(L('database table exists'));
				$sqldata = file_get_contents($this->m_path.'db1.sql');
			}
			$sqldata = str_replace('$basic_tablename', $basic_tablename, $sqldata);
			$sqldata = str_replace('$att_tablename', $att_tablename, $sqldata);
			$sqldata = str_replace('$table_model_field', $table_model_field, $sqldata);
			load_function('sql');

			if(sql_execute($this->db,$sqldata)) {
				$modelid = $this->db->insert('model',$formdata);
				$this->db->update('model_field',array('modelid'=>$modelid),array('modelid'=>0));
                $forward = isset($GLOBALS['forward']) ? $GLOBALS['forward'] : HTTP_REFERER;
                MSG(L('add success'),$forward);
			} else {
				MSG(L('add table faild'));
			}
			
		} else {
            load_class('form');
            load_function('template');
			include $this->template('model_add');
		}
	}

    //修改模型
    public function edit() {
        $siteid = get_cookie('siteid');
        $modelid = intval($GLOBALS['modelid']);
        if(isset($GLOBALS['submit'])) {
            $r = $this->db->get_one('model',array('modelid'=>$modelid));
            $template_set = unserialize($r['template_set']);
            $formdata = array();
            $formdata['name'] = $GLOBALS['name'];
            $formdata['template'] = $GLOBALS['template'];
            $formdata['remark'] = $GLOBALS['remark'];
            $formdata['css'] = $GLOBALS['css'];
            $this->db->update('model',$formdata,array('modelid'=>$modelid));
            $forward = isset($GLOBALS['forward']) ? $GLOBALS['forward'] : HTTP_REFERER;
            MSG(L('update success'),$forward);
        } else {
            load_class('form');
            load_function('template');
            $r = $this->db->get_one('model',array('modelid'=>$modelid));
            $template_set = unserialize($r['template_set']);
            $r['template'] = $template_set[$siteid];
            include $this->template('model_edit');
        }
    }
    //删除模型
    public function delete() {
        $modelid = intval($GLOBALS['modelid']);
        $r = $this->db->get_one('model',array('modelid'=>$modelid));
        if($r) {
            $this->db->delete('model',array('modelid'=>$modelid));
            $this->db->delete('model_field',array('modelid'=>$modelid));
            if($r['share_model']==0) {
                $this->db->query("DROP TABLE ".$this->db->tablepre.$r['master_table']);
            }
            if($r['attr_table']) {
                $this->db->query("DROP TABLE ".$this->db->tablepre.$r['attr_table']);
            }
            $path = get_cache_path('field_'.$modelid,'model');
            if(file_exists($path)) {
                @unlink($path);
            }
        }
        MSG(L('delete success'),'?m=core&f=model&v=model_listing'.$this->su());
    }

	//添加字段
	public function field_add() {
		$modelid = intval($GLOBALS['modelid']);
		$cache_model = load_class('cache_model');
		$field_config = $cache_model->get_fields_info($this->m);
        $formtype = isset($GLOBALS['formtype']) ? $GLOBALS['formtype'] : 'text';
        //print_r($formtype);exit;
		if(isset($GLOBALS['submit'])) {

			$formdata = $GLOBALS['form'];
			$formdata['field'] = trim($formdata['field']);
			//检查是否存在该字段
			$r =$this->db->get_one('model_field',array('modelid'=>$modelid,'field'=>$formdata['field']));
			if($r) MSG(L('field exists'));
			$formdata['modelid'] = $modelid;
			$formdata['formtype'] = $formtype;
			//master_field 是要添加到主表的
			$formdata['master_field'] = intval($formdata['master_field']);
            $formdata['setting'] = isset($GLOBALS['setting']) ? serialize($GLOBALS['setting']) : '';
            $formdata['unsetgids'] = isset($GLOBALS['unsetgids']) ? implode(',',$GLOBALS['unsetgids']) : '';
			$formdata['unsetroles'] = isset($GLOBALS['unsetroles']) ? implode(',',$GLOBALS['unsetroles']) : '';

			$field = $formdata['field'];
			$minlength = isset($formdata['minlength']) ? intval($formdata['minlength']) : 0;
			$maxlength = isset($formdata['maxlength']) ? intval($formdata['maxlength']) : 0;

			if(isset($field_config[$formtype]['system_field'])) {
				$config = require $this->core_path.$formtype.'/config.php';
			} else {
				$config = require $this->m_path.$formtype.'/config.php';
			}
			//获取模型数据，将结果赋值给db.php
			$model_r = $this->db->get_one('model',"modelid=".$modelid);
			//print_r($model_r);exit;
			//在扩张配置中的选项，选择，是vachar,char,smallint,int
            if(isset($GLOBALS['setting']['fieldtype'])) $config['field_type'] = $GLOBALS['setting']['fieldtype'];

            $action = 'add';

			require $this->core_path.'db.php';

			$this->db->insert('model_field',$formdata);
            $this->cache_form();
			MSG(L('add success'),$GLOBALS['forward']);
		} else {
            $module_config = '';
            if(file_exists(COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php')) {
                $module_config = include COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php';
            }
            $model_r = $this->db->get_one('model',"modelid=".$modelid);
            $addto_master = false;
            if($model_r['attr_table']=='') $addto_master = true;

			$form = load_class('form');
			$options = '';
			foreach ($field_config AS $key => $value) {
				$options[$key] = $value['fieldname'];
			}
			$setting = '';
			include $this->template('field_add');
		}
	}
	public function field_edit() {
        $id = intval($GLOBALS['id']);

        $modelid = intval($GLOBALS['modelid']);
        $cache_model = load_class('cache_model');
        $field_config = $cache_model->get_fields_info($this->m);
        $formtype = isset($GLOBALS['formtype']) ? $GLOBALS['formtype'] : 'text';
        //print_r($formtype);exit;
        if(isset($GLOBALS['submit'])) {
            $oldfield = $GLOBALS['oldfield'];
            $formdata = $GLOBALS['form'];
			$formdata['field'] = trim($formdata['field']);
            //检查是否存在该字段
            $r =$this->db->get_one('model_field',array('modelid'=>$modelid,'field'=>$formdata['field']));
            if(!$r) MSG(L('field not exists'));
            $formdata['modelid'] = $modelid;

            $formdata['setting'] = isset($GLOBALS['setting']) ? serialize($GLOBALS['setting']) : '';
            $formdata['unsetgids'] = isset($GLOBALS['unsetgids']) ? implode(',',$GLOBALS['unsetgids']) : '';
            $formdata['unsetroles'] = isset($GLOBALS['unsetroles']) ? implode(',',$GLOBALS['unsetroles']) : '';

            $field = $formdata['field'];
            $minlength = isset($formdata['minlength']) ? intval($formdata['minlength']) : 0;
            $maxlength = isset($formdata['maxlength']) ? intval($formdata['maxlength']) : 0;

            if(isset($field_config[$formtype]['system_field'])) {
                $config = require $this->core_path.$formtype.'/config.php';
            } else {
                $config = require $this->m_path.$formtype.'/config.php';
            }
            //获取模型数据，将结果赋值给db.php
            $model_r = $this->db->get_one('model',"modelid=".$modelid);
            //print_r($model_r);exit;
            //在扩张配置中的选项，选择，是vachar,char,smallint,int
           // $field_type =
            if(isset($GLOBALS['setting']['fieldtype'])) $config['field_type'] = $GLOBALS['setting']['fieldtype'];

            $action = 'edit';
            $formdata['master_field'] = $r['master_field'];

            require $this->core_path.'db.php';
            //入库前，注销不允许修改都的字段
            unset($formdata['master_field'],$formdata['formtype']);
            $this->db->update('model_field',$formdata,array('id'=>$id));
            $this->cache_form();
            MSG(L('edit success'),$GLOBALS['forward']);
        } else {
            $module_config = '';
            if(file_exists(COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php')) {
                $module_config = include COREFRAME_ROOT.'app/'.$this->m.'/fields/config.php';
            }

            $form = load_class('form');
            $options = '';
            foreach ($field_config AS $key => $value) {
                $options[$key] = $value['fieldname'];
            }

            $r = $this->db->get_one('model_field',array('id'=>$id));
            $setting = unserialize($r['setting']);

            $formtype = $r['formtype'];
            include $this->template('field_edit');
        }
	}
	public function field_delete() {
        $id = intval($GLOBALS['id']);
        $rs = $this->db->get_one('model_field',array('id'=>$id));
        $r = $this->db->get_one('model',array('modelid'=>$rs['modelid']));

        $field = $rs['field'];
        $tablename = $rs['master_field'] ? $r['master_table'] : $r['attr_table'];
        $tablename = $this->db->tablepre.$tablename;

        //TODO 禁止删除共享模型的默认字段,但用户自己添加的可以删,在添加共享模型字段的时候，需要配置好系统不能删除的字段
        if($rs['ban_field']==0) {
            $this->db->delete('model_field',array('id'=>$id));
            $this->db->query("ALTER TABLE `$tablename` DROP `$field`");
        }

        $this->cache_form();
        MSG(L('delete success'),HTTP_REFERER);
	}

	//字段列表
	public function field_listing() {
		$modelid = intval($GLOBALS['modelid']);
		$where = array('modelid'=>$modelid);
		$result = $this->db->get_list('model_field', $where, '*', 0, 100,0,'sort ASC');
		include $this->template('field_listing');
	}
	//更新所有缓存
	public function cache_form($return = 1) {
		//读取有哪些模块开启了模型功能
		$model_config = get_config('model_config');
		$cache_model = load_class('cache_model');
		foreach($model_config AS $m) {
			$cache_model->cache_form($m);
		}
		//更新字段缓存
		$cache_model->cache_field();
		if($return) {
            return TRUE;
        } else {
            MSG('cache ok');
        }
	}
    /**
     * 字段排序
     */
    public function field_sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('model_field',array('sort'=>$n),array('id'=>$cid));
            }
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 字段禁用
     */
    public function field_baned() {
        $id = intval($GLOBALS['id']);
        $ban_field = intval($GLOBALS['ban_field']);
        $this->db->update('model_field',array('disabled'=>$ban_field),array('id'=>$id));
        if($ban_field) {
            MSG('字段禁用成功！',HTTP_REFERER);
        } else {
            MSG('字段开启成功！',HTTP_REFERER);
        }
    }
}
?>