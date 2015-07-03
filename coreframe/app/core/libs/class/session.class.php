<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

/**
 * session 数据存储
 */
class WUZHI_session
{
    public $lifetime = 1800;
    public $db;
    public $table;

    /**
     * 构造函数
     *
     */
    public function __construct()
    {
        $this->db = load_class('db');
        session_set_save_handler(array(&$this, 'open'), array(&$this, 'close'), array(&$this, 'read'), array(&$this, 'write'), array(&$this, 'destroy'), array(&$this, 'gc'));
        session_start();
    }

    /**
     * session_set_save_handler  open方法
     * @param $save_path
     * @param $session_name
     * @return true
     */
    public function open($save_path, $session_name)
    {
        return true;
    }

    /**
     * session_set_save_handler  close方法
     * @return bool
     */
    public function close()
    {
        return $this->gc($this->lifetime);
    }

    /**
     * 读取session_id
     * session_set_save_handler  read方法
     * @return string 读取session_id
     */
    public function read($id)
    {
        $r = $this->db->get_one('session', array('sessionid' => $id), 'data');
        return $r ? $r['data'] : '';
    }

    /**
     * 写入session_id 的值
     *
     * @param $id session
     * @param $data 值
     * @return mixed query 执行结果
     */
    public function write($id, $data)
    {
        $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : 0;
        $gid = isset($_SESSION['gid']) ? $_SESSION['gid'] : 0;
        $m = defined('M') ? M : '';
        $f = defined('F') ? F : '';
        $v = defined('V') ? V : '';
        if (strlen($data) > 255) $data = '';
        $ip = get_ip();
        $sessiondata = array('sessionid' => $id, 'uid' => $uid, 'ip' => $ip, 'lastvisit' => SYS_TIME, 'role' => $role, 'gid' => $gid, 'm' => $m, 'f' => $f, 'v' => $v, 'data' => $data,);
        return $this->db->insert('session', $sessiondata, TRUE, TRUE);
    }

    /**
     * 删除指定的session_id
     *
     * @param $id session
     * @return bool
     */
    public function destroy($id)
    {
        return $this->db->delete('session', array('sessionid' => $id));
    }

    /**
     * 删除过期的 session
     *
     * @param $maxlifetime 存活期时间
     * @return bool
     */
    public function gc($maxlifetime)
    {
        $expiretime = SYS_TIME - $maxlifetime;
        return $this->db->delete('session', "`lastvisit`<$expiretime");
    }
}

?>