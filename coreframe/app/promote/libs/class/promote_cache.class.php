<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('common','promote');
/**
 * 广告位缓存
 */
class WUZHI_promote_cache{
    public function __construct() {
        $this->db = load_class('db');
    }
    /**
     * promote_cache
     * @return bool
     */
    public function cache_all() {
        $result = $this->db->get_list('promote_place', '', '*', 0, 100,0,'pid ASC','','pid');
        if(!empty($result)) {
            set_cache('place',$result,'promote');
            foreach($result as $rs) {
                $data2 = $this->db->get_list('promote',array('pid'=>$rs['pid']), '*', 0, 100,0,'id DESC');
                $this->cache_js($rs['pid']);
                set_cache('place_'.$rs['pid'],$data2,'promote');
            }
        }
        return true;
    }
    private function cache_js($pid) {
        $pr = $this->db->get_one('promote_place', array('pid' => $pid));
        $where = "`pid`='$pid' AND starttime<".SYS_TIME." AND endtime>".SYS_TIME;
        $result = $this->db->get_list('promote', $where, '*', 0, 10, 0, 'id DESC');
        if(!empty($result)) {
            $rand_key = array_rand($result,1);
            $rand_result = $result[$rand_key];

        } else {
            $rand_result['pid'] = $pid;
            $rand_result['file'] = 'http://placehold.it/'.$pr['width'].'x'.$pr['height'];
            $rand_result['template'] = 'show_pic';
        }


        $template = $rand_result['template'];
        $file = WWW_ROOT.'promote/'.$pid.'.js';

        ob_start();
        include T('promote',$template);
        $data = ob_get_contents();
        ob_clean();
        $dir = dirname($file);
        if(!is_dir($dir)) {
            mkdir($dir, 0777,1);
        }
        $strlen = file_put_contents($file, $data);
        if(!is_writable($file)) {
            $file = str_replace(WWW_ROOT,'',$file);
            MSG(L('file').'：'.$file.'<br>'.L('not_writable'));
        }
    }

}