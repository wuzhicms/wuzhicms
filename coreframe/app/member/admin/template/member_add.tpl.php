<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
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
<div class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
	<div class="panel-body" id="panel-bodys">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=add<?php echo $this->su();?>">
			<table class="table table-striped table-advance table-hover">
			<thead>
				<tr>
					<th class="tablehead"></th>
					<th class="tablehead"></th>
				</tr>
			</thead>
				<tbody>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">用户名</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="info[username]" class="form-control" placeholder="请输入用户名" datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{3,20}$/i" errormsg="用户名为3-20位数字、字母、汉字和-组成" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_user"/></div>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">密码</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="password" name="info[password]" class="form-control" placeholder="请输入密码" /></div>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">确认密码</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="password" name="info[pwdconfirm]" class="form-control" placeholder="请重复输入密码" recheck="info[password]" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" /></div>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">邮箱</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="info[email]" class="form-control" value="" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_email" /></div>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">手机</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="info[mobile]" class="form-control" value="" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_mobile" /></div>
						</td>
					</tr>
				
					<tr>
						<td class="text-right"><label class="control-label">头像</label></td>
						<td><div class="col-sm-8 col-xs-8"><div class="input-group"><?php echo $form->attachment('','1','avatar',$avatar);?></div></div></td>
					</tr>
					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">激活状态</label></td>
						<td>
							<div class="col-lg-5 col-sm-5 col-xs-5 input-group"><label><input type="radio" name="islock" value="0" onclick="$('#set_name_id').css('display','none');"> 已激活 </label><label style="padding-left: 20px;"><input type="radio" name="islock" value="1" checked onclick="$('#set_name_id').css('display','');"> 未激活(发送邮件进行激活后,方可登录)</label></div>
						</td>
					</tr>
					<tr id="set_name_id">
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label">更改用户名</label></td>
						<td>
							<div class="col-lg-3 col-sm-4 col-xs-4 input-group"><label><input type="radio" name="sys_name" value="1" > 允许 </label><label style="padding-left: 20px;"><input type="radio" name="sys_name" value="0" checked> 不允许</label></div>
						</td>
					</tr>
					<tr>
						<td class="text-right"><label class="control-label">扩展会员组</label></td>
						<td><div class="col-sm-6 col-xs-6" style="height: 200px;overflow-y: scroll;">
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
							<div class="col-sm-2 col-xs-2 " style="text-align:right;padding-top: 200px;font-size: 14px;">用户模型</div>
							<div class="col-sm-3 col-xs-3">
								<select name="modelids[]" class="form-control opheight" style="height: 200px;" multiple="multiple">
									<?php if($this->model)foreach($this->model as $k=>$t){?>
										<option value="<?php echo $t['modelid']?>"><?php echo $t['name'];?></option>
									<?php } ?>
								</select>
							</div>
						</td>
					</tr>

					<tr>
						<td class="col-sm-2 col-xs-4 text-right"><label class="control-label"></label></td>
						<td>
							<div class="col-lg-4 col-lg-3 col-sm-4 col-xs-4 input-group panel-footer">
                    		<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                			</div>
						</td>
					</tr>
				</tbody>
			</table>


			</div>
			
		</form>
	</div>
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
		$("#body").niceScroll({styler:"fb",horizrailenabled:false,cursorcolor:"#c4c8d2",cursorwidth: '6', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: ''});

	});
	function set_gp(gid,pid) {
		//$('#gid'+pid).addClass('trbg');
		var istrue = $('#box'+gid).is(':checked');
		if(istrue) {
			$('#gid'+gid).addClass('trbg');
		} else {
			$('#gid'+gid).removeClass('trbg');
		}
		set_parents(gid,istrue);
	}
	function set_parents(gid,istrue) {
		var hgid = $("#hgid"+gid).val();
		if(hgid!=0) {
			if(istrue) {
				$('#gid'+hgid).addClass('trbg');
				$('#box'+hgid).prop('checked','checked');
			} else {
				$('#gid'+hgid).removeClass('trbg');
				$('#box'+hgid).prop('checked','');
			}

			set_parents(hgid,istrue);
		} else {
			if(istrue) {
				$('#gid'+gid).addClass('trbg');
				$('#box'+gid).prop('checked','checked');
			} else {
				$('#gid'+gid).removeClass('trbg');
				$('#box'+gid).prop('checked','');
			}
		}

	}
</script>