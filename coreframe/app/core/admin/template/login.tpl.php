<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="login-body">
<div class="container fadeInDown">
    <form class="form-signin" id="form_login" action="index.php?m=core&f=index&v=login<?php echo $this->su();?>" method="post" onsubmit="return checkform();" >
        <div class="form-signin-heading"></div>
        <div class="login-wrap">
            <div class="loginlogo text-center"><img src="<?php echo R;?>images/login_logo.png"></div>
            <div class="form-group">
                <div class="input-group position-relative" id="username_error">
                    <div class="input-group-text position-absolute"><i class="icon-user"></i></div>
                    <input type="text" class="form-control ps-5" name="username" id="username" placeholder="用户名" autocomplete="off" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group position-relative" id="password_error">
                    <div class="input-group-text position-absolute"><i class="icon-key5"></i></div>
                    <input type="password" class="form-control ps-5" name="password" id="password" placeholder="密码" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group position-relative" id="codeid_error">
                    <div class="input-group-text position-absolute"><i class="icon-qrcode"></i></div>
                    <input type="text" id="codeid" name="checkcode" class="form-control ps-5" placeholder="验证码" onfocus="document.getElementById('code_img').src='<?php echo WWW_PATH;?>api/identifying_code.php?rd='+Math.random();void(0);">
                    <div class="input-group-text position-absolute" id="logincode">
                        <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新" onclick="this.src='<?php echo WWW_PATH;?>api/identifying_code.php?rd='+Math.random();void(0);">
                    </div>
                </div>
            </div>
            <button type="submit" name="submit" class="btn btn-shadow btn-danger btn-block btn-login w-100">登 录</button>
        </div>
        <div class="form-signin-bottom text-center">Copyright &copy; 2017 wuzhicms.com <a href="http://www.wuzhicms.com/" target="_blank">北京五指互联科技有限公司 版权所有</a></div>
    </form>
</div>
<script type="text/javascript">
   function addclass_slide(id,errid,classname) {
       $('#'+id).animate({
           opacity: 'show'
       }, 1000,function() {
           $('#'+errid).addClass(classname);
       });
   }
   function checkform() {
       $('#username_error').removeClass('validate-has-error');
       $('#password_error').removeClass('validate-has-error');
       $('#codeid_error').removeClass('validate-has-error');
        if($('#username').val()=='') {
           addclass_slide('username','username_error','validate-has-error');
           $('#username').focus();
           return false;
        }
       if($('#password').val()=='') {
           addclass_slide('password','password_error','validate-has-error');
           $('#password').focus();
           return false;
       }
       if($('#codeid').val()=='') {
           addclass_slide('codeid','codeid_error','validate-has-error');
           $('#codeid').focus();
           return false;
       }
}


$(function(){
  if(top.location.href != self.location.href){
      $('#form_login').attr('target','top');
  }

});
</script>
<?php include $this->template('footer','core');?>
