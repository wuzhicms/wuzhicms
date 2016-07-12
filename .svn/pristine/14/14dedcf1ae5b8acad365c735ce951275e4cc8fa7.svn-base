<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container login">
    <div class="verticalcenter">
        <div class="row">
            <div class="span7 rightline">
                <div class="col-lg-6">
                    <section class="panel">
                        <header class="panel-heading"> <span>激活账户</span> </header>
                        <div class="panel-body">
                            <div class="login-wrap">
                                <form action="" method="post" name="form-register" class="form-register">
                                    <div class="form-group">
                                        <div id="username_error" class="input-group">
                                            <div class="input-group-addon"><i class="icon-user"></i></div>
                                            <input type="text" name="email" class="form-control" placeholder="请输入Email" datatype="e" errormsg="请输入正确的Email" sucmsg="OK">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="username_error" class="input-group">
                                            <div class="input-group-addon"><i class="icon-qrcode"></i></div>
                                            <input type="text" name="checkcode" class="form-control" placeholder="验证码"  datatype="s4-4" errormsg="请输入正确的Email" sucmsg="OK">
                                            <div id="logincode" class="input-group-addon"><img id="code_img" onclick="javascript:this.src='/api/identifying_code.php?rd='+Math.random();void(0);" src="/api/identifying_code.php" alt="点击刷新"> </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-shadow btn-danger btn-block btn-login">立 即 提交</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="span5">
                <div class="connectwebsite">
                    <h6>使用合作网站登录</h6>
                    <ul>
                        <?php if($this->setting['qq_appid']) { ?><li><a href="<?php echo WEBURL;?>index.php?m=member&f=index&v=auth&type=qq"><img src="<?php echo R;?>images/qqlogin.png" alt="使用QQ帐号登录" title="使用QQ帐号登录"></a></li><?php } ?>
                        <?php if(isset($this->setting['sina_key'])) { ?><li><a href="<?php echo WEBURL;?>index.php?m=member&f=index&v=auth&type=sina"><img src="<?php echo R;?>images/weibologin.png" alt="使用微博帐号登录" title="使用微博帐号登录"></a></li><?php } ?>
                        <?php if(isset($this->setting['baidu_key'])) { ?><li><a href="<?php echo WEBURL;?>index.php?m=member&f=index&v=auth&type=baidu"><img src="<?php echo R;?>images/baidulogin.png" alt="使用百度帐号登录" title="使用百度帐号登录"></a></li><?php } ?>
                        <li><a href="#"><img src="<?php echo R;?>images/alipaylogin.png" alt="使用支付宝帐号登录" title="使用支付宝帐号登录"></a></li>
                        <li><a href="#"><img src="<?php echo R;?>images/weichatlogin.png" alt="使用微信帐号登录" title="使用微信帐号登录"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form-register").Validform({
            tiptype:3
        });
    });
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>