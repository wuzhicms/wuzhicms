<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<?php $categorys=get_cache('category','content');?>
<?php $cityname = isset($cityname) ? $cityname : get_cookie('cityname');?>
<?php $cityid = isset($cityid) ? $cityid : get_cookie('cityid');?>
<?php $city = isset($city) ? $city : $categorys[$cityid]['catdir'];?>
<html>
<head lang="zh-CN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset=utf-8"gbk">
    <title><?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?></title>
    <meta name="keywords" content="<?php if(isset($seo_keywords)) { ?><?php echo $seo_keywords;?><?php } ?>">
    <meta name="description" content="<?php if(isset($seo_description)) { ?><?php echo $seo_description;?><?php } ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>member/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>member/css/style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>member/css/member.css">
    <script type="text/javascript">
        var cookie_pre="<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';
    </script>
    <script type="text/javascript" src="<?php echo R;?>member/js/jquery.min.js"></script>
    <script src="<?php echo R;?>js/base.js"></script>

    <script type="text/javascript" src="<?php echo R;?>member/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo R;?>member/js/Tab.js"></script>
    <script type="text/javascript" src="<?php echo R;?>member/js/star.js"></script>
    <script type="text/javascript" src="<?php echo R;?>member/js/my.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo R;?>member/css/m_style_ie.css">
    <![endif]-->
</head>
<body>
<!-- ---------------------------------- -->
<!-- top -->
<!-- ---------------------------------- -->
<div class="topnav">
    <div class="container">
        <div id="mylogin" class="topnav_left"><a href="<?php echo WEBURL;?>index.php?m=member&v=login">登录</a>&nbsp;&nbsp;<span class="font_size10 color_999">|</span>&nbsp;&nbsp;<a href="<?php echo WEBURL;?>index.php?m=member&v=register">注册</a><a href="<?php echo WEBURL;?>index.php?m=member&v=register" class="color_777 font_size12"> (免费注册送积分)</a></div>
        <div id="mylogined" class="topnav_left hide"><span id="myname"></span> <a href="<?php echo WEBURL;?>index.php?m=member">[会员中心]</a> <a href="<?php echo WEBURL;?>index.php?m=member&v=logout">[退出]</a></div>
        <div class="topnav_right">
            <ul class="nav navbar_top-nav navbar-right">
                <!--<li class="dropdown" id="mini_car">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">我的购物车<span class="color_heyihong">(0)</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style=" min-width:300px;">
                        <li class="margin_left20">您还没有登录，<button type="button" class="btn btn-danger_g" style="float:right; margin-right:30px;" onclick="gotourl('/index?m=member&v=login')"><span class="glyphicon glyphicon-shopping-cart"></span>
                            点击这里登录</button></a></li>
                    </ul>
                </li>-->
                <li class="dropdown" id="my-panel1">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">个人中心 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/index.php?m=order&f=order_goods&v=listing&acbar=3">我的订单</a></li>
                        <li><a href="/index.php?m=order&f=order_form&v=subscribe&acbar=3">我的预约</a></li>
                        <li><a href="/index.php?m=member&f=favorite&v=tuan">我收藏的套餐</a></li>
                        <li><a href="/index.php?m=member&f=favorite&v=mec&acbar=3">我收藏的机构</a></li>
                        <li class="divider"></li>
                        <li><a href="/index.php?m=member">会员中心</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="my-panel2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">企业中心 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/index.php?m=order&f=order_goods&v=listing&acbar=3">我的订单</a></li>
                        <li><a href="/index.php?m=content&f=cominfo&v=listing">发布需求</a></li>
                        <li class="divider"></li>
                        <li><a href="/index.php?m=member">企业中心</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="my-panel3">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">机构中心 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/index.php?m=content&f=postinfo&v=listing">发布产品</a></li>
                        <li><a href="/index.php?m=content&f=mecinfo&v=listing">发布信息</a></li>
                        <li class="divider"></li>
                        <li><a href="/index.php?m=member">机构中心</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">帮助中心 <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/index.php?m=guestbook&f=myissue&v=newask">我要提问</a></li>
                        <li><a href="/index.php?v=listing&cid=433&page=1">购买流程</a></li>
                        <li><a href="/index.php?v=listing&cid=434&page=1">体检流程</a></li>
                        <li class="divider"></li>
                        <li><a href="/index.php?v=listing&cid=425&page=1">帮助中心</a></li>
                    </ul>
                </li>
            </ul>


        </div>
    </div>
</div>
<!-- ---------------------------------- -->
<!-- header -->
<!-- ---------------------------------- -->

<div class="logobox">
    <div class="container">
        <div class="logobox_logo">
        <a href="<?php echo WEBURL;?>"><img src="<?php echo R;?>t2/image/logo_gr.png" height="60px;" style="max-width:180px;" title="返回：合一健康首页"></a>
        
        </div>


        <div class="logobox_right">
            <div  style="padding-top:8px;"><img src="http://placehold.it/450x75" width="450" height="75"></div>
        </div>
    </div>
</div>


