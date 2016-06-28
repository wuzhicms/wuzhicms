<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<style>
	.wztool-1{display: inline-block;border: 5px #fff solid;}
	.wztool-2{border: 5px #717790 solid;}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
	#sortable li span { position: absolute; margin-left: -1.3em; }
	.ui-state-highlight,
	.ui-widget-content .ui-state-highlight,
	.ui-widget-header .ui-state-highlight {
		border: 1px solid #dad55e;
		background: #9de3cf;
		color: #777620;
		cursor: move;
	}

</style>
<script>
	$(function() {
		<?php
		if($GLOBALS['sorttype']==0) {?>
		$("#sortable").sortable({
			cursor: "move",
			placeholder: "ui-state-highlight"
		});
		$("#sortable").disableSelection();

		<?php
		}
		?>
		$( "#sortable_m" ).sortable({
			cursor: "move",
			placeholder: "ui-state-highlight"
		});
		$( "#sortable_m" ).disableSelection();

	});
</script>

<section class="wrapper">

	<!-- page start-->
	<div class="row">
		<div class="col-lg-12">

			<form name="myform" action="?m=content&f=dymlist&v=save<?php echo $this->su();?>" method="post">
				<section class="panel">
					<header class="panel-heading"><span>第二步：设置会员属性</span></header>
					<div class="panel-body" id="panel-bodys">

						<table class="table  table-advance table-hover">
							<thead>
							<tr>
								<th class="tablehead" width="120">所属模型</th>
								<th class="tablehead" width="80">选择</th>
								<th class="tablehead" width="80">显名</th>
								<th class="tablehead" width="210">字段名</th>
								<th class="tablehead" width="210">自定义字段</th>
								<th class="hidden-phone tablehead">换行</th>
							</tr>
							</thead>
							<tbody id="sortable_m">
							<?php

							if($data_r) {
								foreach ($field_result2 AS $r) {
									if ($r['name']) {
										$modelid = $r['modelid'];
										$modelname = $models[$modelid]['name'];
										?>
										<tr>
											<td><?php echo '<font color="'.$r['field_color'].'">'.$modelname."</font>"; ?></td>
											<td><input name="field[<?php echo $r['field']; ?>]"
													type="checkbox"
													value="1" <?php if (in_array($r['field'], $fields)) echo 'checked'; ?>>
											</td>

											<td><input name="showname[<?php echo $r['field']; ?>]"
													type="checkbox"
													value="1" <?php if (in_array($r['field'], $showname)) echo 'checked'; ?>>
											</td>
											<td><?php echo $r['name']; ?></td>
											<td><input name="diy[<?php echo $r['field']; ?>]"
													type="text"
													value="<?php echo $diy[$r['field']]; ?>"></td>
											<td><input name="field_br[<?php echo $r['field']; ?>]"
													type="checkbox"
													value="1" <?php if (in_array($r['field'], $field_br)) echo 'checked'; ?>>
											</td>

										</tr>
										<?php
									}
								}
							} else {
								$colors = array('#797979','#A95555','#3B99FC','#3F7707');
								$j = 0;
								foreach($modelids as $modelid) {
									$modelname = $models[$modelid]['name'];
									foreach ($field_result[$modelid] AS $r) {
										if ($r['name']) {
											?>
											<tr>
												<td><?php echo '<font color="'.$colors[$j].'">'.$modelname."</font>"; ?></td>
												<td><input name="field[<?php echo $r['field']; ?>]"
														type="checkbox"
														value="1" >
												</td>

												<td><input name="showname[<?php echo $r['field']; ?>]"
														type="checkbox"
														value="1" <?php if (in_array($r['field'], $showname)) echo 'checked'; ?>>
												</td>
												<td><?php echo $r['name']; ?></td>
												<td><input name="diy[<?php echo $r['field']; ?>]"
														type="text"
														value="<?php echo $diy[$r['field']]; ?>"></td>
												<td><input name="field_br[<?php echo $r['field']; ?>]"
														type="checkbox"
														value="1" <?php if (in_array($r['field'], $field_br)) echo 'checked'; ?>>
												</td>

											</tr>
											<?php
										}
									}
									$j++;
								}
							}

							?>



							</tbody>
						</table>

						<hr>

						<table class="table table-advance table-hover">
							<thead>
							<tr >
								<th class="tablehead" colspan="6" style="background-color: rgba(8, 5, 1, 0.26);color: #FFF;">人员排序配置</th>
							</tr>
							<tr>
								<th class="tablehead">用户ID</th>
								<th class="tablehead">禁止显示</th>
								<th class="hidden-phone tablehead">用户名(英文 [中文])</th>
								<th class="tablehead">登录帐号</th>
								<th class="tablehead">邮箱</th>
							</tr>
							</thead>
							<tbody id="sortable">

							<?php
							foreach($member_result AS $r) {
								if(!$r['uid']) continue;
								?>
								<tr >
									<td><input type="hidden" name="uids[]" value="<?php echo $r['uid'];?>"><?php echo $r['uid'];?></td>
									<td><input name="ban_show[<?php echo $r['uid']; ?>]"
											type="checkbox"
											value="1" <?php if (in_array($r['uid'], $ban_show)) echo 'checked'; ?>>
									</td>
									<td><?php echo $r['FirstName_en'].' '.$r['LastName_en'];?> [<font color="#5f9ea0"><?php echo $r['LastName'].$r['FirstName'];?></font>]</td>
									<td><?php echo $r['username'];?></td>
									<td><?php echo $r['email'];?></td>

								</tr>
								<?php
							}
							?>



							</tbody>
						</table>
						<hr>

						<table class="table table-striped table-advance table-hover">
							<thead>
							<tr >
								<th class="tablehead" colspan="4" style="background-color: rgba(8, 5, 1, 0.26);color: #FFF;">排版</th>
							</tr>
							</thead>
							<tbody>

								<tr >
									<td><div class="wztool-1 <?php if($tpl==1) echo 'wztool-2';?>" onclick="set_tpl(1,this);"><img src="<?php echo R;?>images/icon/11.png"></div> </td>
									<td><div class="wztool-1 <?php if($tpl==2) echo 'wztool-2';?>" onclick="set_tpl(2,this);"><img src="<?php echo R;?>images/icon/22.png"></div> </td>
									<td><div class="wztool-1 <?php if($tpl==3) echo 'wztool-2';?>" onclick="set_tpl(3,this);"><img src="<?php echo R;?>images/icon/33.png"></div> </td>
									<td><div class="wztool-1 <?php if($tpl==4) echo 'wztool-2';?>" onclick="set_tpl(4,this);"><img src="<?php echo R;?>images/icon/44.png"></div> </td>

								</tr>

							</tbody>
						</table>
						<input type="hidden" id="tpl" name="tpl" value="<?php echo $tpl;?>">
						<input type="hidden" name="id" value="<?php echo $id;?>">
						<input type="hidden" name="sorttype" value="<?php echo $GLOBALS['sorttype'];?>">
						<input type="hidden" name="groupids" value="<?php echo $groupid;?>">
						<input type="hidden" name="modelids" value="<?php echo implode(',',$modelids);?>">
					</div>
				</section>
				<div class="row">
					<div class="col-lg-12">
						<div class="center">
							<input type="submit" class="btn btn-info" name="submit" value="更新" style="width: 50%;">
						</div>

					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script>
	function set_tpl(tpl,obj) {
		$("#tpl").val(tpl);
		$('.wztool-1').removeClass('wztool-2');
		$(obj).addClass('wztool-2');
	}
</script>
</body>
</html>