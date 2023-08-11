<?php
/**
 * 编辑管理页面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body class="body pxgridsbody">
	<section class="wrapper">
		<section class="panel">
			<header><?php echo $this->menu($GLOBALS['_menuid']); ?></header>
			<header class="panel-heading">
				<form action="" class="form-inline" method="get" target="_self">
					<input type="hidden" name="m" value="<?php echo M; ?>" />
					<input type="hidden" name="f" value="<?php echo F; ?>" />
					<input type="hidden" name="v" value="<?php echo V; ?>" />
					<input type="hidden" name="_su" value="<?php echo _SU; ?>" />
					<input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid']; ?>" />
					<input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid']; ?>" />
					<input type="hidden" name="dosearch" value="1" />
					统计开始时间：<?php echo WUZHI_form::calendar('start', $start, 0); ?> 截止时间： <?php echo WUZHI_form::calendar('end', $end, 0); ?>

					<button type="submit" class="btn btn-info btn-sm"> 查看统计 </button>
					<a href="?m=content&f=editor&v=all_stat&dosearch=1&start=<?php echo date('Y-m-d', strtotime('this week')); ?>&end=<?php echo $time2; ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">本周</a>
					<a href="?m=content&f=editor&v=all_stat&dosearch=1&start=<?php echo date('Y-m-1'); ?>&end=<?php echo $time2; ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">本月</a>
					<a href="?m=content&f=editor&v=all_stat&dosearch=1&start=<?php echo date('Y-m-01', strtotime('-1 month')); ?>&end=<?php echo date('Y-m-t', strtotime('-1 month')); ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">上一月</a>
					<a href="?m=content&f=editor&v=all_stat&dosearch=1&start=<?php echo date('Y-01-01'); ?>&end=<?php echo $time2; ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">本年</a>
					<a href="?m=content&f=editor&v=all_stat<?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">全部</a>
				</form>
			</header>
		</section>
		<!-- page start-->
		<div class="row">
			<div class="col-lg-12">


				<section class="panel">


					<div class="panel-body" id="panel-bodys">
						<table class="table table-striped table-advance table-hover">
							<thead>
								<tr>
									<th class="hidden-phone tablehead">ID</th>
									<th class="tablehead">管理员账号</th>
									<th class="tablehead">真实姓名</th>
									<th class="tablehead" width="300">角色</th>
									<th class="tablehead">添加数</th>
									<th class="tablehead">编辑数</th>
									<th class="tablehead">审批数</th>
									<th class="tablehead">删除数</th>
									<th class="tablehead">在线时长</th>
									<th class="tablehead">统计详情</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$nowtime = SYS_TIME;
								$eday = date('Ymd');
								if ($start) {
									$sday = date('Ymd', strtotime($start));
									$sday = " AND `dayid`>='$sday'";
								} else {
									$sday = '';
								}

								foreach ($result as $r) {
									$uid = $r['uid'];
									$mr = $this->db->get_one('member', array('uid' => $uid), 'username');
									$total1 = $this->db->count_result('editor_log', "`dayid`<='$eday' $sday AND `uid`='$uid' AND `action`='add'", 'COUNT(*) AS num', 0, '', '');
									$total2 = $this->db->count_result('editor_log', "`dayid`<='$eday' $sday AND `uid`='$uid' AND `action`='edit'", 'COUNT(*) AS num', 0, '', '');
									$total3 = $this->db->count_result('editor_log', "`dayid`<='$eday' $sday AND `uid`='$uid' AND `action`='check'", 'COUNT(*) AS num', 0, '', '');
									$total4 = $this->db->count_result('editor_log', "`dayid`<='$eday' $sday AND `uid`='$uid' AND `action`='delete'", 'COUNT(*) AS num', 0, '', '');
									$total5 = $this->db->count_result('admin_onlinetime', "`dayid`<='$eday' $sday AND `uid`='$uid'", 'SUM(onlinetimes) AS num', 0, '', '');

								?>
									<tr>

										<td><?php echo $r['uid']; ?></td>
										<td><?php echo $mr['username']; ?></td>
										<td><?php echo $r['truename']; ?></td>
										<td><?php
											$role = trim($r['role'], ',');
											$role = explode(',', $role);
											$tmp = array();
											foreach ($role as $_r) {
												$tmp[] = $roles[$_r]['name'];
											}
											echo implode(' , ', $tmp);
											?></td>
										<td><?php echo $total1; ?></td>
										<td><?php echo $total2; ?></td>
										<td><?php echo $total3; ?></td>
										<td><?php echo $total4; ?></td>
										<td><?php echo $total5; ?>分钟</td>
										<td><a href="?m=content&f=editor&v=editor_stat&uid=<?php echo $r['uid']; ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">查看</a></td>

									</tr>
								<?php
								}
								?>



							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>

		<!-- page end-->
	</section>
	<?php include $this->template('footer', 'core'); ?>