<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 设置
 */
load_class('admin');

class set extends WUZHI_admin {
    private $db;
    function __construct() {
        $this->db = load_class('db');
    }

    /**
     * 基本设置
     */
    public function setting() {
        if(isset($GLOBALS['submit'])) {
            $setting = array_map('remove_xss',$GLOBALS['form']);
            $setting['reply_content'] = strip_tags($setting['reply_content']);
            set_cache('reply_content',$setting,'weixin');
            $setting = serialize($setting);

            $this->db->update('setting',array('data'=>$setting),array('m'=>'weixin','keyid'=>'reply_content'));
            MSG('更新成功',HTTP_REFERER);
        } else {
            $r = $this->db->get_one('setting',array('m'=>'weixin','keyid'=>'reply_content'));
            $setting = unserialize($r['data']);
            include $this->template('setting');
        }
    }
    /**
     * 设置菜单
     */
    public function menu_setting() {
        $weixin_config = get_config('weixin_config');
        define(AppId, $weixin_config['appid']);//定义AppId，需要在微信公众平台申请自定义菜单后会得到
        define(AppSecret, $weixin_config['secret']);//定义AppSecret，需要在微信公众平台申请自定义菜单后会得到

        load_function('curl');

        if(isset($GLOBALS['submit'])) {
            $menu_setting = trim($GLOBALS['form']['menu_setting']);
            $menu = load_class('menu','weixin');//引入微信类
            $creatMenu = $menu->creatMenu($menu_setting);//创建菜单
            $creatMenu_arr = json_decode($creatMenu,true);
            if($creatMenu_arr['errcode']!=0) {
                MSG($creatMenu);
            } else {
                $this->db->update('setting',array('data'=>$menu_setting),array('m'=>'weixin','keyid'=>'configs'));
                MSG('创建成功，菜单将在24小时后生效，您可以取消关注，再关注看到最新菜单');
            }
        } else {
            $r = $this->db->get_one('setting',array('m'=>'weixin','keyid'=>'configs'));
            $menu_setting = $r['data'];

            include $this->template('menu_setting');
        }
    }
    /**
     * 用户关注设置
     */
    public function subscribe() {
        if(isset($GLOBALS['submit'])) {
            $formdata = array();
            $formdata['msgtype'] = intval($GLOBALS['msgtype']);

            if($GLOBALS['msgtype']) {//文本
                $content = strip_tags($GLOBALS['text_content']);
                set_cache('subscribe',array('data'=>$content),'weixin');
            } else {
                $content = array();
                foreach($GLOBALS['titles'] as $key=>$title) {
                    $title = strip_tags($title);
                    $des = $key==1 ? $GLOBALS['des'][$key] : '';
                    $content[] = array("Title"=>$title,  "Description"=>$des, "PicUrl"=>$GLOBALS['imgs'][$key], "Url" =>$GLOBALS['urls'][$key]);
                }

                set_cache('subscribe',$content,'weixin');
            }
            $formdata['content'] = $content;
            $formdata = serialize($formdata);
            $this->db->update('setting',array('data'=>$formdata),array('m'=>'weixin','keyid'=>'subscribe'));

            MSG('更新成功！',HTTP_REFERER);
        } else {
            $r = $this->db->get_one('setting',array('m'=>'weixin','keyid'=>'subscribe'));
            $setting = unserialize($r['data']);
            if($setting['msgtype']==1) {
                $text_content = $setting['content'];
                $contents = array();
                $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
                $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
                $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
                $setting['content'] = $contents;
            } else {
                $text_content = '';
            }

            load_class('form');
            include $this->template('subscribe');
        }
    }

    /**
     * fullpage
     */
    public function fullpage() {
        if(isset($GLOBALS['submit'])) {

            $content = array();
            foreach($GLOBALS['titles'] as $key=>$title) {
                $title = strip_tags($title);
                $content[] = array("Title"=>$title,  "Description"=>$GLOBALS['des'][$key], "PicUrl"=>$GLOBALS['PicUrl'][$key], "Url" =>$GLOBALS['urls'][$key]);
            }
            set_cache('fullpage',$content,'weixin');
            $content = serialize($content);
            $this->db->update('setting',array('data'=>$content),array('m'=>'weixin','keyid'=>'fullpage'));

            MSG('更新成功！',HTTP_REFERER);
        } else {
            $r = $this->db->get_one('setting',array('m'=>'weixin','keyid'=>'fullpage'));
            $contents = unserialize($r['data']);
           // print_r($contents);
            /*
            $contents = array();
            $contents[] = array("Title"=>'111',  "Description"=>'A', "PicUrl"=>'', "Url" =>'');
            $contents[] = array("Title"=>'222',  "Description"=>'B', "PicUrl"=>'', "Url" =>'');
            $contents[] = array("Title"=>'333',  "Description"=>'C', "PicUrl"=>'', "Url" =>'');
            $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
            $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
            $contents[] = array("Title"=>'',  "Description"=>'', "PicUrl"=>'', "Url" =>'');
            */
            load_class('form');
            include $this->template('fullpage');
        }
    }
}