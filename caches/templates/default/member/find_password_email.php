<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="http://www.h1jk.cn/res/h1jk/css/login_style.css">
<div class="container login">
	<div class="verticalcenter">
		<div class="row">
        <div class="span5 rightline">
				<div class="connectwebsite">
					<h3>忘记密码了？</h3>
					<p>如果你忘记合一健康账号登录密码，请填写你的登录邮箱，根据提示即可完成密码重设。</p>
				</div>
			</div>
			<div class="span7">
            <h4><span class="glyphicon glyphicon-envelope color_heyilan" aria-hidden="true"></span> 重置密码</h4>
				<?php if(isset($GLOBALS['key'])) { ?>
				<form action="" method="post" name="findPassword" class="form-horizontal">
					<div class="form-group">
                        <label class="control-label">新密码</label>
                        <div class="col-sm-8">
							<input type="password" name="password" class="form-control" placeholder="请输入密码" datatype="*" errormsg="请输入密码" sucmsg="OK">
                            <span class="Validform_wrong">请输入密码</span>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="control-label">确认密码</label>
						<div class="col-sm-8">
							<input type="password" name="pwdconfirm" class="form-control" placeholder="请确认密码" datatype="*" recheck="password" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" >
							<span class="Validform_wrong">请再次输入密码</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label">验证码</label>
						<div class="col-sm-8">
							<input type="text" name="checkcode" class="form-control" id="Verificationcode" placeholder="请输入验证码" datatype="*4-4"	errormsg="请输入验证码" sucmsg="输入正确" onfocus="if($('#code_img').attr('src') == '<?php echo R;?>images/logincode.gif')$('#code_img').attr('src', '<?php echo WEBURL;?>index.php?m=core&f=identifying_code&w=112&h=40&rd='+Math.random());" />
							<img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新"	onclick="$(this).attr('src', '<?php echo WEBURL;?>index.php?m=core&f=identifying_code&w=112&h=40&rd='+Math.random());">
							<span class="Validform_wrong">请输入验证码</span>
						</div>
					</div>					
					<div class="form-group">
						<label class="control-label"></label>
						<input type="submit" name="submit" class="btn btn-login" value="立即找回" />
					</div>
				</form>
				<?php } else { ?>
				<form action="" method="post" name="findPassword" class="form-horizontal">
					<div class="form-group">
                        <label class="control-label">Email</label>
                        <div class="col-sm-8">
              				<input type="text" name="email" class="form-control" placeholder="请输入Email" datatype="e" errormsg="请输入Email" sucmsg="OK">
                            <span class="Validform_wrong">请输入Email</span>
                        </div>
                    </div>
                    <div class="form-group">
						<label class="control-label">验证码</label>
						<div class="col-sm-8">
							<input type="text" name="checkcode" class="form-control" id="Verificationcode" placeholder="请输入验证码" datatype="*4-4"	errormsg="请输入验证码" sucmsg="输入正确" onfocus="if($('#code_img').attr('src') == '<?php echo R;?>images/logincode.gif')$('#code_img').attr('src', '<?php echo WEBURL;?>index.php?m=core&f=identifying_code&w=112&h=40&rd='+Math.random());" />
							<img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新"	onclick="$(this).attr('src', '<?php echo WEBURL;?>index.php?m=core&f=identifying_code&w=112&h=40&rd='+Math.random());">
							<span class="Validform_wrong">请输入验证码</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label"></label>
						<input type="submit" name="submit" class="btn btn-login" value="确认提交" />
					</div>
				</form>
				<?php } ?>	
			</div>
			
		</div>
	</div>
</div>

<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".form-horizontal").Validform({
		tiptype:function(msg,o,cssctl){
			var objtip=o.obj.siblings("span");
			cssctl(objtip,o.type);
			objtip.text(msg);
		}
	});
});
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>