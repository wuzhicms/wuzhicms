<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
	<!-- page start-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<?php echo $this->menu($GLOBALS['_menuid']);?>
				<header class="panel-heading">
                    <form class="d-flex align-items-center" role="form" method="post">
						<div class="col-auto">
							<?php
							echo $form->tree_select($categorys, $cid, 'name="cid" class="form-select"', '≡ 无上级栏目 ≡');
							?>
						</div>
                        <div class="align-items-center ms-3 row">
                            <label class="col-auto col-form-label">时间段： </label>
                            <div class="col-auto input-gorup row">
                                <div class="col-sm-5 p-0">
                                    <?php echo WUZHI_form::calendar('regTimeStart', $starttime); ?>
                                </div>
                                <div class="col-sm-1 d-inline-block lh-lg pe-1 ps-2">-</div>
                                <div class="col-sm-5 p-0">
                                    <?php echo WUZHI_form::calendar('regTimeEnd', $endtime); ?>
                                </div>
                            </div>
                        </div>
						<button type="submit" name="submit2" class="btn btn-info btn-sm me-3 px-4">搜索</button>
						<button type="submit" name="submit" class="btn btn-primary btn-sm">切换成图形显示</button>
					</form>
				</header>
				<div class="panel-body" id="panel-bodys">
					<table class="table table-striped table-advance table-hover">
						<thead>
						<tr>
							<th class="hidden-phone tablehead">日期</th>
							<th class="tablehead">所属分类</th>
							<th class="tablehead">稿子数量</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach($result AS $r) {

							?>
							<tr>

								<td><?php echo $r['dayid'];?></td>
								<td><?php echo $categorys[$r['cid']]['name'];?></td>
								<td><?php echo $r['num'];?></td>

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
<?php include $this->template('footer','core');?>

