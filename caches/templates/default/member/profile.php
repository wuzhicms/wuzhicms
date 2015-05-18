<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script src="<?php echo R;?>member/js/jscarousel.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#jsCarousel').jsCarousel({ onthumbnailclick: function(src) {
            // 可在这里加入点击图片之后触发的效果
            $("#overlay_pic").attr('src', src);
            $(".overlay").show();
        }, autoscroll: true });

        $(".overlay").click(function(){
            $(this).hide();
        });
        <?php if(isset($GLOBALS['tabid'])) { ?>
        $("#<?php echo $GLOBALS['tabid'];?>").click();
            <?php } ?>
    });
</script>
<!--正文部分-->
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            
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
                        <header class="panel-heading"><span class="title">账户信息</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">基本信息</a></li>
                            <li role="presentation" class=""><a href="#tabs2" role="tab" id="2tab" data-toggle="tab" aria-controls="tabs2" aria-expanded="false">设置密码</a></li>
                            <li role="presentation" class=""><a href="#tabs3" role="tab" id="3tab" data-toggle="tab" aria-controls="tabs3" aria-expanded="false">账户等级</a></li>
                            <li role="presentation" class=""><a href="#tabs4" role="tab" id="4tab" data-toggle="tab" aria-controls="tabs4" aria-expanded="false">修改头像</a></li>
                        </ul>


                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <form class="form-horizontal" role="form" name="myform" action="" method="post" id="myform" onsubmit="return formsubmit();">

                                        <table class="table table-striped table-advance table-hover text-center">
                                            <tbody>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">账户名：</label><div class="col-sm-3 text-left"><p class="form-control-static"><?php echo $memberinfo['username'];?></p></div></div></td>
                                            </tr>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">账户等级：</label><div class="col-sm-3 text-left"><p class="form-control-static"><a href="#"><i class="smmember <?php echo $groups[$memberinfo['groupid']]['icon'];?>"></i><?php echo $groups[$memberinfo['groupid']]['name'];?></a></p></div></div></td>
                                            </tr>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">邮箱：</label><div class="col-sm-6 text-left" style="padding-top: 6px;"><?php if(strpos($memberinfo['email'],'@h1jk.cn')===false) { ?><?php echo $memberinfo['email'];?><?php } ?> <?php if($memberinfo['ischeck_email']==0) { ?><a href="?m=member&f=index&v=edit_email" style="color:#2a3bfb;">您的邮箱还未验证通过，验证后可获积分：<?php echo $point_config['email_check'];?>点，点击验证</a> <?php } ?></div></div></td>
                                            </tr>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">手机：</label><div class="col-sm-6 text-left" style="padding-top: 6px;"><?php echo $memberinfo['mobile'];?> <?php if($memberinfo['ischeck_mobile']==0) { ?><a href="?m=member&f=index&v=edit_mobile" style="color:#2a3bfb;">您的手机还未验证通过，验证后可获积分：<?php echo $point_config['mobile_check'];?>点，点击验证</a> <?php } ?></div></div></td>
                                            </tr>

                                            <?php $n=1;if(is_array($field_list)) foreach($field_list AS $info) { ?>
                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><?php if($info['star']) { ?><font color="red">*</font><?php } ?> <?php echo $info['name'];?>：</label><div class="col-sm-3 text-left"><?php echo $info['form'];?><span class="tablewarnings"><?php echo $info['remark'];?></span></div></div></td>
                                            </tr>
                                            
                                            <?php $n++;}?>
                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">验证码：</label><div class="col-sm-8 text-left"><input type="text" id="Verificationcode" name="checkcode" class="form-control" placeholder="验证码" onfocus="javascript:document.getElementById('code_img').src='<?php echo WEBURL;?>index.php?m=core&w=110&h=40&f=identifying_code&rd='+Math.random();void(0);"> <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新" onclick="javascript:this.src='<?php echo WEBURL;?>index.php?m=core&f=identifying_code&rd='+Math.random();void(0);"></div></div></td>
                                            </tr>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"> </label><div class="col-sm-3 text-left"><button type="submit" name="submit" class="btn btn-order">提 交</button></div></div></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                </div>

                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                                <div class="panel-body" id="panel-bodys">
                                    <form class="form-horizontal" role="form" name="passworform" action="?m=member&f=index&v=edit_password" method="post" id="passworform" onsubmit="return check_password();">
                                        <table class="table table-striped table-advance table-hover text-center">
                                            <tbody>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">原密码：</label><div class="col-sm-3 text-left"><input type="password" class="form-control" id="oldpassword" placeholder="请输入原密码" name="oldpassword" type="password"></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">新密码：</label><div class="col-sm-3 text-left"><input type="password" class="form-control" id="password" placeholder="请输入新密码" name="password" type="password"></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">确认密码：</label><div class="col-sm-3 text-left"><input type="password" class="form-control" id="repassword" placeholder="请再输入一次" name="password2" type="password"></div></div></td>
                                            </tr>
                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">验证码：</label><div class="col-sm-8 text-left"><input type="text" id="Verificationcode" name="checkcode" class="form-control" placeholder="验证码" onfocus="javascript:document.getElementById('code_img2').src='<?php echo WEBURL;?>index.php?m=core&w=110&h=40&f=identifying_code&rd='+Math.random();void(0);"> <img src="<?php echo R;?>images/logincode.gif" id="code_img2" alt="点击刷新" onclick="javascript:this.src='<?php echo WEBURL;?>index.php?m=core&f=identifying_code&rd='+Math.random();void(0);"></div></div></td>
                                            </tr>

                                            <tr>
                                                <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"> </label><div class="col-sm-3 text-left"><button type="submit" name="submit" class="btn btn-order">提 交</button></div></div></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tabs3" aria-labelledby="3tab">
                                <div class="panel-body" id="panel-bodys">
                                    <div class="levelinfo">
                                        <p>您的会员级别是：<i class="smmember <?php echo $groups[$groupid]['icon'];?>"></i><?php echo $groups[$groupid]['name'];?></p>
                                        <p>您目前的积分为: <strong><?php echo $memberinfo['points'];?></strong>点,再获得<a href="#"><?php echo $nextpoints;?> 点</a> 即可成为 <strong><i class="smmember <?php echo $groups[$next_group]['icon'];?>"></i><?php echo $groups[$next_group]['name'];?></strong></p>
                                        <p>获得成长值的办法：每日登录、点评体检中心，点评套餐</p>
                                        <p><a href="?m=credit&f=mycredit&v=listing">【 查看我的账户明细 】</a></p>
                                    </div>
                                    <div class="memberlevel">
                                        <h5>会员级别图示：</h5>
                                        <ul>
                                            <li><a href="#"><i class="memberlevel1"></i><span>个人会员</span><p>注册成功即成为普通会员</p></a></li>
                                            <li><a href="#"><i class="memberlevel2"></i><span>VIP会员</span><p>积分501</p></a></li>
                                            <li><a href="#"><i class="memberlevel3"></i><span>黄金会员</span><p>积分1001</p></a></li>
                                            <li><a href="#"><i class="memberlevel4"></i><span>白金会员</span><p>积分5001</p></a></li>
                                            <li><a href="#"><i class="memberlevel5"></i><span>钻石会员</span><p>积分20001</p></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tabs4" aria-labelledby="4tab">


                                <script language="javascript" type="text/javascript" src="<?php echo R;?>js/swfobject.js"></script>
                                <script type="text/javascript">
                                    var flashvars = {
                                        'upurl':"<?php echo $upurl;?>&callback=return_avatar&"
                                    };
                                    var params = {
                                        'align':'middle',
                                        'play':'true',
                                        'loop':'false',
                                        'scale':'showall',
                                        'wmode':'window',
                                        'devicefont':'true',
                                        'id':'Main',
                                        'bgcolor':'#fff',
                                        'name':'Main',
                                        'allowscriptaccess':'always'
                                    };
                                    var attributes = {
                                    };
                                    swfobject.embedSWF("<?php echo R;?>js/avatar.swf", "myContent", "490", "434", "9.0.0","<?php echo R;?>js/expressInstall.swf", flashvars, params, attributes);

                                    function return_avatar(data) {
                                        if(data == 1) {
                                            window.location.reload();
                                        } else {
                                            alert('failure');
                                        }
                                    }
                                </script>
                                <div class="memberavatar" id="avatarlist" style="float:right;">
                                    <li>
                                        <img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/180x180.jpg" height="180" width="180" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
                                        <?php echo L('avatar');?>180 x 180
                                    </li>
                                    <li>
                                        <img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/90x90.jpg" height="90" width="90" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
                                        <?php echo L('avatar');?>90 x 90
                                    </li>
                                    <li>
                                        <img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/45x45.jpg" height="45" width="45" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
                                        <?php echo L('avatar');?>45 x 45
                                    </li>
                                    <li>
                                        <img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/30x30.jpg" height="30" width="30" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
                                        <?php echo L('avatar');?>30 x 30
                                    </li>
                                </div>
                                <div class="col-auto">
                                    <div id="myContent"><p>Alternative content</p></div>
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

<script type="text/javascript">
    function formsubmit() {

        myform.submit();
    }
    function check_password() {
        if($("#oldpassword").val()=='') {
            var d = dialog({
                content: '原密码不能为空！'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
                $("#oldpassword").focus();
            }, 2000);

            return false;
        }
        if($("#password").val()=='' || $("#repassword").val()=='') {
            var d = dialog({
                content: '新密码不能为空！'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
                if($("#password").val()=='') {
                    $("#password").focus();
                } else {
                    $("#repassword").focus();
                }
            }, 2000);

            return false;
        }
        if($("#password").val() != $("#repassword").val()) {
            var d = dialog({
                content: '新密码输入不一致！'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
                $("#password").focus();
            }, 2000);

            return false;
        }
        passworform.submit();
    }
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>