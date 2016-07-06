<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>
<style>
    .m-member-right{ padding-left: 30px; padding-right: 30px; margin-top: 38px;}
    @media (max-width: 991px){
        .m-member-right{ padding-left: 0px; padding-right: 0px; margin-top: 38px;}
    }
    .mm--xinxi{ font-size: 14px }
    .mm--xinxi .table > tbody > tr > td{ padding: 16px 5px;}

</style>
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
                    <div class=" float-e-margins">

                        <div class="ibox-content" style="min-height: 800px;">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="thumbnail" style="border: none; text-align: center;">
                                        <img src="<?php echo avatar($this->uid, 180);?>" class="img-circle" style="border: 0px solid #f5f5f5;    box-shadow: 0 0 8px rgba(0,0,0,.15); margin-bottom: 20px; max-height: 120px;">
                                        <a href="index.php?m=member&f=index&v=avatar&set_iframe=<?php echo $set_iframe;?>" type="btn" class="btn btn-default btn-outline"><i class="fa fa-photo"></i> 更换头像</a>
                                    </div>
                                </div>
                                <div class="col-md-5 mm--xinxi">
                                    <h3 style="font-size: 24px; font-weight: 500; margin-top: 30px;">个人信息</h3>
                                    <table class="table table-hover">
                                        <br>
                                        <tbody>
                                        <tr>
                                            <th scope="row">昵&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</th>
                                            <td><?php echo $memberinfo['username'];?></td>
                                            <td><a href="index.php?m=member&f=index&v=set_username&set_iframe=<?php echo $set_iframe;?>" type="btn" class="btn btn-default btn-outline btn-xs" style="margin-bottom: 0px"><i class="fa fa-pencil-square-o"></i> 更改</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">真实姓名：</th>
                                            <td><?php echo $memberinfo['truename'];?></td>
                                            <td><a href="index.php?m=member&f=index&v=profile&set_iframe=<?php echo $set_iframe;?>" type="btn" class="btn btn-default btn-outline btn-xs" style="margin-bottom: 0px"><i class="fa fa-pencil-square-o"></i> 更改</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">注册邮箱：</th>
                                            <td><?php echo $memberinfo['email'];?></td>
                                            <td><a href="index.php?m=member&f=index&v=edit_email" type="btn" class="btn btn-default btn-outline btn-xs" style="margin-bottom: 0px"><i class="fa fa-pencil-square-o"></i> 更改</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">手机号码：
                                            </th>
                                            <td><?php echo $memberinfo['mobile'];?></td>
                                            <td><a href="index.php?m=member&f=index&v=edit_mobile&set_iframe=<?php echo $set_iframe;?>" type="btn" class="btn btn-default btn-outline btn-xs" style="margin-bottom: 0px"><i class="fa fa-pencil-square-o"></i> 更改</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">会 员 组：</th>
                                            <td><?php echo $groups[$memberinfo['groupid']]['name'];?></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">注册时间：</th>
                                            <td><?php echo date('Y-m-d',$memberinfo['regtime']);?></td>
                                            <td>注册IP: <?php echo $memberinfo['regip'];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">最后登录：</th>
                                            <td><?php echo date('Y-m-d',$memberinfo['lasttime']);?></td>
                                            <td>登录IP: <?php echo $memberinfo['lastip'];?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-5">
                                    <div class="m-member-right">
                                        <h4>修改密码</h4>
                                        <br>
                                        <form name="myform" action="index.php?m=member&f=index&v=edit_password&set_iframe=<?php echo $set_iframe;?>" method="post" id="myform" onsubmit="return formsubmit();">
                                            <div class="form-group">
                                                <!--<label for="exampleInputPassword1">原密码</label>-->
                                                <input name="oldpassword" type="password" class="form-control" id="oldpassword" placeholder="原密码">
                                            </div>
                                            <div class="form-group">
                                                <!--<label for="exampleInputPassword1">新密码</label>-->
                                                <input name="password" type="password" class="form-control" id="password" placeholder="新密码">
                                            </div>
                                            <div class="form-group">
                                                <!-- <label for="exampleInputPassword1">再次输入密码</label>-->
                                                <input name="password2" type="password" class="form-control" id="password2" placeholder="再次出入密码">
                                            </div>
                                            <button name="submit" type="submit" class="btn btn-danger">确认修改</button>
                                        </form>
                                        <br><br>
                                        <h4>第三方授权</h4>
                                        <br>
                                        <div style="background: #f5f5f5; padding: 8px 12px; border-left: 2px solid #55aa55; margin-bottom: 5px" >
                                            <?php if($auth_result['weixin']) { ?>
                                            <div style="display: inline-block;  "><i class="fa fa-weixin" style="font-size: 24px; color: #55aa55; width: 30px;"></i> &nbsp;&nbsp;已授权&nbsp;&nbsp; 账号：<?php echo $auth_result['weixin']['nickname'];?></div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=remove_auth&type=weixin" type="btn" class="btn btn-danger  btn-xs"> 取消授权</a></div>
                                            <?php } else { ?>
                                            <div style="display: inline-block;  "><i class="fa fa-weixin" style="font-size: 24px; color: #55aa55; width: 30px;"></i> &nbsp;&nbsp;未授权&nbsp;&nbsp; 账号：-</div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=bind_auth&type=weixin" type="btn" class="btn btn-primary  btn-xs" target="_blank"> 授权</a></div>
                                            <?php } ?>
                                        </div>
                                        <div style="background: #f5f5f5; padding: 8px 12px; border-left: 2px solid #d78a10;margin-bottom: 5px" >
                                            <?php if($auth_result['sina']) { ?>
                                            <div style="display: inline-block;  "><i class="fa fa-weibo" style="font-size: 24px; color: #d78a10; width: 30px;"></i> &nbsp;&nbsp;已授权&nbsp;&nbsp; 账号：<?php echo $auth_result['sina']['nickname'];?></div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=remove_auth&type=sina" type="btn" class="btn btn-danger  btn-xs"> 取消授权</a></div>
                                            <?php } else { ?>
                                            <div style="display: inline-block;  "><i class="fa fa-weibo" style="font-size: 24px; color: #d78a10; width: 30px;"></i> &nbsp;&nbsp;未授权&nbsp;&nbsp; 账号：-</div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=bind_auth&type=sina" type="btn" class="btn btn-primary  btn-xs" target="_blank"> 授权</a></div>
                                            <?php } ?>
                                        </div>
                                        <div style="background: #f5f5f5; padding: 8px 12px; border-left: 2px solid #2ea7ca ;margin-bottom: 5px" >
                                            <?php if($auth_result['qq']) { ?>
                                            <div style="display: inline-block; line-height: 24px; "><i class="fa fa-qq" style="font-size: 24px; color: #2ea7ca; width: 30px;"></i> &nbsp;&nbsp;已授权 &nbsp;&nbsp;账号：<?php echo $auth_result['qq']['nickname'];?></div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=remove_auth&type=qq" type="btn" class="btn btn-danger  btn-xs" > 取消授权</a></div>
                                            <?php } else { ?>
                                            <div style="display: inline-block; line-height: 24px; "><i class="fa fa-qq" style="font-size: 24px; color: #2ea7ca; width: 30px;"></i> &nbsp;&nbsp;未授权 &nbsp;&nbsp;账号：-</div>
                                            <div style="display: inline-block; float: right;    margin-top: 2px;"><a href="?m=member&v=bind_auth&type=qq" type="btn" class="btn btn-primary  btn-xs" target="_blank"> 授权</a></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>