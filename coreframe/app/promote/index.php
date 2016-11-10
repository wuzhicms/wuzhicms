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
        if(!$id || !$pid) {
            header("Location:https://www.wuzhicms.com/item-34-60-1.html");
            exit();
        }
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
			$stat_table = date('Ym',SYS_TIME);
			if($r['stat_table']!=$stat_table) {//创建统计表
				load_function('sql');
				$sql = "DROP TABLE IF EXISTS `wz_promote_stat_$stat_table`;
CREATE TABLE `wz_promote_stat_$stat_table` (
  `pid` int(10) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(15) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `qkey` varchar(13) NOT NULL,
  `addtime` datetime NOT NULL,
  `referer` varchar(100) NOT NULL,
  `day` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告统计';
ALTER TABLE `wz_promote_stat_$stat_table`
  ADD KEY `pid_2` (`pid`,`qkey`,`day`);";
				sql_execute($this->db,$sql);
			}
			$this->db->update('promote', array('stat_table'=>$stat_table), array('id' => $id));
            $this->db->insert('promote_stat_'.$month, $formdata);
            header("Location:".$r['url']);
        } else {
            header("Location:http://www.wuzhicms.com");
        }
    }
}
