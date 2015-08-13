<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">


            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">发送方式</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">

                        <input type="radio" name="form[mail_type]" value="1" readonly <?php if(IS_WIN) echo 'disabled ';if(output($setting,'mail_type')) echo 'checked';?> onclick="change_type(1)"> 使用PHP的mail函数发送(Linux内核)
<br><br>

                        <input type="radio" name="form[mail_type]" value="0" <?php if(!output($setting,'mail_type')) echo 'checked';?> onclick="change_type(0)"> 通过 SOCKET 连接 SMTP 服务器发送


                </div>
            </div>

            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">SMTP 服务器地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[smtp_server]" color="#000000" value="<?php echo output($setting,'smtp_server');?>" >
                </div>
            </div>

            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">SMTP 端口</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[smtp_port]" color="#000000" value="<?php echo output($setting,'smtp_port');?>" >

                </div>
            </div>
            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">SMTP 身份验证</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline">
                        <input type="radio" name="form[auth]" value="1" <?php if(output($setting,'auth')) echo 'checked';?> >是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="form[auth]" value="0" <?php if(!output($setting,'auth')) echo 'checked';?> >否
                    </label>
                </div>
            </div>
            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">使用SSL加密方式</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline">
                        <input type="radio" name="form[openssl]" value="1" <?php echo $support_ssl;if(output($setting,'openssl')) echo 'checked';?> >是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="form[openssl]" value="0" <?php if(!output($setting,'openssl')) echo 'checked';?> >否
                    </label>
                    <?php if($support_ssl) {?>
                    <span class="help-block">您的服务器不支持ssl，请安装php扩展openssl</span><?php }?>
                </div>
            </div>
            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">邮箱用户名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[smtp_user]" color="#000000" value="<?php echo output($setting,'smtp_user');?>" >

                </div>
            </div>
            <div class="form-group group-smtp">
                <label class="col-sm-2 col-xs-4 control-label">邮箱密码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="password" color="#000000" value="<?php echo output($setting,'password');?>" placeholder="输入新密码">

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">发件人邮箱</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[send_email]" color="#000000" value="<?php echo output($setting,'send_email');?>" >

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">发件人昵称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[nickname]" color="#000000" value="<?php echo output($setting,'nickname');?>" >

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">邮件签名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="form[sign]" class="form-control" cols="60" rows="3"><?php echo output($setting,'sign');?></textarea>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
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
   function change_type(type) {
       if(type==1) {
            $(".group-smtp").addClass('hide');
       } else {
           $(".group-smtp").removeClass('hide');
       }
   }
   change_type(<?php echo output($setting,'mail_type');?>);
</script>
