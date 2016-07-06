<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
    <div class="row row-40" >
        <?php if($set_iframe==0) { ?>
        <div class="col-sm-3 left-nav">             <!--左侧导航-->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="nav-close"><i class="fa fa-times-circle"></i>
                </div>
                <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                    <div class="sidebar-collapse" style="width: auto; height: 100%;">
                        <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","left"); ?>
                    </div>
                </div>
            </nav>
            <!--end 左侧导航-->
        </div><!--col-sm-3--><?php } ?>

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?> paddingleft0">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>账户安全</h5>
                        </div>
                        <div class="ibox-content" style="min-height: 500px;">
                                <div class="safelevelbody">
                                    <div class="alert alert-warning" role="alert">安全等级：<?php if($safe_level==3) { ?><a href="#" class="low">高</a><?php } elseif ($safe_level==2) { ?><a href="#" class="in">中</a><?php } else { ?><a href="#" class="hight">低</a><?php } ?> <?php if($safe_level!=3) { ?><span>建议您通过以下方式提高安全级别！</span><?php } ?></div>

                                    <div class="alert alert-safe" role="alert"><i class="fa fa-check-circle fz-32 color-right"></i><span>登录密码</span><p>互联网账户存在被盗风险，建议您定期更改密码以确保账户安全。</p> <span class="pull-right"><a href="index.php?m=member&f=index&v=edit_password&set_iframe=<?php echo $set_iframe;?>" class="btn btn-success">立即修改</a></span></div>

                                    <div class="alert alert-safe" role="alert"><i class="fa <?php if($memberinfo['ischeck_email']) { ?>fa-check-circle color-right<?php } else { ?>fa-times-circle color-wrong<?php } ?> fz-32"></i><span>邮箱验证</span><p>您的邮箱：<?php echo $memberinfo['email'];?> 验证后可用于登录，找回密码，接受订单通知等服务。</p><span class="pull-right"><a href="?m=member&f=index&v=edit_email&set_iframe=<?php echo $set_iframe;?>" class="btn <?php if($memberinfo['ischeck_email']) { ?>btn-success<?php } else { ?>btn-warning<?php } ?>">立即修改</a></span></div>

                                    <div class="alert alert-safe" role="alert"><i class="fa <?php if($memberinfo['ischeck_mobile']) { ?>fa-check-circle color-right<?php } else { ?>fa-times-circle color-wrong<?php } ?> fz-32"></i><span>手机验证</span><p><?php if($memberinfo['mobile']) { ?>当前绑定手机号为：<?php echo $memberinfo['mobile'];?><?php } ?> 验证后可用于登录，找回密码，接受订单通知等服务。</p><span class="pull-right"><a href="?m=member&f=index&v=edit_mobile&set_iframe=<?php echo $set_iframe;?>" class="btn <?php if($memberinfo['ischeck_mobile']) { ?>btn-success<?php } else { ?>btn-warning<?php } ?>">立即修改</a></span></div>


                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

