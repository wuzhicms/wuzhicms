<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<!--正文部分-->
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <img src="<?php echo R;?>member/image/ad.jpg" alt="">
        </div>
    </div>
</div>

<div class="container memberframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!--左侧开始-->
            <div class="memberleft">
                <div class="membertitle"><h3>会员中心</h3></div>
                <div class="memberborder">
                    <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
                </div>
            </div>
            <!--左侧结束-->

            <!--右侧开始-->
            <div class="memberright">

                <div class="memberbordertop">
                    <section class="panel">
                        <header class="panel-heading"><span class="title">账户安全</span></header>
                        <div class="panel-body">
                            <div class="safelevelbody">
                                <div class="alert alert-warning" role="alert">安全等级：<?php if($safe_level==3) { ?><a href="#" class="low">高</a><?php } elseif ($safe_level==2) { ?><a href="#" class="in">中</a><?php } else { ?><a href="#" class="hight">低</a><?php } ?> <?php if($safe_level!=3) { ?><span>建议您通过以下方式提高安全级别！</span><?php } ?></div>

                                <div class="alert alert-safe" role="alert"><i class="glyphicon glyphicon-ok-sign"></i><span>登录密码</span><p>互联网账户存在被盗风险，建议您定期更改密码以确保账户安全。</p><span class="pull-right"><a href="?m=member&f=index&v=profile&tabid=2tab" class="btn btn-success">立即修改</a></span></div>

                                <div class="alert alert-safe" role="alert"><i class="glyphicon <?php if($memberinfo['ischeck_email']) { ?>glyphicon-ok-sign<?php } else { ?>glyphicon-exclamation-sign<?php } ?>"></i><span>邮箱验证</span><p>您的邮箱：<?php echo $memberinfo['email'];?> 验证后可用于登录，找回密码，接受订单通知等服务。</p><span class="pull-right"><a href="?m=member&f=index&v=edit_email" class="btn <?php if($memberinfo['ischeck_email']) { ?>btn-success<?php } else { ?>btn-warning<?php } ?>">立即修改</a></span></div>

                                <div class="alert alert-safe" role="alert"><i class="glyphicon <?php if($memberinfo['ischeck_mobile']) { ?>glyphicon-ok-sign<?php } else { ?>glyphicon-exclamation-sign<?php } ?>"></i><span>手机验证</span><p><?php if($memberinfo['mobile']) { ?>当前绑定手机号为：<?php echo $memberinfo['mobile'];?><?php } ?> 验证后可用于登录，找回密码，接受订单通知等服务。</p><span class="pull-right"><a href="?m=member&f=index&v=edit_mobile" class="btn <?php if($memberinfo['ischeck_mobile']) { ?>btn-success<?php } else { ?>btn-warning<?php } ?>">立即修改</a></span></div>

                                <div class="alert alert-warning" role="alert">
                                    <h5>安全服务提示：</h5>
                                    <p>1、确认您登录的是合一健康网，网址：www.h1jk.cn,注意防范进入钓鱼网站，不要轻信各种及时通讯工具发送的商品和支持链接，谨防网购诈骗！</p>
                                    <p>2、建议您安装杀毒软件，并定期更新操作系统等软件补丁，确保账户交易安全.</p>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>

            </div>
            <!--右侧结束-->


        </div>
    </div>
</div>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

