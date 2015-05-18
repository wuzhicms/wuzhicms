<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="wrapper">
<div class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
	<div class="panel-body">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=add<?php echo $this->su();?>">
			<div class="form-group">
				<label class="col-sm-2 control-label">用户名</label>
				<div class="col-sm-4 input-group"><input type="text" name="info[username]" class="form-control" placeholder="请输入用户名" datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{3,20}$/i" errormsg="用户名为3-20位数字、字母、汉字和-组成" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_user"/></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">密码</label>
				<div class="col-sm-4 input-group"><input type="password" name="info[password]" class="form-control" placeholder="请输入密码" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">确认密码</label>
				<div class="col-sm-4 input-group"><input type="password" name="info[pwdconfirm]" class="form-control" placeholder="请重复输入密码" recheck="info[password]" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">邮箱</label>
				<div class="col-sm-4 input-group"><input type="text" name="info[email]" class="form-control" value="" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_email" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">手机</label>
				<div class="col-sm-4 input-group"><input type="text" name="info[mobile]" class="form-control" value="" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_mobile" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">会员组</label>
				<div class="col-sm-4 input-group">
				<select name="info[groupid]" class="form-control">
					<?php if(is_array($group))foreach($group as $v){?>
					<option value="<?php echo $v['groupid']?>"><?php echo $v['name']?></option>
					<?php }?>
				</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">用户模型</label>
				<div class="col-sm-4 input-group">
				<select name="info[modelid]" class="form-control">
				<?php if($this->model)foreach($this->model as $k=>$t){?>
					<option value="<?php echo $t['modelid']?>" ><?php echo $t['name'];?></option>
                <?php } ?>
                </select>
            	</div>
        		</div>
            <div class="form-group">
                <label class="col-sm-2 control-label">VIP</label>
                <div class="col-sm-4 input-group"><?php echo WUZHI_form::calendar('info[viptime]', '', 1);?></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">锁定</label>
                <div class="col-sm-4 input-group"><?php echo WUZHI_form::calendar('info[locktime]', '', 1);?></div>
            </div>
        		<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4 input-group"><input class="btn btn-info" type="submit" id="submit" name="submit" value="提交"></div>
			</div>
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
	});
</script>