<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?> -  Powered by wuzhicms</title>
    <meta name="keywords" content="<?php if(isset($seo_keywords)) { ?><?php echo $seo_keywords;?><?php } ?>">
    <meta name="description" content="<?php if(isset($seo_description)) { ?><?php echo $seo_description;?><?php } ?>">
    <meta name="generator" content="wuzhicms 3.x" />
    <!-- CSS -->
    <link href="<?php echo R;?>t3/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo R;?>t3/css/style.css" rel="stylesheet">
    <link href="<?php echo R;?>t3/css/hover.css" rel="stylesheet">
    <link href="<?php echo R;?>t3/css/pindao-style.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo R;?>t3/css/non-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.wuzhicms.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.wuzhicms.com/respond.js/1.4.2/respond.min.js"></script>
    <style>
        .img-responsive{ max-width: inherit }
    </style>

    <![endif]-->
    <script type="text/javascript">
        var cookie_pre = "<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';var web_url = '<?php echo WEBURL;?>';
    </script>
    <script src="<?php echo R;?>t3/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/base.js"></script>
</head>

<body>
<nav class="navbar navbar-inverse-primary">
    <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
    <div id="navbar" class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html">
                <img src="<?php echo R;?>t3/image/logo_ov.png">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'0','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <li><a href="<?php echo WEBURL;?>">首页</a></li>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($r['ismenu']) { ?><li <?php if($top_categoryid==$r['cid']) { ?>class="active"<?php } ?>><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a></li><?php } ?>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>

        <ul class="nav navbar-nav navbar-right hide" id="mylogined">
            <?php if(!isset($hide_search_icon)) { ?>
            <li class="dropdown serch--dropdown-menu">
                <a href="#"   class="dropdown-toggle" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  style="padding-top: 18px; padding-bottom: 15px;"><span class="glyphicon glyphicon-search" aria-hidden="true" style="padding-top: 7px;"></span> </a>
                <ul class="dropdown-menu ">
                    <form name="topsearch" action="" method="get">
                    <div class="input-group  select-search">
                        <input type="text" name="keywords" class="form-control" placeholder="搜索<?php echo $top_category['name'];?>" style="border-left: 1px solid #cccccc; background: none;">
                        <input type="hidden" name="f" value="search">
                        <input type="hidden" name="modelid" value="<?php echo $modelid;?>">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                      </span>
                    </div><!-- /input-group -->
                    </form>
                </ul>
            </li>
            <?php } ?>
            <!--
            <li class="dropdown  mall--dropdown-menu">
                <a href="#"   class="dropdown-toggle " data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" style="padding-top: 5px;"></span> <span class="font-Arial font_size14">3</span></a>
                <ul class="dropdown-menu">
                    <p class="font_size12">最近加入的宝贝：</p>


                    <ul class="cart-list">
                        <li>
                            <div class="cart-item clearfix"><a class="thumb" href=""><img alt="" src="image/temp/temp8.jpg " width="60px"></a>
                                <a class="name" href="">小蚁蓝牙遥控器胡歌来测试  黑色</a><span class="price">39元 × 1</span>
                                <a class="btn-del" href="javascript: void(0);"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                            </div>
                        </li>
                        <li>
                            <div class="cart-item clearfix "><a class="thumb" href=""><img alt="" src=""></a>
                                <a class="name" href="">智能唤醒翻盖保护套 黑色</a> <span class="price">39元 × 1</span>
                                <a class="btn-del" href="javascript: void(0);"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
                            </div>
                        </li>

                    </ul>


                    <li role="separator" class="divider" style="margin-top: 0"></li>
                    <p class="font_size12 text-right">购物车里还有1件宝贝</p>
                    <a href="#" class=" btn btn-warning btn-sm  float_right">查看我的购物车</a>
                </ul>
            </li>
            -->
            <li class="dropdown login--dropdown-menu">
                <a href="<?php echo WEBURL;?>index.php?m=member"  title="进入会员中心"  class="dropdown-toggle" ><img src="<?php echo WEBURL;?>api/myface.php" class="img-circle" height="24px;" style="border: 2px solid #fff"> wuzhicms</a>
            </li>
            <li>
                <a href="<?php echo WEBURL;?>index.php?m=member&v=logout"  class="dropdown-toggle" >退出</a>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="mylogin">
            <?php if(!isset($hide_search_icon)) { ?>
            <li class="dropdown serch--dropdown-menu">
                <a href="#"   class="dropdown-toggle" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-search" aria-hidden="true" style="padding-top: 5px;"></span> </a>
                <ul class="dropdown-menu ">
                    <form name="topsearch" action="" method="get">
                        <div class="input-group  select-search">
                            <input type="text" name="keywords" class="form-control" placeholder="搜索<?php echo $top_category['name'];?>" style="border-left: 1px solid #cccccc; background: none;">
                            <input type="hidden" name="f" value="search">
                            <input type="hidden" name="modelid" value="<?php echo $modelid;?>">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                      </span>
                        </div><!-- /input-group -->
                    </form>
                </ul>
            </li>
            <?php } ?>
            <li class="dropdown login--dropdown-menu">
                <a href="#"  title="登录"  class="dropdown-toggle" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> </a>
                <ul class="dropdown-menu">
                    <form name="toplogin" action="<?php echo WEBURL;?>index.php?m=member&v=login" method="post" onsubmit="return formcheck_toplogin();">
                        <p class="help-block text-right color_999">还不是会员? <a href="<?php echo WEBURL;?>index.php?m=member&v=register">立即注册</a></p>
                        <div class="form-group">
                            <input type="text" class="form-control" id="toplogin_username" name="username" placeholder="用户名" >
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="toplogin_password" name="password" placeholder="密码">
                        </div>
                        <div class="form-group " style="position: relative;">
                            <input type="text" name="checkcode" class="form-control" id="toplogin_checkcode" placeholder="请输入验证码" onfocus="if($('#code_img').attr('src') == '<?php echo R;?>images/logincode.gif') $('#code_img').attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&amp;h=40&amp;rd='+Math.random());" onkeyup="toplogin_keyup(this.value)" >
                            <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新" onclick="$(this).attr('src', '<?php echo R;?>api/identifying_code.php?w=112&amp;h=40&amp;rd='+Math.random());" style="margin-top:2px; position: absolute; top: 0;right: 2px; max-height: 35px;">
                        </div>
                        <div class="checkbox font_size12">
                            <label>
                                <input type="checkbox" name="savecookie" value="1" checked> 下次自动登录
                            </label>
                            <a  href="<?php echo WEBURL;?>index.php?m=member&v=public_find_password_email" class="color_warning pading_left_10px" style=" float: right">忘记密码？</a>
                        </div>
                        <div id="toplogin_msg" class="help-block-g  color_danger hide"></div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block"><span class="font_size16">登录</span></button>
                    </form>
                    <div class=" disanfang_ico">
                        <div  style=" color: #999999; padding-bottom: 8px;">使用第三方账号登录</div>
                        <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=qq"><img src="<?php echo R;?>images/qqlogin.png" alt="使用QQ帐号登录" title="使用QQ帐号登录" width="30px"></a></li>
                        <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=sina"><img src="<?php echo R;?>images/weibologin.png" alt="使用微博帐号登录" title="使用微博帐号登录" width="30px"></a></li>
                        <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=weixin"><img src="<?php echo R;?>images/weichatlogin.png" alt="使用微信帐号登录" title="使用微信帐号登录" width="30px"></a></li>
                    </div>

                </ul>
            </li>

        </ul>

    </div><!--/.nav-collapse -->

</nav>