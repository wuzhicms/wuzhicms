<?php

/**
 * Class index
 */
class index{
	function __construct() {
        $this->db = load_class('db');
	}

    /**
     * 跳转至链接
     */
    public function stat() {
        $id = intval($GLOBALS['id']);
        $pid = intval($GLOBALS['pid']);
        if(!$id || !$pid) exit();
        $qkey = get_cookie('qkey');
        if($qkey=='') {
            $qkey = uniqid();//13位 唯一值，从cookie中获取和写入，用于记录uv和pv
            $lefttime = SYS_TIME+2592000;
            set_cookie('qkey',$qkey,$lefttime);
        }
        $r = $this->db->get_one('promote', array('id' => $id));
        if($r && $r['url']) {
            $formdata = array();
            $formdata['pid'] = $pid;
            $formdata['id'] = $id;
            $formdata['ip'] = get_ip();
            $formdata['uid'] = get_cookie('_uid');
            $formdata['qkey'] = $qkey;
            $formdata['addtime'] = date('Y-m-d H:i:s',SYS_TIME);
            $formdata['day'] = date('d',SYS_TIME);
            if(HTTP_REFERER!='') {
                $formdata['referer'] = str_replace(WEBURL,'',strip_tags(HTTP_REFERER));
            }
            $month = date('Ym',SYS_TIME);
            $this->db->insert('promote_stat_'.$month, $formdata);
            header("Location:".$r['url']);
        } else {
            header("Location:http://www.wuzhicms.com");
        }
    }
}
