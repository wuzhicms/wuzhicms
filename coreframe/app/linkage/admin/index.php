<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 联动菜单
 */
load_class('admin');

class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 联动菜单列表
     */
    public function listing() {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('linkage', '', '*', 0, 20,$page,'linkageid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 添加联动菜单
     */
    public function add() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['display_type'] = intval($GLOBALS['form']['display_type']);
            $formdata['level'] = intval($GLOBALS['form']['level']);
            $linkageid = $this->db->insert('linkage',$formdata);
            $config = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            set_cache('config_'.$linkageid,$config,'linkage');
            MSG(L('operation success'));
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            include $this->template('add');
        }
    }

    /**
     * 添加选项
     */
    public function add_item() {
        if(isset($GLOBALS['submit'])) {
            $pinyin = load_class('pinyin');
            $formdata = array();
            if(empty($GLOBALS['form']['names'])) MSG(L('parameter error'));
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['linkageid'] = intval($GLOBALS['linkageid']);
            $formdata['pid'] = intval($GLOBALS['pid']);

            $names = explode("\n",$GLOBALS['form']['names']);
            foreach($names as $name) {
                $formdata['name'] = trim(remove_xss($name));
                $py = $pinyin->return_py($formdata['name']);
                $formdata['initial'] = strtolower($py['pinyin']);

                $formdata['thumb'] = strip_tags($GLOBALS['form']['thumb']);
                $formdata['pictures'] = array2string($GLOBALS['form']['pictures']);
                $this->db->insert('linkage_data',$formdata);
            }
            if($formdata['pid']) {
                $this->db->update('linkage_data',array('child'=>1),array('lid'=>$formdata['pid']));
            }
			set_cache('linkage_'.$formdata['linkageid'],array(),'linkage');

            MSG(L('operation success'),'?m=linkage&f=index&v=item_listing&linkageid='.$formdata['linkageid'].'&pid='.$formdata['pid'].$this->su());
        } else {
            $show_formjs = 1;
            $linkageid = isset($GLOBALS['linkageid']) ? intval($GLOBALS['linkageid']) : 0;
            $pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
            $r = $this->db->get_one('linkage_data',array('lid'=>$pid));
            if(!$r) {
                $r = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            }

            $this->form = load_class('form');
            $value = '';
            $field = 'pictures';
            $str = '<script>
	$(function() {
		$( "#".$field."_ul" ).sortable();
		$( "#".$field."_ul" ).disableSelection();
	});
</script>';
            $default_multiple = '';
            if ($value && is_array($value)) {
                foreach ($value AS $k => $v) {
                    $default_multiple .= '<li id="file_node_' . $k . '"><input type="hidden" name="' . $field . '[' . $k . '][url]" value="' . $v['url'] . '"> <img src="' . $v['url'] . '" alt="' . $v['alt'] . '" onclick="img_view(this.src);"> <textarea name="' . $field . '[' . $k . '][alt]" >' . $v['alt'] . '</textarea> <a class="btn btn-danger btn-xs" href="javascript:remove_file(' . $k . ');">移除</a></li>';
                }
            }
            $str2 = '<div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';

            $pictures = $str . '<div class="attaclist">' . $str2 . $this->form->attachment("jpg|png|gif|bmp", 20, "form[$field]", $value, 'callback_images2', 0,true) . '</div>';
            $show_dialog = 1;

            include $this->template('add_item');
        }
    }
    /**
     * 联动菜单选项列表
     */
    public function item_listing() {
        $pid = intval($GLOBALS['pid']);
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $linkageid = isset($GLOBALS['linkageid']) ? intval($GLOBALS['linkageid']) : 0;
        $data = $this->db->get_one('linkage', array('linkageid' => $linkageid));

        if($linkageid) {
			$data2 = $this->db->get_one('linkage_data', array('lid' => $pid));
            $where = array('linkageid'=>$linkageid,'pid'=>$pid);
        } else {
            $where = array('pid'=>$pid);

        }
        $result = $this->db->get_list('linkage_data', $where, '*', 0, 20,$page,"sort ASC,lid ASC");
        $pages = $this->db->pages;
        $total = $this->db->number;

		if(file_exists($this->template('item_listing'.$linkageid))) {
			include $this->template('item_listing'.$linkageid);
		} else {
			include $this->template('item_listing');
		}

    }
    /**
     * 排序
     */
    public function sort() {
        if(isset($GLOBALS['submit'])) {
            foreach($GLOBALS['sorts'] as $cid => $n) {
                $n = intval($n);
                $this->db->update('linkage_data',array('sort'=>$n),array('lid'=>$cid));
            }
			$data = $this->db->get_one('linkage_data', array('lid'=>$cid));
			if($data) {
				set_cache('linkage_'.$data['linkageid'],array(),'linkage');
			}
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            MSG(L('operation failure'));
        }
    }
    /**
     * 修改联动菜单
     */
    public function edit() {
        $linkageid = intval($GLOBALS['linkageid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $formdata['display_type'] = intval($GLOBALS['form']['display_type']);
            $formdata['level'] = intval($GLOBALS['form']['level']);
            $this->db->update('linkage',$formdata,array('linkageid'=>$linkageid));
            $config = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            set_cache('config_'.$linkageid,$config,'linkage');
            MSG(L('operation success'),'?m=linkage&f=index&v=listing'.$this->su());
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $r = $this->db->get_one('linkage',array('linkageid'=>$linkageid));
            include $this->template('edit');
        }
    }
    /**
     * 删除联动菜单
     */
    public function delete() {
        $linkageid = intval($GLOBALS['linkageid']);
        $this->db->delete('linkage',array('linkageid'=>$linkageid));
        $this->db->delete('linkage_data',array('linkageid'=>$linkageid));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 删除联动选项
     */
    public function delete_item() {
        $lid = intval($GLOBALS['lid']);
		$data = $this->db->get_one('linkage_data', array('lid'=>$lid));
		if($data) {
			set_cache('linkage_'.$data['linkageid'],array(),'linkage');
		}
        $this->db->delete('linkage_data',array('lid'=>$lid));
        $this->delete_child($lid);
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
    /**
     * 递归删除子选项
     */
    private function delete_child($lid) {
        $r = $this->db->get_one('linkage_data',array('pid'=>$lid));
        if($r) {
            $this->db->delete('linkage_data',array('lid'=>$r['lid']));
            $this->delete_child($r['lid']);
        }
    }
    /**
     * 修改联动菜单选项
     */
    public function edit_item() {
        $lid = intval($GLOBALS['lid']);
        if(isset($GLOBALS['submit'])) {
            $pinyin = load_class('pinyin');
            $formdata = array();
            $formdata['name'] = remove_xss($GLOBALS['form']['name']);
            $formdata['remark'] = remove_xss($GLOBALS['form']['remark']);
            $py = $pinyin->return_py($formdata['name']);
            $formdata['initial'] = strtolower($py['pinyin']);
            $formdata['letter'] = strtolower($GLOBALS['form']['letter']);
            $formdata['thumb'] = strip_tags($GLOBALS['form']['thumb']);
            $pictures = $GLOBALS['pictures'];
            $pictures2 = $GLOBALS['form']['pictures'];

            if($pictures2 && $pictures) {
                $pictures = array_merge($pictures,$pictures2);
            } else {
                $pictures = $pictures2;
            }
            if($pictures) $formdata['pictures'] = array2string($pictures);

            $this->db->update('linkage_data',$formdata,array('lid'=>$lid));
            $forward = $GLOBALS['forward'];
			//缓存城市配置信息
			if($formdata['letter']) {
				$result = $this->db->get_list('linkage_data',"letter!=''", '*', 0, 500, 0, 'lid ASC');
				$data = array();
				foreach($result as $r) {
					$data[$r['letter']] = array('cityid'=>$r['lid'],'cityname'=>str_replace('市','',$r['name']));
				}
                $data = '<?php' . "\r\n return " . array2string($data) . '?>';
                file_put_contents(WWW_ROOT.'configs/city_config.php', $data);
			}
			$data2 = $this->db->get_one('linkage_data',array('lid'=>$lid));

			set_cache('linkage_'.$data2['linkageid'],array(),'linkage');
			MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $r = $this->db->get_one('linkage_data',array('lid'=>$lid));
            $this->form = load_class('form');
            $value = string2array($r['pictures']);
            $field = 'pictures';
            $str = '<script>
	$(function() {
		$( "#".$field."_ul" ).sortable();
		$( "#".$field."_ul" ).disableSelection();
	});
</script>';
            $default_multiple = '';
            if ($value && is_array($value)) {
                foreach ($value AS $k => $v) {
                    $default_multiple .= '<li id="file_node_' . $k . '"><input type="hidden" name="' . $field . '[' . $k . '][url]" value="' . $v['url'] . '"> <img src="' . $v['url'] . '" alt="' . $v['alt'] . '" onclick="img_view(this.src);"> <textarea name="' . $field . '[' . $k . '][alt]" >' . $v['alt'] . '</textarea> <a class="btn btn-danger btn-xs" href="javascript:remove_file(' . $k . ');">移除</a></li>';
                }
            }
            $str2 = '<div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';

            $pictures = $str . '<div class="attaclist">' . $str2 . $this->form->attachment("jpg|png|gif|bmp", 20, "form[$field]", $value, 'callback_images2', 0,true) . '</div>';
            $show_formjs = 1;
            $show_dialog = 1;
			if(file_exists($this->template('edit_item'.$r['linkageid']))) {
				include $this->template('edit_item'.$r['linkageid']);
			} else {
				include $this->template('edit_item');
			}

        }
    }

    /**
     * 设置为群组项
     */
    public function set_group() {
        $lid = intval($GLOBALS['lid']);
        $r = $this->db->get_one('linkage_data',array('lid'=>$lid));
        $formdata = array();
        if($r['isgroup']) {
            $formdata['isgroup'] = 0;
        } else {
            $formdata['isgroup'] = 1;
        }
        $this->db->update('linkage_data', $formdata, array('lid' => $lid));
        MSG(L('operation success'), HTTP_REFERER);
    }
    private function current_pos($pid) {
        $r = $this->db->get_one('linkage_data', array('lid' => $pid));
        if($r['pid']) {
            $str = $this->current_pos($r['pid']);
        }
        $str .= "<span>".$r['name'].'&gt;</span>';
        return $str;
    }
}