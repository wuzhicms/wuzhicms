<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 课程管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 列表
     */
    public function listing() {
        $id = intval($GLOBALS['id']);
        if(!$id) {
            header("Location:index.php?m=content&f=content&v=listing&_lang=zh&cid=231".$this->su());
            exit;
        }
        $data = $this->db->get_one('content_share', array('id' => $id));
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('course_list', '', '*', 0, 50,$page,'courseid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('listing');
    }
    /**
     * 课程日历
     */
    public function calendar() {
        $id = intval($GLOBALS['id']);
        if(!$id) {
            header("Location:index.php?m=content&f=content&v=listing&_lang=zh&cid=231".$this->su());
            exit;
        }
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('course_list', '', '*', 0, 20,$page,'courseid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $data = $this->db->get_one('content_share', array('id' => $id));
        if($_lang=='en') {
            include $this->template('calendar_en');
        } else {
            include $this->template('calendar');
        }

    }
    /**
     * 添加
     */
    public function add() {
        $id = intval($GLOBALS['id']);
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['id'] = intval($GLOBALS['id']);
            $formdata['title'] = remove_xss($formdata['title']);
            $formdata['title_en'] = remove_xss($formdata['title_en']);
            $formdata['classroom'] = remove_xss($formdata['classroom']);
            $formdata['classroom_en'] = remove_xss($formdata['classroom_en']);
            $formdata['teacher'] = remove_xss($formdata['teacher']);
            $formdata['teacher_en'] = remove_xss($formdata['teacher_en']);

            $formdata['addtime'] = SYS_TIME;
            $formdata['css'] = $GLOBALS['title_css'] ? '#'.remove_xss(ltrim($GLOBALS['title_css'],'#')) : '';
            $this->db->insert('course_list',$formdata);

            $forward = $GLOBALS['forward'];
            MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d',$endtime);
            $data = $this->db->get_one('content_share', array('id' => $id));
            include $this->template('add');
        }
    }
    /**
     * 修改
     */
    public function edit() {
        $id = intval($GLOBALS['id']);
        $courseid = intval($GLOBALS['courseid']);
        if(isset($GLOBALS['submit'])) {
            $formdata = $GLOBALS['form'];
            $formdata['title'] = remove_xss($formdata['title']);
            $formdata['title_en'] = remove_xss($formdata['title_en']);
            $formdata['classroom'] = remove_xss($formdata['classroom']);
            $formdata['classroom_en'] = remove_xss($formdata['classroom_en']);
            $formdata['teacher'] = remove_xss($formdata['teacher']);
            $formdata['teacher_en'] = remove_xss($formdata['teacher_en']);

            $formdata['css'] = $GLOBALS['title_css'] ? '#'.remove_xss(ltrim($GLOBALS['title_css'],'#')) : '';
            $this->db->update('course_list',$formdata,array('courseid'=>$courseid));

            $forward = $GLOBALS['forward'];
            MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d',$endtime);
            $data = $this->db->get_one('content_share', array('id' => $id));
            $r = $this->db->get_one('course_list', array('courseid' => $courseid));

            include $this->template('edit');
        }
    }
    /**
     * 添加排期
     */
    public function add_detail() {
        $id = intval($GLOBALS['id']);
        $courseid = intval($GLOBALS['courseid']);
        if(isset($GLOBALS['submit'])) {
            $starttime = $GLOBALS['starttime'];
            $endtime = $GLOBALS['endtime'];

            $formdata2 = array();
            $formdata2['id'] = $id;
            $formdata2['courseid'] = $courseid;
            $type = intval($GLOBALS['type']);
            $formdata2['starttime'] = strtotime($GLOBALS['startdate'].' '.$starttime);

            if(empty($GLOBALS['enddate']) || $GLOBALS['enddate']==$GLOBALS['startdate']) {
                $formdata2['endtime'] = strtotime($GLOBALS['startdate'].' '.$endtime);
                $this->db->insert('course_detail',$formdata2);
            } else {
                $tmp = $startdate = strtotime($GLOBALS['startdate']);
                $enddate = strtotime($GLOBALS['enddate']);
                $total_days =  ($enddate-$startdate)/86400;
                //TODO test
                //$this->db->query("TRUNCATE table wz_course_detail");
                $total_days+=2;
                if($type==2) {

                }
                for($i=1;$i<$total_days;$i++) {
                    if($type==1) {
                        if($i==1 || $i%7==1) {
                            $enddate = date('Y-m-d',$tmp);

                            $formdata2['starttime'] = strtotime($enddate.' '.$starttime);
                            $formdata2['endtime'] = strtotime($enddate.' '.$endtime);
                            $this->db->insert('course_detail',$formdata2);

                        }
                    } elseif($type==2) {
                        echo $enddate = date('Y-m-d',$tmp);

                        echo $current_week = intval(date('W',strtotime($enddate)));
                        if($current_week%2==1 && ($i==1 || $i%7==1)) {
                            $enddate = date('Y-m-d',$tmp);

                            $formdata2['starttime'] = strtotime($enddate.' '.$starttime);
                            $formdata2['endtime'] = strtotime($enddate.' '.$endtime);
                            $this->db->insert('course_detail',$formdata2);

                        }

                        echo '<br>';
                    } elseif($type==3) {
                        echo $enddate = date('Y-m-d',$tmp);

                        echo $current_week = intval(date('W',strtotime($enddate)));
                        if($current_week%2==0 && ($i==1 || $i%7==1)) {
                            $enddate = date('Y-m-d',$tmp);

                            $formdata2['starttime'] = strtotime($enddate.' '.$starttime);
                            $formdata2['endtime'] = strtotime($enddate.' '.$endtime);
                            $this->db->insert('course_detail',$formdata2);

                        }

                        echo '<br>';
                    }

                    $tmp+=86400;
                }

            }


            $forward = $GLOBALS['forward'];
            MSG(L('operation success'),$forward);
        } else {
            $show_formjs = 1;
            $form = load_class('form');
            $endtime = SYS_TIME+86400*30;
            $endtime = date('Y-m-d',$endtime);
            $data = $this->db->get_one('content_share', array('id' => $id));
            $data2 = $this->db->get_one('course_list', array('courseid' => $courseid));
            include $this->template('add_detail');
        }
    }

    /**
     * 管理课程详情
     */
    public function manage_detail() {
        $id = intval($GLOBALS['id']);
        $courseid = intval($GLOBALS['courseid']);
        if(!$id) {
            header("Location:index.php?m=content&f=content&v=listing&_lang=zh&cid=231".$this->su());
            exit;
        }
        $data = $this->db->get_one('content_share', array('id' => $id));
        $data2 = $this->db->get_one('course_list', array('courseid' => $courseid));
        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $result = $this->db->get_list('course_detail', '', '*', 0, 50,$page,'cdid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('manage_detail');
    }

    /**
     * 删除
     */
    public function delete() {
        $id = intval($GLOBALS['id']);
        $courseid = intval($GLOBALS['courseid']);
        $this->db->delete('course_list',array('courseid'=>$courseid));
        $this->db->delete('course_detail',array('courseid'=>$courseid));
        MSG(L('delete success'),'?m=course&f=index&v=listing&id='.$id.$this->su(),1500);
    }

    /**
     * 删除
     */
    public function delete_detail() {
        $id = intval($GLOBALS['id']);
        $courseid = intval($GLOBALS['courseid']);
        $cdid = intval($GLOBALS['cdid']);
        foreach($GLOBALS['cdids'] as $cdid) {
            $this->db->delete('course_detail',array('cdid'=>$cdid));
        }
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}

