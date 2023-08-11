<?php
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');
class org extends WUZHI_admin
{
    private $db;
	function __construct() {
		$this->db = load_class('db');
	}

    function lists()
    {
        $siteid = get_cookie('siteid');
        $where = "";
		$result = $this->db->get_list('org', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
        $types = [
            1 => '正常',
            2 => '停用'
        ];
        $sitelist = get_cache('sitelist');
        foreach($result as $cid=>$r) {
			$result[$cid]['str_manage'] = '<a class="btn btn-default btn-sm btn-xs" href="?m=member&f=org&v=create&pid='.$r['cid'].$this->su().'">添加下级单位</a> <a class="btn btn-primary btn-sm btn-xs" href="?m=member&f=org&v=update&cid='.$r['cid'].$this->su().'">修改</a> <a class="btn btn-danger btn-sm btn-xs" href="javascript:makedo(\'?m=member&f=org&v=delete&cid='.$r['cid'].$this->su().'\', \'确认删除该记录？\')">删除</a>';
			$result[$cid]['status'] = $types[$r['status']];
			$result[$cid]['siteid'] = isset($sitelist[$r['siteid']]['name'])? $sitelist[$r['siteid']]['name']:'';
		}
        $tree = load_class('tree','core',$result);
		$tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├─&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└─&nbsp;&nbsp;');
		$tree_data = '';
		//格式字符串
		$str="<tr><td class='categorytd'><div><input class='text-center form-control'style='padding:3px;width: 30px;' name='sorts[\$cid]' type='text' size='3' value='\$sort'></div></td><td>\$cid</td><td>\$siteid</td><td id='\$cid' \$selected>\$spacer\$name</td><td>\$status</td><td>\$str_manage</td></tr>";

		//返回树
		$tree_data.=$tree->create(0,$str);
        include $this->template('org_lists');
    }

    function create()
    {
        if ($GLOBALS['submit'])
        {
            $formData = $GLOBALS['form'];
            $result = $this->db->insert('org', $formData);
            MSG('添加成功', HTTP_REFERER);
        } else {
            $form = load_class('form');
            $pid = isset($GLOBALS['pid']) ? intval($GLOBALS['pid']) : 0;
            $where = '';
            $orgLists = $this->db->get_list('org', $where, '*', 0, 2000, 0, '', '', 'cid');
            include $this->template('org_create');
        }

    }

    function update()
    {
        if ($GLOBALS['submit'])
        {
            $cid = $GLOBALS['cid'];
            $formData = $GLOBALS['form'];

            $result = $this->db->update('org', $formData, ['cid' => $cid]);

            MSG('修改成功', HTTP_REFERER);

        } else {
            $cid = $GLOBALS['cid'];
            $result = $this->db->get_one('org', ['cid' => $cid]);
           //加载树目录
            $form = load_class('form');
            $pid = $result['pid'];
            $where = '';
            $orgLists = $this->db->get_list('org', $where, '*', 0, 2000, 0, '', '', 'cid');
            //加载模板
            include $this->template('org_update');
        }
    }

    function delete()
    {
        $cid = $GLOBALS['cid'];
        $this->db->delete('org', ['cid' => $cid]);
        
        $referer = '?m=member&f=org&v=lists'.$this->su();
        MSG('添加成功', HTTP_REFERER);
    }
    function sort()
    {


    }

}