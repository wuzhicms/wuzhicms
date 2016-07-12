<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 积分兑换订单管理
 */
load_class('admin');
class index extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
        $this->status_arr = array(1=>'注册会员',2=>'会员+游客',3=>'后台管理员');
	}
    /**
     * 订单列表
     */
    public function listing() {
        load_class('form');
        $fieldtypes = array('订单ID','标题','下单会员','物流单号');
        $flag = $GLOBALS['flag'];
        $status = array();
        $status[1] = '待发货';
        $status[2] = '已发货';
        $status[3] = '订单完成';

        $status_arr = $this->status_arr;
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $keyValue = strip_tags($GLOBALS['keyValue']);
        $fieldtype = intval($GLOBALS['fieldtype']);
        $where = '1';
        if($keyValue) {
            switch($fieldtype) {
                case 0:
                    $where .= " AND `order_no`='$keyValue'";
                    break;
                case 1:
                    $where .= " AND `remark` LIKE '%$keyValue%'";
                    break;
                case 2:
                    $r = $this->db->get_one('member', array('username' => $keyValue));
                    $uid = $r['uid'];
                    $where .= " AND `uid`='$uid'";
                    break;
                case 3:
                    $where .= " AND `snid`='$keyValue'";
                    break;
            }
        }
        if($flag!='' && $flag==0 || $flag) $where .=" AND `status`='$flag'";
        $starttime = '';
        $endtime = '';
        if($GLOBALS['starttime']) {
            $starttime = strtotime($GLOBALS['starttime']);
            $where .= " AND `addtime`>'$starttime'";
        }
        if($GLOBALS['endtime']) {
            $endtime = strtotime($GLOBALS['endtime']);
            $where .= " AND `addtime`<'$endtime'";
        }
        $result_arr = $this->db->get_list('order_point', $where, '*', 0, 20,$page,'orderid DESC');
        $pages = $this->db->pages;
        $total = $this->db->number;
        $result = array();
        foreach($result_arr as $r) {
            $mr = $this->db->get_one('member',array('uid'=>$r['uid']));
            $addr = $this->db->get_one('express_address',array('addressid'=>$r['addressid']));
            $r['order_no'] = ' '.$r['order_no'];
            $r['username'] = $mr['username'];
            $r['post_time'] = $r['post_time'] ? date('Y-m-d H:i:s',$r['post_time']) : '';
            $r['addressee'] = $addr['addressee'];
            $r['mobile'] = $addr['mobile'];
            $r['tel'] = $addr['tel'];
            $r['address'] = $addr['province'].' '.$addr['city'].' '.$addr['address'];
            $result[] = $r;
        }
        if(isset($GLOBALS['exp'])) {
            $this->export_excel($result);
        }

        include $this->template('listing');
    }

    /**
     * 发货
     */
    public function send() {
        $orderid = intval($GLOBALS['orderid']);
        if(isset($GLOBALS['submit'])) {

            $formdata = array();
            $formdata['post_time'] = SYS_TIME;
            $formdata['status'] = 3;
            $formdata['express'] = $GLOBALS['express'];
            $formdata['snid'] = remove_xss($GLOBALS['snid']);
            $formdata['note'] = remove_xss($GLOBALS['note']);
            $this->db->update('order_point',$formdata,array('orderid'=>$orderid));
            MSG(L('operation_success').'<script>top.window.frames["iframeid"].location.reload();top.dialog.get(window).close().remove();</script>');
        } else {
            $r = $this->db->get_one('order_point',array('orderid'=>$orderid));
            $er = $this->db->get_one('express_address',array('addressid'=>$r['addressid']));

            $result = $this->db->get_list('express', '', '*', 0, 50,0,'eid ASC');
            include $this->template('send');
        }
    }

    /**
     * 查看
     */
    public function view() {
        $orderid = intval($GLOBALS['orderid']);
        $r = $this->db->get_one('order_point',array('orderid'=>$orderid));
        include $this->template('view');
    }
    private function export_excel($result){
        $new_field = array(
            'order_no' => array('name' => '订单ID'),
            'remark' => array('name' => '名称'),
            'addtime' => array('name' => '申请时间'),
            'post_time' => array('name' => '发货时间'),
            'express' => array('name' => '物流'),
            'snid' => array('name' => '物流单号'),
            'username' => array('name' => '下单会员'),
            'addressee' => array('name' => '收件人'),
            'mobile' => array('name' => '手机'),
            'tel' => array('name' => '固话'),
            'address' => array('name' => '收件地址'),
        );

        $cell_field = array('', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        require_once COREFRAME_ROOT . 'extend/class/PHPExcel.php';
// Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
// Set document properties
        $objPHPExcel->getProperties()->setCreator("wuzhicms.com")->setLastModifiedBy("wuzhicms.com")->setTitle("cheyouwang")->setSubject("cheyouwang Document")->setDescription("cheyouwang")->setKeywords("cheyouwang")->setCategory("Test result file");
// Add some data
        $i = 1;
        foreach ($new_field as $field => $rs) {
            //echo $cell_field[$i].'1 + '.$rs['name']."\r\n";
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_field[$i] . '1', $rs['name']);
            $i++;
        }

        $j = 2;
        foreach ($result as $_rs) {
            $i = 1;
            foreach ($new_field as $field => $rs) {
                if($field=='addtime') {
                    $_rs[$field] = date('Y-m-d H:i:s',$_rs[$field]);
                }
                $pre = '';
                if($field=='mobile') $pre = ' ';
                $_rs[$field] = $pre.$_rs[$field];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cell_field[$i] . $j, $_rs[$field]);
                $i++;
            }
            $j++;
        }
//exit;
// Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('车游网');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="积分兑换.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}