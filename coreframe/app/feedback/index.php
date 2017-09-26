<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');

class index{
    private $siteconfigs;
    public function __construct() {
		$this->siteconfigs = get_cache('siteconfigs_1');
        $this->db = load_class('db');
    }

    /**
     * 反馈问题首页
     */
    public function init() {
        $siteconfigs = $this->siteconfigs;
        $seo_title = '反馈问题-'.$siteconfigs['sitename'];
        $seo_keywords = '反馈问题,'.$siteconfigs['seo_keywords'];
        $seo_description = $siteconfigs['seo_description'];
        $categorys = get_cache('category','content');
        $forward = encode(HTTP_REFERER);
        include T('feedback','index');
    }
    /**
     *反馈问题
     */
    public function contact(){

        if (isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['url'] = decode($formdata['forward']);
            $formdata['content'] = remove_xss($formdata['content']);
            $formdata['addtime'] = SYS_TIME;
            $formdata['linkman'] = remove_xss($formdata['linkman']);
            $formdata['email'] = remove_xss($formdata['email']);
            $formdata['ip'] = get_ip();
            $formdata['status'] = 9;//未回复
            $linkageid = $this->db->insert('feedback', $formdata);
            MSG('感谢您的反馈!',$formdata['url'],3000);
        }
        else{
            include T('feedback','index');
        }
    }
}
?>