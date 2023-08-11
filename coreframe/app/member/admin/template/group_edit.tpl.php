<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="bg-white">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel">
	<div class="panel-body">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=group&v=edit&groupid=<?php echo $groupid.$this->su();?>">

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上级</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
				<?php echo $string;?>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">组名</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input type="text" name="info[name]" class="form-control" value="<?php echo $group['name'];?>" datatype="/^[a-z\d\u4E00-\u9FA5\uf900-\ufa2d][a-z\d_\u4E00-\u9FA5\uf900-\ufa2d]*[a-z\d\u4E00-\u9FA5\uf900-\ufa2d]$/i" errormsg="组名为2-15位数字、字母、汉字和_组成，且不能以_开头或结尾" sucmsg="OK" ajaxurl="index.php?m=member&f=group&v=check_name&groupid=<?php echo $groupid.$this->su();?>"/>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">排序</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input type="text" name="info[sort]" class="form-control" value="<?php echo $group['sort']?>" datatype="n" errormsg="排序为0-255" sucmsg="OK" />
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">最小积分</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<input type="text" name="info[points]" class="form-control" value="<?php echo $group['points']?>" datatype="n" errormsg="请输入最小积分" sucmsg="OK" />
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">自主升级</label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="info[upgrade]" value="1" <?php echo $group['upgrade'] ? 'checked' : ''?> />
					</div>
				</div>
			</div>

			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">升级价格</label>
				<div class="col-lg-3 col-sm-8 col-xs-8 row">
					<div class="input-group w-auto">
						<span class="input-group-text" id="basic-addon1">包年：</span>
						<input type="text" name="info[money_y]" value="<?php echo $group['money_y']?>" class="date form-control"  size="4" /> 
					</div>
					<div class="input-group w-auto">
						<span class="input-group-text" id="basic-addon1">包月：</span>
						<input type="text" name="info[money_m]" value="<?php echo $group['money_m']?>" class="date form-control"  size="4" /> 
					</div>
					<div class="input-group w-auto">
						<span class="input-group-text" id="basic-addon1">包日：</span>
						<input type="text" name="info[money_d]" value="<?php echo $group['money_d']?>" class="date form-control"  size="4" /> 
					</div>
				</div>
			</div>

			<div class="pt-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
				<div class="col-lg-3 col-sm-6 col-xs-6">
				<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
				</div>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">
	$(function(){
		$(".form-horizontal").Validform({
			tiptype:3,
            callback:function(form){
            	$("#submit").click();
        	}
		});
	});
</script>
<?php include $this->template('footer','core');?>
