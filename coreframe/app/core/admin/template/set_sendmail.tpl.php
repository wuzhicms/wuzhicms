<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">发送方式</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form[mail_type]" id="flexRadioDefault1" value="1" readonly <?php if(IS_WIN) echo 'disabled ';if(output($setting,'mail_type')) echo 'checked';?> onclick="change_type(1)">
                        <label class="form-check-label" for="flexRadioDefault1">
                            使用PHP的mail函数发送(Linux内核)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="form[mail_type]" id="flexRadioDefault2"  value="0" <?php if(!output($setting,'mail_type')) echo 'checked';?> onclick="change_type(0)">
                        <label class="form-check-label" for="flexRadioDefault2">
                            通过 SOCKET 连接 SMTP 服务器发送
                        </label>
                    </div>

                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SMTP 服务器地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[smtp_server]" color="#000000" value="<?php echo output($setting,'smtp_server');?>" >
                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SMTP 端口</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[smtp_port]" color="#000000" value="<?php echo output($setting,'smtp_port');?>" >
                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SMTP 身份验证</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 d-flex align-items-center">
                    <div class="form-check form-check-inline mb-0 mt-2">
                        <input class="form-check-input" type="radio" name="form[auth]" id="inlineRadio1" value="1" <?php if(output($setting,'auth')) echo 'checked';?>>
                        <label class="form-check-label" for="inlineRadio1">是</label>
                    </div>
                    <div class="form-check form-check-inline  mb-0 mt-2">
                        <input class="form-check-input" type="radio" name="form[auth]" id="inlineRadio2" value="0" <?php if(output($setting,'auth')) echo 'checked';?>>
                        <label class="form-check-label" for="inlineRadio2">否</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">使用SSL加密方式</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 d-flex align-items-center">
                    <div class="form-check form-check-inline mb-0 mt-2">
                        <input class="form-check-input" type="radio" name="form[openssl]" id="inlineRadio3" value="1" <?php echo $support_ssl;if(output($setting,'openssl')) echo 'checked';?>>
                        <label class="form-check-label" for="inlineRadio3">是</label>
                    </div>
                    <div class="form-check form-check-inline  mb-0 mt-2">
                        <input class="form-check-input" type="radio" name="form[openssl]" id="inlineRadio4" value="0" <?php if(!output($setting,'openssl')) echo 'checked';?>>
                        <label class="form-check-label" for="inlineRadio4">否</label>
                    </div>
                    <?php if($support_ssl) {?>
                    <span class="help-block">您的服务器不支持ssl，请安装php扩展openssl</span><?php }?>
                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">邮箱用户名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[smtp_user]" color="#000000" value="<?php echo output($setting,'smtp_user');?>" >

                </div>
            </div>
            <div class="mb-3 row group-smtp">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">邮箱密码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="password" color="#000000" value="<?php echo output($setting,'password');?>" placeholder="输入新密码">

                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">发件人邮箱</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[send_email]" color="#000000" value="<?php echo output($setting,'send_email');?>" >
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">发件人昵称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[nickname]" color="#000000" value="<?php echo output($setting,'nickname');?>" >
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">邮件签名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea name="form[sign]" class="form-control" cols="60" rows="3"><?php echo output($setting,'sign');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- page end-->
</section>
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
<?php include $this->template('footer','core');?>
