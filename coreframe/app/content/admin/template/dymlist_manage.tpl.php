<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style type="text/css">
	.table_form td{
		padding: 10px;
	}
	.trbg{background-color: #b2d8e4;}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		line-height: 0.8;
	}
	.opheight>option{
		height:26px;}
</style>
<section class="wrapper">
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<?php echo $this->menu($GLOBALS['_menuid']);?>
				<header class="panel-heading"><span>第一步：设置会员组／模型</span></header>
				<div class="panel-body">
					<form class="form-horizontal tasi-form" method="post" action="">

						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">会员组</label>
							<div class="col-sm-6 col-xs-6" >
								<table class="table table-advance ">
									<thead>
									<tr>
										<th class="tablehead">选择</th>
										<th class="tablehead">GID</th>
										<th class="tablehead">组名称</th>
									</tr>
									</thead>
									<tbody>
									<?php
									echo $tree_data;
									?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">模型</label>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
								<select name="modelids[]" class="form-control opheight" style="height: 400px;" multiple="multiple">
									<?php if($this->model)foreach($this->model as $k=>$t){?>
										<option value="<?php echo $t['modelid']?>" <?php echo in_array($t['modelid'],$modelids) ? 'selected' : '';?>><?php echo $t['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label">排序方式</label>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
							<label><input type="radio" name="sorttype" value="1" <?php if($sorttype) echo 'checked';?>> 自动排序</label>
							<label style="padding-left: 10px;"><input type="radio" name="sorttype" value="0" <?php if(!$sorttype) echo 'checked';?>> 手动排序</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 col-xs-4 control-label"></label>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
								<input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
								<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
							</div>
						</div>

					</form>
				</div>
			</section>
		</div>
	</div>
	<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
	$(function(){

	})

</script>

