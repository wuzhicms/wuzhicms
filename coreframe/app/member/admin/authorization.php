<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/1/13 22:05
 * @version    1.0.1
 */

defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');
class authorization extends WUZHI_admin
{
    private $db;

    function __construct()
    {
        $this->db = load_class('db');
    }

    public function listing()
    {
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page, 1);
        $result = $this->db->get_list('member_verify_set', '', '*', 0, 20, $page, 'id DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('authorization_listing');
    }

    public function add()
    {
        if (isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $this->db->insert('member_verify_set', $formdata);
            MSG(L('operation_success'), '?m=member&f=authorization&v=listing' . $this->su());
        } else {
            $models = get_cache('model_member', 'model');
            $form = load_class('form');
            include $this->template('authorization_add');
        }
    }

    public function edit()
    {
        $id = (int)$GLOBALS['id'];
        if ($id) $result = $this->db->get_one('member_verify_set', '`id`=' . $id, '*');
        if (empty($result)) MSG(L('not_exists'));

        if (isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $this->db->update('member_verify_set', $formdata, array('id' => $id));
            MSG(L('operation_success'), '?m=member&f=authorization&v=listing' . $this->su());
        } else {
            $models = get_cache('model_member', 'model');
            $form = load_class('form');
            include $this->template('authorization_edit');
        }
    }

    public function delete()
    {
        $id = intval($GLOBALS['id']);
        $this->db->delete('member_verify_set', array('id' => $id));
        MSG(L('delete success'), HTTP_REFERER, 1500);
    }

    public function user_listing()
    {
        $result = $this->db->get_list('member_verify');
        $model = $this->db->get_list('member_verify_set');
        $member = $this->db->get_list('member', '', '*', 0, 200, 0, '', '', 'uid');
        foreach ($model as $val) {
            $modelName[$val['modelid']] = $val['name'];
        }
        include $this->template('authorization_user');
    }

    public function user_show()
    {

    }

    public function verify()
    {
        $uid = intval($GLOBALS['uid']);
        $modelid = intval($GLOBALS['modelid']);
        $models = get_cache('model_member','model');
        $model_field = get_cache('field_'.$modelid,'model');
        $attr_table = $models[$modelid]['attr_table'];
        $result = $this->db->get_one($attr_table, array('uid'=>$uid));
        unset($result['uid']);
        include $this->template('authorization_verify');
    }
    public function do_verify()
    {
        $uid = intval($GLOBALS['uid']);
        $modelid = intval($GLOBALS['modelid']);
        $status = $GLOBALS['sub'] == '通过' ? 1 : 9;
        $remark = $GLOBALS['remark'];
        $where = array(
            'uid' => $uid,
            'modelid' => $modelid
        );
        $data = array(
            'status' => $status,
            'verify_uid' => $_SESSION['_uid'],
            'remark' => $remark
        );
        $this->db->update('member_verify', $data, $where);
        MSG('操作成功', '?m=member&f=authorization&v=user_listing' . $this->su(), 1500);
    }
}