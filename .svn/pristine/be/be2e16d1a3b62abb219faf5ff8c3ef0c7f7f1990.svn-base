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
	private $payments;
	private $status_arr;

	function __construct(){
		$this->db = load_class('db');
		$this->payments_res = $this->db->get_list('payment');
		$this->payments = key_value($this->payments_res, 'id', 'name');
		$this->payments[0] = '异常';
		$this->status_arr = array('-1' => '回收站', 1 => '交易成功', 2 => '交易失败', 3 => '交易错误', 4 => '交易超时', 5 => '交易取消', 6 => '等待用户付款', 7 => '待商家发货', 8 => '待用户确认收货', 9 => '退款成功', 10 => '交易进行中',11 => '支付成功(作废订单)');
	}

	/**
	 * 支付列表
	 */
	public function listing(){
		$fieldtypes = array('订单号', '手机号', '所属客服', '经销商');
		$keytype = isset($GLOBALS['keytype']) ? intval($GLOBALS['keytype']) : 0;
		$payments = $this->payments;
		$status_arr = $this->status_arr;
		$page = isset($GLOBALS['page']) ? intval($GLOBALS['page']) : 1;
		$page = max($page, 1);
		$status = $GLOBALS['status'];

		if ($status) {
			$where = 'status=' . $status;
		} else {
			$where = 'status>0';
		}
		if ($keytype) {
			$where .= " AND `keytype`='$keytype'";
		}
		$keyValue = strip_tags($GLOBALS['keyValue']);
		$fieldtype = intval($GLOBALS['fieldtype']);
		if ($keyValue) {
			switch ($fieldtype) {
				case 0:
					$where .= " AND `order_no`='$keyValue'";
					break;
				case 1:
					$where .= " AND `telephone`='$keyValue'";
					break;
				case 2:
					$where .= " AND `kf_username`='$keyValue'";
					break;
				case 3:
					$where .= " AND `jxs_username`='$keyValue'";
					break;
			}
		}

		if ($_SESSION['role'] == 4) {
			//客服
			$kf_username = get_cookie('username');
			$where .= " AND `kf_username`='$kf_username'";
		}
		$starttime = '';
		$endtime = '';
		if ($GLOBALS['starttime']) {
			$starttime = strtotime($GLOBALS['starttime']);
			$where .= " AND `addtime`>'$starttime'";
		}
		if ($GLOBALS['endtime']) {
			$endtime = strtotime($GLOBALS['endtime']);
			$where .= " AND `endtime`<'$endtime'";
		}
		if(isset($GLOBALS['exp'])) {
			$pagesize = 1000;
		} else {
			$pagesize = 20;
		}

		$admin_result = $this->db->get_list('admin', array('role' => 4), '*', 0, 20, 0);
		$result = $this->db->get_list('pay', $where, '*', 0, $pagesize, $page, 'id DESC');
		if(isset($GLOBALS['exp'])) {
			$this->export_excel($result);
		}
		$pages = $this->db->pages;
		$total = $this->db->number;
		$pay_config = get_config('pay_config');
		load_class('form');

		include $this->template('listing');
	}

	/**
	 * 后台充值
	 */
	public function add(){
		$config = $this->db->get_one('payment', array('id' => 1));
		if ($config['status'] != 1) MSG('不支持后台充值，开启方式：充值配置中开启后台充值功能');
		if (isset($GLOBALS['submit'])) {
			load_function('common', 'pay');
			$formdata = array();
			$formdata['username'] = remove_xss($GLOBALS['username']);
			$mr = $this->db->get_one('member', array('username' => $formdata['username']));

			if (!$mr) MSG('用户不存在');
			$formdata['uid'] = $mr['uid'];
			$plus_minus = intval($GLOBALS['plus_minus']);

			$money = $formdata['money'] = sprintf("%.2f", $GLOBALS['money']);
			if($plus_minus==1 && $mr['money']<$money) {
				MSG('余额不足');
			}
			$formdata['order_no'] = create_order_no();
			$formdata['note'] = remove_xss($GLOBALS['note']);
			$formdata['plus_minus'] = $plus_minus;
			$formdata['adminuid'] = $_SESSION['uid'];
			$formdata['addtime'] = SYS_TIME;
			$formdata['paytime'] = SYS_TIME;
			$formdata['endtime'] = SYS_TIME;
			$formdata['quantity'] = 1;
			$formdata['status'] = 1;
			$formdata['payment'] = 1;
			$formdata['keytype'] = 2;
			$username = get_cookie('username');
			if ($plus_minus == -1) {
				$plus_minus_type = '充值';
				$formdata['payname'] = $username . '为用户' . $plus_minus_type;
				$linkageid = $this->db->insert('pay', $formdata);
				$this->db->update('member', "`money`=(`money`+$money)", array('uid' => $mr['uid']));
			} else {
				$plus_minus_type = '扣款';
				$formdata['payname'] = $username . '为用户' . $plus_minus_type;
				$linkageid = $this->db->insert('pay', $formdata);
				$this->db->update('member', "`money`=(`money`-$money)", array('uid' => $mr['uid']));
			}
			MSG(L('operation success'),'?m=pay&f=index&v=listing'.$this->su());
		} else {
			$show_formjs = 1;
			$form = load_class('form');
			$options = $this->db->get_list('kind', array('keyid' => 'link'));
			$options = key_value($options, 'kid', 'name');
			include $this->template('add');
		}
	}

	/**
	 * 修改价格
	 */
	public function edit(){

		$id = intval($GLOBALS['id']);
		$r = $this->db->get_one('pay', array('id' => $id));

		if (isset($GLOBALS['submit'])) {
			if ($r['status'] != 6) MSG(L('当前状态无法修改价格！'));
			$formdata = array();
			$type = intval($GLOBALS['type']);
			$money = sprintf("%.2f",$GLOBALS['money']);
			$_money = $r['money'];
			if (($money > $_money) && $type == 1) {
				$_money = $r['money'];
			} else {
				if ($type == 1) {
					$_money = $_money - $money;
				} else {
					$_money = $_money + $money;
				}
			}


			$this->db->update('pay', array('money' => $_money), array('id' => $id));

			MSG(L('operation_success') . '<script>$("#edit", top.window.frames["iframeid"].document).css("background-color", "#EFD04C");top.dialog.get(window).close().remove();</script>');
		} else {
			$show_formjs = 1;

			include $this->template('edit');
		}
	}

	/**
	 * 删除支付记录到回收站
	 */
	public function delete(){
		$id = intval($GLOBALS['id']);
		$this->db->update('pay', array('status' => '-1'), array('id' => $id));
		MSG(L('delete success'), HTTP_REFERER, 1500);
	}

	/**
	 * 设置为退款状态
	 */
	public function refund(){
		$id = intval($GLOBALS['id']);
		$this->db->update('pay', array('status' => '9'), array('id' => $id,'status'=>1));
		
		MSG('退款成功!', HTTP_REFERER, 1500);
	}


	/**
	 * 查看交易详情
	 */
	public function view(){
		$payments = $this->payments;
		$status_arr = $this->status_arr;
		$id = intval($GLOBALS['id']);
		$r = $this->db->get_one('pay', array('id' => $id));
		$mr = $this->db->get_one('member', array('uid' => $r['uid']));
		$pay_config = get_config('pay_config');
		$result = $this->db->get_list('pay_detail', array('id' => $id), '*', 0, 20, 0, 'detailid ASC');
		include $this->template('view');
	}

	/**
	 * 修改交易备注
	 */
	public function edit_note(){
		$id = intval($GLOBALS['id']);
		$note = remove_xss($GLOBALS['note']);
		$this->db->update('pay', array('note' => $note), array('id' => $id));
		MSG(L('operation success'), HTTP_REFERER);
	}

	/**
	 * 确认收款
	 */
	public function confirm_order(){
		$id = intval($GLOBALS['id']);
		$this->db->update('pay', array('adminuid' => $_SESSION['uid'],'status'=>1,'paytime'=>SYS_TIME,'endtime'=>SYS_TIME,'payment'=>9), array('id' => $id));
		MSG(L('operation success'), HTTP_REFERER);
	}

	/**
	 * zf
	 */
	public function relay(){
		$id = intval($GLOBALS['id']);
		$r = $this->db->get_one('pay', array('id' => $id));
		$r2 = $this->db->get_one('pay_detail', array('id' => $id));
		$r = array_merge($r, $r2);
		$keyValue = '';
		$keyType = '';
		if (isset($GLOBALS['keyType'])) {
			$keyType = $GLOBALS['keyType'];
			$keyValue = $GLOBALS['keyValue'];
			if ($keyValue) {
				$where = "modelid=11 AND `$keyType` LIKE '%$keyValue%'";
				$result = $this->db->get_list('member', $where, '*', 0, 20, 0, 'uid DESC');
			}
		} elseif (isset($GLOBALS['submit'])) {
			load_function('common', 'pay');
			$formdata = array();
			$formdata['order_no'] = create_order_no();
			$formdata['to_uid'] = intval($GLOBALS['to_uid']);
			$formdata['username'] = $r['linkman'];
			$formdata['mobile'] = $r['telephone'];
			$formdata['pinpai'] = $r['data1'];
			$formdata['chexing'] = $r['data3'];
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
			// $this->db->update('demand', array('flag'=>1),array('did' => $did));
			$this->db->update('pay', array('jxs_username' => $formdata2['to_username']), array('id' => $id));
			$forward = strip_tags($GLOBALS['forward']);
			MSG('发送成功', $forward);
		} else {
			$uid = $_SESSION['uid'];
			$where = "op_uid='$uid'";
			$data = $this->db->get_one('demand_history', $where, '*', 0, 'hid DESC');
			$forward = strip_tags($GLOBALS['forward']);

		}
		include $this->template('pay_relay');
	}

	/**
	 * 分配订单给客服
	 */
	public function kf(){
		if (empty($GLOBALS['ids'])) MSG('没有选择任何订单');
		$kf_username = strip_tags($GLOBALS['kf_username']);
		foreach ($GLOBALS['ids'] as $id) {
			$this->db->update('pay', array('kf_username' => $kf_username), array('id' => $id));
		}
		MSG('订单分配成功', HTTP_REFERER);
	}

	private function export_excel($result){
		$new_field = array(
			'addtime' => array('name' => '创建时间'),
			'payname' => array('name' => '支付名称'),
			'order_no' => array('name' => '订单号'),
			'money' => array('name' => '价格'),
			'kf_username' => array('name' => '所属客服'),
			'jxs_username' => array('name' => '所属经销商'),
			'status' => array('name' => '状态'),
			'username' => array('name' => '提交人'),
			'email' => array('name' => 'email'),
			'linkman' => array('name' => '联系人'),
			'telephone' => array('name' => '电话'),

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
				if($field=='order_no' || $field=='telephone') $pre = ' ';
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
		header('Content-Disposition: attachment;filename="订单导出.xls"');
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