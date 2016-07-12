<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 敏感词过滤类
 */
class WUZHI_badword{
    public function __construct() {

    }

    /**
     * 敏感词过滤
     * @param $string 要检查的字符串
     * @return string
     */
    public function filter($string) {
        static $badwords;
        if(empty($badwords)) {
            $badwords = get_cache('badword');
        }
        $words = '';
        $words = array_combine($badwords,array_fill(0,count($badwords),'*'));
        return strtr($string, $words);
    }

    /**
     * 更新敏感词缓存，默认最多1万个敏感词
     * @return bool
     */
    public function cache_all() {
        $db = load_class('db');
        $result = $db->get_list('badword', '', 'word', 0, 10000);
        $tmp = "<?php return array(";
        foreach($result as $rs) {
            $tmp .= "'".$rs['word']."',";
        }
        $tmp .= ")?>";
       // print_r($tmp);exit;
        set_cache('badword',$tmp);
        return true;
	}

}