<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>

<link type="text/css" rel="stylesheet" href="<?php echo R;?>css/login_style.css">
<div class="container login">
	<div class="verticalcenter" style="background:none; ">
		<div class="row">
       		 <div class="span5 rightline">
				<div class="connectwebsite">
                	<h3>欢迎您！</h3>
                    <p>其实我们最主要想和大家说的不是这些功能，而是想告诉大家开发这个产品的初衷，这个产品的基因里就固化了她"开放与共同参与"的性格，今天发布的产品只是个基础是个平台，热诚的欢迎各位爱好者、开发者参与进来，后续我们会上线插件商城和模板商城，希望五指CMS不仅仅是个内容管理系统，更是一个可以为大家带来收益的平台。还是一个把自己的爱好转化为生产力的工具。</p><br/>
					<h6>还不是注册会员，<a href="<?php echo WEBURL;?>index.php?m=member&v=register" style="font-size:16px; color:#C00">免费注册！</a></h6>
				</div>
			</div>
			<div class="span7 ">
            <h4><span class="glyphicon glyphicon-user color_heyilan" aria-hidden="true"></span> 会员登录</h4>
				<form action="index.php?m=member&f=index&v=login" method="post"	class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label">用户名/手机号</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="username" placeholder="预约卡号/用户名/Email/手机号码" name="username"	datatype="/^[a-z0-9@\.\u4E00-\u9FA5\uf900-\ufa2d\-]{3,20}$/i"	errormsg="用户名为3-20位数字、字母、汉字和-组成" sucmsg="输入正确" autoComplete="off">
                            <span class="Validform_wrong">用户名应该为2-20位之间</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label>
                        <div class="col-xs-8">
                            <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码" datatype="*" errormsg="请输入密码"	sucmsg="输入正确"/>
                            <span class="Validform_wrong">请输入密码</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">验证码</label>
                        <div class="col-xs-8">
                            <input type="text" name="checkcode" class="form-control"	id="Verificationcode" placeholder="请输入验证码" datatype="*4-4"	errormsg="请输入验证码" sucmsg="输入正确" onfocus="if($('#code_img').attr('src') == '<?php echo R;?>images/logincode.gif')$('#code_img').attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());" />
                            <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新"	onclick="$(this).attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&h=40&rd='+Math.random());"> <span class="Validform_wrong">请输入验证码</span>
                        </div>
                    </div>

					<div class="form-group">
						<label class="control-label"></label>
						<input type="checkbox" class="checkbox" name="savecookie" value="1" checked />
						下次自动登录 <a href="<?php echo WEBURL;?>index.php?m=member&v=public_find_password_email">忘记密码？</a>
					</div>
					<div class="form-group">
						<label class="control-label"></label>
						<input type="hidden" name="forward" value="<?php echo $forward;?>" />
						<input type="submit" name="submit" class="btn btn-login " value="登录" />
						<!--<a href="<?php echo WEBURL;?>index.php?m=member&v=register" class="btn btn-register">注册</a>-->
					</div>
				</form>
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
<style>
	*:focus { outline: none; }
	body{background-color:#fafafa}
	.login .verticalcenter .form-group .btn-login {
  padding: 10px 36px;
  color: #fff;
  text-shadow: none;
  border-color: #AA151B;
  background-color: #AA151B;
  background-image: -webkit-gradient(linear,left top,left bottom,from(#AA151B),to(#8A0000));
  background-image: -webkit-linear-gradient(top,#AA151B,#8A0000);
  background-image: -moz-linear-gradient(top,#4795f7,#3c8de9);
  background-image: -ms-linear-gradient(top,#4795f7,#3c8de9);
  background-image: -o-linear-gradient(top,#4795f7,#3c8de9);
  background-image: linear-gradient(top,#4795f7,#3c8de9);
  filter: progid:DXImageTransform.Microsoft.gradient(StartColorStr="#4795f7",EndColorStr="#3c8de9");
}
</style>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
