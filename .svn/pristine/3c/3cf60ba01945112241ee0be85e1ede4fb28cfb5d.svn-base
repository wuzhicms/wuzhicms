<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<style class="text/css">
.auth{border-bottom:1px solid #ccc;margin-bottom: 30px;padding-bottom: 40px;}
.auth img{float:left;width:48px;height:48px;margin:5px;}
.auth span{padding: 5px 10px;background-color: #2C83E5;cursor: pointer;color: #fff;}
.auth h2{margin-bottom: 6px;}
</style>
<div class="container login">
	<div class="verticalcenter">
		<div class="row">
			<div class="auth">
				<img src="http://avatar.connect.discuz.qq.com/10000034/ECC01FBFE0A4D44E95B56B1AF605ACF7" />
				<h2>登陆成功，为正常使用本站功能首次登录请先绑定本站会员</h2>
				<span onclick="setTab('register')">注册新帐号</span>
				<span onclick="setTab('login')">已有本站帐号</span>
			</div>
			<div class="span7 rightline">
				<form action="index.php?m=member&f=index&v=register" method="post"	class="form-horizontal" id="register">
                    <div class="form-group">
                        <label class="control-label">账户名</label>
                        <div class="col-sm-8">
							<input type="text" name="username" class="form-control" placeholder="请输入用户名" datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{4,20}$/i" errormsg="用户名为4-20位数字、字母、汉字和-组成" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_user">
                            <span class="Validform_wrong">用户名应该为2-20位之间</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" name="email" class="form-control" placeholder="请输入Email" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_email">
                            <span class="Validform_wrong">请输入Email</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">验证码</label>
                        <div class="col-sm-8">
                            <input type="text" name="checkcode" class="form-control" placeholder="请输入验证码" datatype="*4-4" errormsg="请输入验证码" sucmsg="输入正确" onfocus="if($('#code_img_r').attr('src') == '<?php echo R;?>images/logincode.gif')$('#code_img_r').attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());" />
                            <img src="<?php echo R;?>images/logincode.gif" id="code_img_r" alt="点击刷新" onclick="$(this).attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());"> <span class="Validform_wrong">请输入验证码</span>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label"></label>
						<input type="hidden" name="submit" value="1" />
						<input type="submit" class="btn btn-login" value="立即提交" />
					</div>
				</form>
				<form action="index.php?m=member&f=index&v=login" method="post"	class="form-horizontal hide" id="login">
                    <div class="form-group">
                        <label class="control-label">账户名</label>
                        <div class="col-sm-8">
                            <input type="text" name="username" class="form-control" placeholder="用户名/Email/手机号码"	datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{4,20}$/i"	errormsg="用户名为4-20位数字、字母、汉字和-组成" sucmsg="输入正确"/>
                            <span class="Validform_wrong">用户名应该为2-20位之间</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" placeholder="请输入密码" datatype="*" errormsg="请输入密码"	sucmsg="输入正确"/>
                            <span class="Validform_wrong">请输入密码</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">验证码</label>
                        <div class="col-sm-8">
                            <input type="text" name="checkcode" class="form-control" placeholder="请输入验证码" datatype="*4-4"	errormsg="请输入验证码" sucmsg="输入正确" onfocus="if($('#code_img').attr('src') == '<?php echo R;?>images/logincode.gif')$('#code_img').attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());" />
                            <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新"	onclick="$(this).attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());"> <span class="Validform_wrong">请输入验证码</span>
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label"></label>
						<input type="hidden" name="submit" value="1" />
						<input type="submit" class="btn btn-login" value="立即提交" />
					</div>
				</form>
			</div>
			<div class="span5">
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
function setTab(type){
	$(this).addClass('hover');
	if(type == 'register'){
		$('.auth span').eq(1).removeClass('hover');
		$('#login').hide();
		$('#register').show();
		$('#code_img_r').attr('src', '<?php echo R;?>images/logincode.gif');
	}else{
		$('.auth span').eq(0).removeClass('hover');
		$('#login').show();
		$('#register').hide();
		$('#code_img').attr('src', '<?php echo R;?>images/logincode.gif');
	}
	$('input[name="checkcode"]').val('');
}
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
