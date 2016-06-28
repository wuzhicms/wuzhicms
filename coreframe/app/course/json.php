<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
load_function('content','content');
/**
 * 课程
 */
class json{
    private $siteconfigs;
    public  $childs;
	public function __construct() {
        $this->siteconfigs = get_cache('siteconfigs');
        $this->db = load_class('db');
    }
    public function init() {
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        if($_lang=='') $_lang = 'zh';

        $id = intval($GLOBALS['id']);
        $start = strtotime($GLOBALS['start']);
        $end = strtotime($GLOBALS['end']);
        $where = "`id`='$id'";
        $course_list = $this->db->get_list('course_list', $where, '*', 0, 100, 0, 'courseid DESC','','courseid');
        $where = "`id`='$id' AND `starttime`>='$start' AND `endtime`<='$end'";
        $result = $this->db->get_list('course_detail', $where, '*', 0, 100, 0, 'cdid DESC');
        $json_data = array();
        foreach($result as $r) {
            $course = $course_list[$r['courseid']];
            $data = array();
            $data['cdid'] = $r['cdid'];
            if($_lang=='zh') {
                $data['title'] = $course['title']."\r\n".$course['classroom']."\r\n".$course['teacher'];
            } else {
                $data['title'] = $course['title_en']."\r\n".$course['classroom_en']."\r\n".$course['teacher_en'];
            }

            $data['start'] = date('Y-m-d H:i:s',$r['starttime']);
            $data['end'] = date('Y-m-d H:i:s',$r['endtime']);
            if($r['css']) $data['color'] = $r['css'];
            $json_data[] = $data;
        }



        echo json_encode($json_data,true);
    }
    public function view() {
        $_lang = isset($GLOBALS['_lang']) ? $GLOBALS['_lang'] : 'zh';
        if($_lang=='') $_lang = 'zh';

        $cdid = intval($GLOBALS['cdid']);
        $r = $this->db->get_one('course_detail', array('cdid' => $cdid));
        $r2 = $this->db->get_one('course_list', array('courseid' => $r['courseid']));

        if($_lang=='zh') {
            $title = $r2['title'];
            $week = date("N",$r['starttime']);
            $week_arr = array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日');
            $week = $week_arr[$week];
            $classdate = date('Y-m-d',$r['starttime']).'<font color="#843232"> ('.$week.')</font>';
            $starttime = date('H:i',$r['starttime']);
            $endtime = date('H:i',$r['endtime']);
            echo '
<div class="fancy">
	<h3>'.$title.'</h3>

    <p>日期：'.$classdate.' </p>
    <p>时间：'.$starttime.' - '.$endtime.' </p>
    <p>教室：'.$r2['classroom'].' </p>
    <p>老师：'.$r2['teacher'].' </p>
</div>';
        } else {
            $title = $r2['title_en'];
            $week = date("N",$r['starttime']);
            $week_arr = array('','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
            $week = $week_arr[$week];
            $classdate = date('Y-m-d',$r['starttime']).'<font color="#843232"> ('.$week.')</font>';
            $starttime = date('H:i',$r['starttime']);
            $endtime = date('H:i',$r['endtime']);
            echo '
<div class="fancy">
	<h3>'.$title.'</h3>

    <p>Class date：'.$classdate.' </p>
    <p>Class time：'.$starttime.' - '.$endtime.' </p>
    <p>Classroom：'.$r2['classroom_en'].' </p>
    <p>Teacher：'.$r2['teacher_en'].' </p>
</div>';
        }

    }
}
?>