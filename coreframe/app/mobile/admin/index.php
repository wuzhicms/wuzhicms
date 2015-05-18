<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 在线支付
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;


	function __construct() {
		$this->db = load_class('db');

	}


    /**
     * 手机触屏配置
     */
    public function setting() {

        if(isset($GLOBALS['submit'])) {
            $setting = array_map('remove_xss',$GLOBALS['form']);
            $setting = serialize($setting);
            $this->db->update('setting',array('data'=>$setting),array('m'=>'mobile','keyid'=>'configs'));
            load_function('admin');
            set_web_config('SUPPORT_MOBILE',intval($GLOBALS['support_mobile']));
            MSG(L('operation success'),HTTP_REFERER);
        } else {
            $show_formjs = 1;
            load_class('qrcode');
            if(is_writable(ATTACHMENT_ROOT."qr_image/mobile.png")) {
                $iswrite = 1;
                WUZHI_qrcode::png(WEBURL.'index.php', ATTACHMENT_ROOT."qr_image/mobile.png",'L',4,0);
            } else {
                $iswrite = 0;
            }

            $r = $this->db->get_one('setting',array('m'=>'mobile','keyid'=>'configs'));
            $setting = unserialize($r['data']);
            include $this->template('setting');
        }
    }
    public function category() {
        $model_cache = get_cache('model_content','model');
        $where = array('keyid'=>'content');
        $result = $this->db->get_list('category', $where, '*', 0, 2000, 0, 'sort ASC', '', 'cid');
        foreach($result as $cid=>$r) {
            $result[$cid]['modelname'] = $model_cache[$r['modelid']]['name'];
            $result[$cid]['mb'] = $r['mb'] ? $r['mb'] : $r['name'];
            $result[$cid]['ms1'] = $r['mshow']==1 ? 'checked' : '';
            $result[$cid]['ms2'] = $r['mshow']==0 ? 'checked' : '';
            $result[$cid]['url'] = '<a href="'.$r['url'].'" target="_blank">访问</a>';
        }
        $tree = load_class('tree','core',$result);
        $tree->icon = array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;├&nbsp;&nbsp;','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└&nbsp;&nbsp;');
        //$tree->icon = array('<span class="_tree1"></span>','<span class="_tree2"></span>','<span class="_tree3"></span>');
        $tree_data = '';

        //格式字符串
        $str="<tr><td>\$cid</td></td><td id='\$cid' \$selected>\$spacer\$name</td><td><div><input class='left' name='mbs[\$cid]' type='text' size='15' value='\$mb'></div></td><td><div><input class='center' name='mshows[\$cid]' type='radio' value='1' \$ms1> 显示  <input class='center' name='mshows[\$cid]' type='radio' value='0' \$ms2> 隐藏</div></td><td>\$modelname</td><td>\$url</td></tr>";

        //返回树
        $tree_data.=$tree->create(0,$str);

        $tree_data.="";
        $show_dialog = 1;
        include $this->template('category_listing');
    }

    public function edit_category() {
        foreach($GLOBALS['mbs'] as $cid => $mb) {
            $mshow = $GLOBALS['mshows'][$cid];
            $this->db->update('category',array('mb'=>$mb,'mshow'=>$mshow),array('cid'=>$cid));
        }
        //更新缓存
        $category_cache = load_class('category_cache','content');
        $category_cache->cache_all();

        MSG(L('operation success'));
    }
}