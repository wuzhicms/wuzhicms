<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/1/13 22:05
 * @version    1.0.1
 */
defined('IN_WZ') or exit('No direct script access allowed');
load_class('admin');
load_class('form');
class verify extends WUZHI_admin
{
    private $db, $member;
    function __construct() {
        $this->member = load_class('member', M);
        $this->db = load_class('db');
        $this->group = get_cache('group', M);
        $this->model = $this->db->get_list('model', '`m`="member"', 'modelid,name,attr_table', 0, 200, 0, '', '', 'modelid');
        $this->setting = get_cache('setting', 'member');
    }

    public function verify()
    {

    }

    public function setting()
    {
        include $this->template('verify_setting');
    }

    public function add()
    {
        include $this->template('verify_add');
    }
}