<?php
/**
 * 编辑工作量统计页面
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body>

	<section class="wrapper">
		<!-- page start-->
		<div class="row">
			<div class="col-lg-12">


				<section class="panel">
					<?php echo $this->menu($GLOBALS['_menuid']); ?>

					<form action="?m=core&f=kind&v=sort<?php echo $this->su(); ?>" name="myform" method="post">

						<div class="panel-body" id="panel-bodys">
							<table class="table table-striped table-advance table-hover">
								<thead>
									<tr>
										<th class="hidden-phone tablehead">日期</th>
										<th class="tablehead">添加数</th>
										<th class="tablehead">编辑数</th>
										<th class="tablehead">审批数</th>
										<th class="tablehead">删除数</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($result as $r) {
										$dayid = $r['dayid'];
										$total1 = $this->db->count_result('editor_log', "`dayid`='$dayid' AND `uid`='$uid' AND `action`='add'", 'COUNT(*) AS num', 0, '', '');
										$total2 = $this->db->count_result('editor_log', "`dayid`='$dayid' AND `uid`='$uid' AND `action`='edit'", 'COUNT(*) AS num', 0, '', '');
										$total3 = $this->db->count_result('editor_log', "`dayid`='$dayid' AND `uid`='$uid' AND `action`='check'", 'COUNT(*) AS num', 0, '', '');
										$total4 = $this->db->count_result('editor_log', "`dayid`='$dayid' AND `uid`='$uid' AND `action`='delete'", 'COUNT(*) AS num', 0, '', '');
									?>
										<tr>
											<td><?php echo $r['dayid']; ?></td>
											<td><?php echo $total1; ?></td>
											<td><?php echo $total2; ?></td>
											<td><?php echo $total3; ?></td>
											<td><?php echo $total4; ?></td>
										</tr>
									<?php
									}
									?>



								</tbody>
							</table>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">

										<div class="pull-right">
											<ul class="pagination pagination-sm">
												<?php echo $pages; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
				</section>
				</form>

			</div>

		</div>

		<!-- page end-->
	</section>
	<script type="text/javascript">
		$(function() {
			$(".form-horizontal").Validform({
				tiptype: 3
			});
		})

		function edit(kid) {
			top.openiframe('index.php?m=core&f=kind&v=edit&kid=' + kid + '<?php echo $this->su(); ?>', 'edit', '编辑分类', 500, 300);
		}
	</script>
	<?php include $this->template('footer', 'core'); ?>