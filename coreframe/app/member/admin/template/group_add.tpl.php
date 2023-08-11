<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<body class="body pxgridsbody">
<section class="wrapper">
	<section class="panel">
	<?php echo isset($GLOBALS['_menuid']) ? $this->menu($GLOBALS['_menuid']) : '';?>
	<div class="panel-body">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=group&v=add<?php echo $this->su();?>">
			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上级</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
				<?php echo $string;?>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">组名</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input type="text" name="info[name]" class="form-control" placeholder="请输入组名" datatype="/^[a-z\d\u4E00-\u9FA5\uf900-\ufa2d][a-z\d_\u4E00-\u9FA5\uf900-\ufa2d]*[a-z\d\u4E00-\u9FA5\uf900-\ufa2d]$/i" errormsg="组名为2-15位数字、字母、汉字和_组成，且不能以_开头或结尾" sucmsg="OK" ajaxurl="index.php?m=member&f=group&v=check_name<?php echo $this->su();?>"/>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">排序</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input type="text" name="info[sort]" class="form-control" placeholder="排序 0-255" datatype="n" errormsg="排序为0-255" sucmsg="OK" value="100"/>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
				</div>
			</div>
		</form>
	</div>
	</section>
</section>
<script type="text/javascript">
	$(function(){
		$(".form-horizontal").Validform({
			tiptype:3
		});
	});
</script>
<?php include $this->template('footer','core');?>