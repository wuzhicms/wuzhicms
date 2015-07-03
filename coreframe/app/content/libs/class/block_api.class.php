<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 碎片／区块添加／更新
 */
class WUZHI_block_api {
	public function __construct() {
        $this->db = load_class('db');
	}
    public function update($keyid, $posids, $datas, $cid = 0) {
        //$this->id.'-'.$this->cid
        if($posids=='') return true;
        $formdata = $tmp = '';
        foreach($datas as $key=>$value) {
            if(in_array($key,array('title','thumb','url','remark','addtime','status'))) {
                $formdata[$key] = $value;
            } else {
                $tmp[$key] = $value;
            }
        }
        if(!empty($tmp)) $formdata['attach'] = serialize($tmp);
        $posid_str = implode(',',$posids);

        $this->db->delete('block_data',"`keyid`='$keyid' AND `blockid` NOT IN($posid_str)");
        $siteid = get_cookie('siteid');
        foreach($posids as $blockid) {
            if($this->db->get_one('block_data',array('keyid'=>$keyid,'blockid'=>$blockid))) {
                $formdata['blockid'] = $blockid;
                $this->db->update('block_data',$formdata,array('keyid'=>$keyid,'blockid'=>$blockid));
            } else {
                $formdata['keyid'] = $keyid;
                $formdata['siteid'] = $siteid;
                $formdata['cid'] = $cid;
                $formdata['blockid'] = $blockid;
                $formdata['sort'] = '50';
                $this->db->insert('block_data',$formdata);
            }
        }

    }
}