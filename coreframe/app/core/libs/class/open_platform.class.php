<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
* 开放平台
 */
load_function('curl');
class WUZHI_open_platform {
    private $apiurl = 'http://www.wuzhicms.com/index.php?m=open&f=api';
    /**
     * 构造函数，初始化一个查询实例
     */
    public function __construct() {
        $this->db = load_class('db');
        $this->setting = $this->db->get_one('setting',array('keyid'=>'wuzhicms_token','m'=>'core'));
        $this->token = $this->setting['data'];
        if(!$this->token) MSG('请先配置安全识别码','?m=core&f=set&v=safe&_su='.$GLOBALS['_su']);
    }

    /**
     * 获取新的碎片ID
     * @return mixed
     */
    public function get_blockid(){
        $apiurl = $this->apiurl.'&v=get_blockid&token='.$this->token;
        $data = get_curl($apiurl);
        $data = json_decode($data,true);
        if($data['code']!=100) MSG($data['msg']);
        return $data['blockid'];
    }
    /**
     * 获取新的菜单ID
     * @return mixed
     */
    public function get_menuid(){
        $apiurl = $this->apiurl.'&v=get_menuid&token='.$this->token;
        $data = get_curl($apiurl);
        $data = json_decode($data,true);
        if($data['code']!=100) MSG($data['msg']);
        return $data['menuid'];
    }
}

