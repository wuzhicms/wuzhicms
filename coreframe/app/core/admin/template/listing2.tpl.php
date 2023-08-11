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
					<form class="form-inline" role="form" method="post">
						<div class="input-group">
							<?php

							echo $form->tree_select($categorys, $cid, 'name="cid" class="form-control"', '≡ 无上级栏目 ≡');

							?>
						</div>




						　　时间段： <link rel="stylesheet" type="text/css" href="/res/libs/calendar/css/jscal2.css">
						<link rel="stylesheet" type="text/css" href="/res/libs/calendar/css/border-radius.css">
						<script type="text/javascript" src="/res/libs/calendar/jscal2.js"></script>
						<script type="text/javascript" src="/res/libs/calendar/lang/cn.js"></script><input type="text" name="regTimeStart" id="regTimeStart" value="<?php echo $starttime;?>" class="date">&nbsp;<script type="text/javascript">
                            Calendar.setup({
                                weekNumbers: false,
                                inputField : "regTimeStart",
                                trigger    : "regTimeStart",
                                dateFormat: "%Y-%m-%d",
                                showTime: false,
                                minuteStep: 1,
                                onSelect   : function() {this.hide();}
                            });
						</script>- <input type="text" name="regTimeEnd" id="regTimeEnd" value="<?php echo $endtime;?>" class="date">&nbsp;<script type="text/javascript">
                            Calendar.setup({
                                weekNumbers: false,
                                inputField : "regTimeEnd",
                                trigger    : "regTimeEnd",
                                dateFormat: "%Y-%m-%d",
                                showTime: false,
                                minuteStep: 1,
                                onSelect   : function() {this.hide();}
                            });
						</script>				　
						<button type="submit" name="submit2" class="btn btn-info btn-sm">搜索</button>
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
