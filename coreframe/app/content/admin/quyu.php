<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 栏目管理
 */
load_class('admin');

class quyu extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->categorys = get_cache('category','content');
	}
	/**
	 * 列表
	 */
	public function listing() {
        $types = array('列表','单网页','外链');
        $model_cache = get_cache('model_content','model');
        $modelid = intval($GLOBALS['modelid']);
		$where = array('keyid'=>M,'modelid'=>$modelid);
		$result = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
		foreach($result as $cid=>$r) {
			$result[$cid]['str_manage'] = $r['child'] ? '' : '<a class="btn btn-default btn-sm btn-xs" href="?m=content&f=quyu&v=add&pid='.$r['cid'].$this->su().'">添加区域</a> <a class="btn btn-primary btn-sm btn-xs" href="?m=content&f=category&v=edit&cid='.$r['cid'].$this->su().'">修改区域</a>';
            $quyulist = $this->db->get_list('quyu', array('pid'=>$r['cid']), '*', 0, 100, 0, 'sort ASC');
            $quyustr = '';
            if(!empty($quyulist)) {
                foreach($quyulist as $ql) {
                    $quyustr .= $ql['name'].',';
                }
            }
			$result[$cid]['areas'] = $r['child'] ? '' : $quyustr;
		}
		$tree = load_class('tree','core',$result);
		$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
		//$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
		$tree_data = '';

		//格式字符串
		$str="<tr><td>\$cid</td></td><td id='\$cid' \$selected>\$spacer\$name</td><td>\$areas</td><td>\$str_manage</td></tr>";
		 
		//返回树
		$tree_data.=$tree->create(0,$str);
		 
		$tree_data.="";
        $show_dialog = 1;
		include $this->template('quyu_listing');
	}

	/**
	 * 添加区域
	 */
	public function add() {
		if(isset($GLOBALS['submit'])) {
			if(!is_array($GLOBALS['catname'])) MSG(L('catname error'));
            $pinyin = load_class('pinyin');

			foreach ($GLOBALS['catname'] as $key => $value) {
                if(trim($value)=='') continue;
				$formdata = array();
                $formdata = $GLOBALS['form'];

				$formdata['pid'] = intval($GLOBALS['pid']);
				$formdata['name'] = trim($value);
                if($GLOBALS['catdir'][$key]) {
                    $formdata['letter'] = sql_replace($GLOBALS['catdir'][$key]);
                } else {
                    $py = $pinyin->return_py($formdata['name']);
                    $formdata['letter'] = $py['pinyin'];
                }
				$cid = $this->db->insert('quyu',$formdata);
			}

			MSG(L('operation success'),HTTP_REFERER);
		} else {
            $pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
            $modelid = 0;
            if($pid) {
                $r = $this->db->get_one('category',array('cid'=>$pid));
                $modelid = $r['modelid'];
            }
            include $this->template('quyu_add');
		}
	}
    /**
     * 修改栏目
     */
    public function edit() {
        $cid = intval($GLOBALS['cid']);
        $type = isset($GLOBALS['type']) ? intval($GLOBALS['type']) : 0;
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata = $GLOBALS['form'];
            $formdata['keyid'] = 'content';
            $formdata['name'] = remove_xss($formdata['name']);
            $formdata['catdir'] = sql_replace($formdata['catdir']);
            $formdata['type'] = $type;
            $formdata['parentdir'] = $this->get_parentdir($cid);
            if($type==2) {
                $urls['url'] = $GLOBALS['url'];
            } else {
                //生成url
                $urlclass = load_class('url', 'content', $formdata);
                $this->categorys[$cid] = $formdata;
                $urlclass->set_categorys($this->categorys);
                $urls = $urlclass->listurl(array('cid' => $cid, 'page' => 1));
            }
            $formdata['url'] = $urls['url'];

            $this->db->update('category',$formdata,array('cid'=>$cid));

            //更新缓存
            $category_cache = load_class('category_cache','content');
            $category_cache->cache_all();
            MSG(L('update success'),'?m=content&f=category&v=listing'.$this->su());
        } else {
            $r = $this->db->get_one('category',array('cid'=>$cid));
            $form = load_class('form');
            $models = $this->db->get_list('model', array('m'=>'content'), '*', 0, 200, 0, '', '', 'modelid');
            $workflow = $this->db->get_list('workflow', array('keyid'=>'content'), '*', 0, 10);
            $where = array('keyid'=>M);
            $categorys = $this->db->get_list('category', $where, '*', 0, 2000, 0, '', '', 'cid');
            load_function('template');
            if($r['type']==2) {
                include $this->template('category_edit_2');
            } else {
                include $this->template('category_edit');
            }
        }
    }
	/**
	 * 删除栏目
	 */
	public function delete() {
		$cid = intval($GLOBALS['cid']);
		if (!$cid) MSG(L('empty category id'));
		$this->db->delete('category',array('cid'=>$cid));
		$this->delete_child($cid);
        //更新缓存
        $category_cache = load_class('category_cache','content');
        $category_cache->cache_all();

		MSG(L('operation success'),'?m=content&f=category&v=listing'.$this->su());
	}
	/**
	 * 递归删除子栏目
	 */
	private function delete_child($cid) {
		$r = $this->db->get_one('category',array('pid'=>$cid));
		if($r) {
			$this->db->delete('category',array('cid'=>$r['cid']));
			$this->delete_child($r['cid']);
		}
	}
	/**
	 * 排序
	 */
	public function sort() {
		if(isset($GLOBALS['submit'])) {
			foreach($GLOBALS['sorts'] as $cid => $n) {
				$n = intval($n);
				$this->db->update('category',array('sort'=>$n),array('cid'=>$cid));
			}
            //更新缓存
            $category_cache = load_class('category_cache','content');
            $category_cache->cache_all();

			MSG(L('operation success'),HTTP_REFERER);
		} else {
			MSG(L('operation failure'));
		}
	}

    /**
     * 生成父栏目目录
     * @param $pid
     */
    private function get_parentdir($cid,$result = '') {
        if($cid==0) return '';
        if($result) $this->categorys = $result;
        $pids = $this->get_parents($cid);
        if($pids) {
            $pids = explode(',',$pids);
            $dir = '';
            foreach($pids as $_cid) {
                if($_cid && $cid!=$_cid) $dir .= $this->categorys[$_cid]['catdir'].'/';
            }
            return rtrim($dir,'/');
        } else {
            return $this->categorys[$cid]['catdir'];
        }
    }

    /**
     * 获取所有父级栏目id
     * @param $cid
     * @return string
     */
    private function get_parents($cid, $arrpid = '', $n = 1) {
        if($n > 5 || !is_array($this->categorys) || !isset($this->categorys[$cid])) return false;
        $pid = $this->categorys[$cid]['pid'];
        $arrpid = $arrpid ? $pid.','.$arrpid : $pid;
        if($pid) {
            $arrpid = $this->get_parents($pid, $arrpid, ++$n);
        } else {
            $this->categorys[$cid]['arrpid'] = $arrpid;
        }
        $parentid = $this->categorys[$cid]['pid'];
        return $arrpid;
    }

    /**
     * 修复栏目数据
     * 修复child，pid，parentdir，url
     */
    public function repair() {
        $where = array('keyid'=>M);
        $result = $this->db->get_list('category', $where, '*', 0, 2000, 0, '', '', 'cid');
        $urlclass = load_class('url','content','');
        $urlclass->set_categorys($result);
        foreach($result as $cid=>$r) {
            $tmp = array();
            //child
            $child = $this->get_child($cid,$result);
            if($child!=$r['child']) $tmp['child'] = $child;
            //pid
            $pid = $this->get_pid($r['pid'],$result);
            if($pid!=$r['pid']) $tmp['pid'] = $pid;
            //parentdir
            $parentdir = $this->get_parentdir($cid,$result);
            if($parentdir!=$r['parentdir']) $tmp['parentdir'] = $parentdir;
            //url
            $urlclass->set_category($r);
            if($r['type']==2) {
                $tmp['url'] = $r['url'];
            } else {
                $urls = $urlclass->listurl(array('cid'=>$cid,'page'=>1));
                $url = $urls['url'];
                if($url!=$r['url']) $tmp['url'] = $url;
            }


            if(!empty($tmp)) {
                $this->db->update('category',$tmp,array('cid'=>$cid));
                echo $r['name'].',';
            }
        }
        //更新缓存
        $category_cache = load_class('category_cache','content');
        $category_cache->cache_all();
        echo '修复成功！';
    }
    private function get_child($pid,$result) {
        foreach($result as $cid=>$r) {
            if($r['pid']==$pid) return '1';
        }
        return '0';
    }
    private function get_pid($pid,$result) {
        if(isset($result[$pid])) return $pid;
        return '0';
    }

    /**
     * 栏目内容管理权限
     */
    public function private_set() {
        $role = intval($GLOBALS['role']);
        if(isset($GLOBALS['ac'])) {
            $cid = intval($GLOBALS['cid']);
            $chk = intval($GLOBALS['chk']);
            if($GLOBALS['ac']=='all'){//该栏目所有权限
                if($chk) {
                    for($i=1;$i<6;$i++) {
                        $this->db->insert('category_private',array('role'=>$role,'cid'=>$cid,'actionid'=>$i),false,true);
                    }
                } else {
                    for($i=1;$i<6;$i++) {
                        $this->db->delete('category_private', array('role'=>$role,'cid' => $cid, 'actionid' => $i));
                    }
                }

            } else {
                $actionid = intval($GLOBALS['ac']);
                if($chk) {
                        $this->db->insert('category_private',array('role'=>$role,'cid'=>$cid,'actionid'=>$actionid),false,true);
                } else {
                        $this->db->delete('category_private', array('role'=>$role,'cid' => $cid, 'actionid' => $actionid));
                }
            }
            exit('1');
        } else {

            $model_cache = get_cache('model_content','model');
            $where = array('keyid'=>M);
            $result = get_cache('category','content');
            $privates_rs = $this->db->get_list('category_private', array('role'=>$role), '*', 0, 2000);
            foreach($privates_rs as $rs) {
                $privates[$rs['cid']][$rs['actionid']] = 1;
            }
            $categorys = array();
            foreach ($result as $k=>$v) {
                $v['cid'] = $k;
                $v['disabled'] = '';
                $v['listing_check'] = isset($privates[$k][1]) ? 'checked' : '';
                $v['add_check'] = isset($privates[$k][2]) ? 'checked' : '';
                $v['edit_check'] = isset($privates[$k][3]) ? 'checked' : '';
                $v['delete_check'] = isset($privates[$k][4]) ? 'checked' : '';
                $v['sort_check'] = isset($privates[$k][5]) ? 'checked' : '';
                $categorys[$k] = $v;
            }
            $show_header = true;
            $str = "<tr>
					<td width='80' align='center'><label><input type='checkbox' onclick='select_tr(\$cid, this)' > 全选</label></td>
				  <td >\$spacer\$name</td>
				  <td width='120' align='center'><label><input type='checkbox' onclick='st(\$cid,this);' name='cid\$cid' \$listing_check  value='1' > 浏览列表</label></td>
				  <td width='80' align='center'><label><input type='checkbox' onclick='st(\$cid,this);' name='cid\$cid' \$disabled \$add_check value='2' > 添加</label></td>
				  <td width='80' align='center'><label><input type='checkbox' onclick='st(\$cid,this);' name='cid\$cid' \$disabled \$edit_check value='3' > 修改</label></td>
				  <td width='80' align='center'><label><input type='checkbox' onclick='st(\$cid,this);' name='cid\$cid' \$disabled \$delete_check  value='4' > 删除</label></td>
				  <td width='80' align='center'><label><input type='checkbox' onclick='st(\$cid,this);' name='cid\$cid' \$disabled \$sort_check value='5' > 排序</label></td>
			  </tr>";
            //返回树
            $tree = load_class('tree','core',$categorys);
            $tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');

            $tree_data=$tree->create(0,$str);
            include $this->template('private_set');
        }
    }
}
