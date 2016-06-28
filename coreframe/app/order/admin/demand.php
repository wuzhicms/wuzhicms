<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
defined('IN_WZ') or exit('No direct script access allowed');
/**
 * 订单收集管理
 */
load_class('admin');
class demand extends WUZHI_admin {
	private $db;
	function __construct() {
		$this->db = load_class('db');
	}
    /**
     * 列表
     */
    public function listing() {
        load_class('form');

        $fieldtypes = array('姓名','电话','品牌','车型');
        $flag = $GLOBALS['flag'];
        $flag_arr = array('未转发','已转发');
        $page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
        $page = max($page,1);
        $where = '1';
        if($_SESSION['role']==4) {
            //客服
            $kf_username = get_cookie('username');
            $where = "`kf_username`='$kf_username'";
        }
        $keyValue = strip_tags($GLOBALS['keyValue']);
        $fieldtype = intval($GLOBALS['fieldtype']);
        if($keyValue) {
            switch($fieldtype) {
                case 0:
                    $where .= " AND `username`='$keyValue'";
                    break;
                case 1:
                    $where .= " AND `mobile`='$keyValue'";
                    break;
                case 2:
                    $where .= " AND `pinpai`='$keyValue'";
                    break;
                case 3:
                    $where .= " AND `chexing`='$keyValue'";
                    break;
            }
        }
        if($flag!='' && $flag==0 || $flag) $where .=" AND `flag`='$flag'";
        $starttime = '';
        $endtime = '';
        if($GLOBALS['starttime']) {
            $starttime = strtotime($GLOBALS['starttime']);
            $where .= " AND `addtime`>'$starttime'";
        }
        if($GLOBALS['endtime']) {
            $endtime = strtotime($GLOBALS['endtime']);
            $where .= " AND `endtime`<'$endtime'";
        }
        $admin_result = $this->db->get_list('admin', array('role'=>4), '*', 0, 20, 0);
        if(isset($GLOBALS['exp'])) {
            $pagesize = 1000;
        } else {
            $pagesize = 20;
        }
        $result = $this->db->get_list('demand', $where, '*', 0, $pagesize,$page,'did DESC');
        if(isset($GLOBALS['exp'])) {
            $this->export_excel($result);
        }
        $pages = $this->db->pages;
        $total = $this->db->number;
        include $this->template('demand_listing');
    }
    /**
     * zf
     */
    public function relay() {
        $did = intval($GLOBALS['did']);
        $r = $this->db->get_one('demand', array('did' => $did));
        $keyValue = '';
        $keyType = '';
        if(isset($GLOBALS['keyType'])) {
            $keyType = $GLOBALS['keyType'];
            $keyValue = $GLOBALS['keyValue'];
            if($keyValue) {
                $where = "modelid=11 AND `$keyType` LIKE '%$keyValue%'";
                $result = $this->db->get_list('member', $where, '*', 0, 20, 0, 'uid DESC');
            }
        } elseif(isset($GLOBALS['submit'])) {
            load_function('common','pay');
            $formdata = array();
            $formdata['order_no'] = create_order_no();
            $formdata['to_uid'] = intval($GLOBALS['to_uid']);
            $formdata['username'] = $r['username'];
            $formdata['mobile'] = $r['mobile'];
            $formdata['pinpai'] = $r['pinpai'];
            $formdata['chexing'] = $r['chexing'];
            $formdata['addtime'] = $r['addtime'];
            $formdata['keytype'] = 0;//游客订单
            $formdata['zftime'] = SYS_TIME;
            $this->db->insert('demand_relay', $formdata);
            $formdata2 = array();
            $formdata2['op_uid'] = $_SESSION['uid'];
            $formdata2['to_uid'] = intval($GLOBALS['to_uid']);
            $formdata2['to_username'] = $GLOBALS['to_username'];
            $formdata2['updatetime'] = SYS_TIME;
            $this->db->insert('demand_history', $formdata2);
            $this->db->update('demand', array('flag'=>1,'jxs_username'=>$formdata2['to_username']),array('did' => $did));
            $forward = strip_tags($GLOBALS['forward']);
            MSG('发送成功',$forward);
        } else {
            $uid = $_SESSION['uid'];
            $where = "op_uid='$uid'";
            $data = $this->db->get_one('demand_history', $where,'*', 0,'hid DESC');
        }
        include $this->template('demand_relay');
    }
    /**
     * 分配订单给客服
     */
    public function kf() {
        if(empty($GLOBALS['ids'])) MSG('没有选择任何订单');
        $kf_username = strip_tags($GLOBALS['kf_username']);
        foreach($GLOBALS['ids'] as $id) {
            $this->db->update('demand', array('kf_username'=>$kf_username), array('did' => $id));
        }
        MSG('订单分配成功',HTTP_REFERER);
    }
    private function export_excel($result){
        $new_field = array(
            'did' => array('name' => 'ID'),
            'username' => array('name' => '姓名'),
            'mobile' => array('name' => '电话'),
            'pinpai' => array('name' => '品牌'),
            'chexing' => array('name' => '车型'),
            'addtime' => array('name' => '提交时间'),
            'publisher' => array('name' => '提交人'),
            'kf_username' => array('name' => '所属客服'),
            'jxs_username' => array('name' => '所属经销商'),
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
        header('Content-Disposition: attachment;filename="购车咨询.xls"');
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
    /**
     * 删除
     */
    public function delete() {
        $did = intval($GLOBALS['did']);
        $this->db->delete('demand',array('did'=>$did));
        MSG(L('delete success'),HTTP_REFERER,1500);
    }
}