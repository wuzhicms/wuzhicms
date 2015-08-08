<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body pxgridsbody" style="background-color: #fff;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel" style="box-shadow: none;">
	<div class="panel-body" id="panel-bodys">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=group&v=edit&groupid=<?php echo $groupid.$this->su();?>">
		<table class="table table-striped table-advance table-hover">
			<tbody>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">组名</label></td>
				<td>
					<div class="col-lg-4 col-sm-6 col-xs-6 input-group"><input type="text" name="info[name]" class="form-control" value="<?php echo $group['name'];?>" datatype="/^[a-z\d\u4E00-\u9FA5\uf900-\ufa2d][a-z\d_\u4E00-\u9FA5\uf900-\ufa2d]*[a-z\d\u4E00-\u9FA5\uf900-\ufa2d]$/i" errormsg="组名为2-15位数字、字母、汉字和_组成，且不能以_开头或结尾" sucmsg="OK" ajaxurl="index.php?m=member&f=group&v=check_name&groupid=<?php echo $groupid.$this->su();?>"/></div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">排序</label></td>
				<td>
					<div class="col-lg-4 col-sm-6 col-xs-6 input-group"><input type="text" name="info[sort]" class="form-control" value="<?php echo $group['sort']?>" datatype="n" errormsg="排序为0-255" sucmsg="OK" /></div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">最小积分</label></td>
				<td>
					<div class="col-lg-4 col-sm-6 col-xs-6 input-group"><input type="text" name="info[points]" class="form-control" value="<?php echo $group['points']?>" datatype="n" errormsg="请输入最小积分" sucmsg="OK" /></div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">自主升级</label></td>
				<td>
					<div class="col-lg-4 col-sm-6 col-xs-6 input-group"><input type="checkbox" name="info[upgrade]"  value="1" <?php echo $group['upgrade'] ? 'checked' : ''?> /></div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">升级价格</label></td>
				<td>
					<div class="col-lg-4 col-sm-6 col-xs-6 input-group">包年：<input type="text" name="info[money_y]" value="<?php echo $group['money_y']?>" class="date"  size="4" /> 包月：<input type="text" name="info[money_m]" value="<?php echo $group['money_m']?>" class="date"  size="4" /> 包日：<input type="text" name="info[money_d]" value="<?php echo $group['money_d']?>" class="date" size="4"/></div>
				</td>
			</tr>
			<tr>
				<td class="col-sm-2 col-xs-4 text-right"><label class="control-label"></label></td>
				<td>
					<div class="col-lg-4 col-lg-4 col-sm-6 col-xs-6 input-group panel-footer">
                    	<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                	</div>
				</td>
			</tr>
			</tbody>
		</table>
		</form>
	</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
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