<!DOCTYPE html><div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">开始：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?> -  Powered by wuzhicms</title>
    <meta name="keywords" content="<?php if(isset($seo_keywords)) { ?><?php echo $seo_keywords;?><?php } ?>">
    <meta name="description" content="<?php if(isset($seo_description)) { ?><?php echo $seo_description;?><?php } ?>">
    <meta name="generator" content="wuzhicms 3.x" />
    <!-- CSS -->
    <link href="<?php echo R;?>t3/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo R;?>t3/css/style.css" rel="stylesheet">
    <link href="<?php echo R;?>t3/css/hover.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo R;?>t3/css/non-responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="//cdn.wuzhicms.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.wuzhicms.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        var cookie_pre = "<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';var web_url = '<?php echo WEBURL;?>';
    </script>
    <script src="<?php echo R;?>t3/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/base.js"></script>
</head>

<body>

<nav class="navbar navbar-default-index">
    <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
    <div id="navbar" class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo WEBURL;?>">
                <img alt="Brand" src="<?php echo R;?>t3/image/logo.png">
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
	$rs = $content_template_parse->category(array('order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($r['pid']==0 && $r['ismenu']) { ?>
            <li><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a></li>
            <?php } ?>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>

        <ul class="nav navbar-nav navbar-right hide" id="mylogined">
            <?php if(!isset($hide_search_icon)) { ?>
            <li>
                <a href="<?php echo WEBURL;?>index.php?f=search"  style="padding-top: 18px; padding-bottom: 15px;"><span class="glyphicon glyphicon-search" aria-hidden="true" style="padding-top: 7px;"></span> </a>
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
            <li>
                <a href="<?php echo WEBURL;?>index.php?f=search"  style="padding-top: 18px; padding-bottom: 15px;"><span class="glyphicon glyphicon-search" aria-hidden="true" style="padding-top: 7px;"></span> </a>
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
                            <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新" onclick="$(this).attr('src', '<?php echo WEBURL;?>api/identifying_code.php?w=112&amp;h=40&amp;rd='+Math.random());" style="margin-top:2px; position: absolute; top: 0;right: 2px; max-height: 35px;" title="点击更换验证码">
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
                        <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=qq"><img src="<?php echo R;?>images/qqlogin.png" alt="使用QQ帐号登录" title="使用QQ帐号登录" width="30px"></a></li>                    <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=sina"><img src="<?php echo R;?>images/weibologin.png" alt="使用微博帐号登录" title="使用微博帐号登录" width="30px"></a></li>                    <li><a href="<?php echo WEBURL;?>index.php?m=member&amp;f=index&amp;v=auth&amp;type=weixin"><img src="<?php echo R;?>images/weichatlogin.png" alt="使用微信帐号登录" title="使用微信帐号登录" width="30px"></a></li>
                    </div>

                </ul>
            </li>

        </ul>
    </div><!--/.nav-collapse -->
</nav>

<!--ad-->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad-box" style="height: 90px; width: 100%; background: #dddddd; text-align: center; "><script  src="<?php echo WEBURL;?>promote/1.js"></script></div>
        </div>
    </div>
</div>




<!--index-one-screen-->
<div class="index-one-screen">
    <!--big-headline-news-->
    <div class="container">

        <div class="big-headline-news ">
            <div class="row">
                <!--头条-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'16','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php if($n==1) { ?>
                <div class="col-xs-12">
                    <div class="border--bottom1s">
                        <h2 class=" text-center  manhangyichu" ><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></h2>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-xs-3"><div  class="sm-title manhangyichu border--bottom1s"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></div></div>
                <?php } ?>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>

        </div>


        <div class="index-last-new-box">
            <div class="row">
                <!--图片区-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'18','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php if($n==1) { ?>
                <div class="col-xs-6">
                    <div class="narrowArt">
                        <a href="<?php echo $r['url'];?>" title="222" target="_blank">
                            <img  src=" <?php echo imagecut($r['thumb'],562,380,4);?>" alt="" height="380">
                            <h1><?php echo $r['title'];?></h1>
                        </a>
                    </div>
                </div>
                <div class="col-xs-3">
                    <?php } else { ?>
                    <div class="narrowArt video">
                        <a href="<?php echo $r['url'];?>" title="222" target="_blank">
                            <img  src=" <?php echo imagecut($r['thumb'],273,182,4);?>" alt="" height="182">
                            <h2><?php echo $r['title'];?></h2>
                        </a>
                    </div>
                    <?php } ?>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                </div>
                <div class="col-xs-3">

                    <div class="headline-news-list">
                        <!--列表区-->
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'19','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading color_qiyelan font_size16 toutiao-right-title" ><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></h4>
                                <div class="media-content  color_777 "><?php echo strip_tags($r['remark']);?></div>
                            </div>
                        </div>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                
                    </div>
                </div>

            </div>

            <div class="row">
                <!--专题区-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'20','start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="col-xs-3">
                    <div class="narrowArt jia-biaoqian">
                        <a href="<?php echo $r['title'];?>" title="222" target="_blank">
                            <img  src="<?php echo imagecut($r['thumb'],273,182,4);?>" alt="<?php echo $r['tilte'];?>" height="182">
                            <h2 data-autor="专题推荐"><?php echo $r['title'];?></h2>
                        </a>
                    </div>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>
        </div>
    </div>
</div>

<div class="ad-box" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/2.js"></script></div>
            </div>
        </div>
    </div>
</div>


<!-- 图片 -->
<div class="container">
    <div class="index-pic-box">
        <div class="lanmu-content lanmu-content-bg">
            <h2 class="lanmu-title">
                <a href="/index.php?v=listing&cid=3&page=1" >图片</a>
            </h2>
            <nav>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'3','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php if($r['ismenu']) { ?><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a><?php } ?>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </nav>
        </div>


        <div class="row">
            <div class="col-xs-2">
                <!--图片区一-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'21','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="narArts">
                    <a title="222" href="<?php echo $r['url'];?>" target="_blank">
                        <div class="crop">
                            <img  src=" <?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>">
                        </div>
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                
            </div>
            <div class="col-xs-4">
                <!--图片区二-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'22','start'=>'0','pagesize'=>'8','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<?php if($n==1) { ?>
<div class="narrowArt">
    <a href="<?php echo $r['url'];?>" title="222" target="_blank">
        <img  src=" <?php echo imagecut($r['thumb'],369,380,4);?>" alt="<?php echo $r['title'];?>" height="380">
        <h1><?php echo $r['title'];?></h1>
    </a>
</div>
<?php } elseif ($n==2) { ?>
<div class="narrowArt">
    <a href="<?php echo $r['url'];?>" title="222" target="_blank">
        <img  src=" <?php echo imagecut($r['thumb'],369,181,4);?>" alt="<?php echo $r['title'];?>" height="182">
        <h2><?php echo $r['title'];?></h2>
    </a>
</div>
</div>
<div class="col-xs-6">
    <div class="row">
        <?php } else { ?>
        <div class="col-xs-6">
            <div class="narrowArt">
                <a href="<?php echo $r['url'];?>" title="222" target="_blank">
                    <img  src=" <?php echo imagecut($r['thumb'],273,182,4);?>" alt="<?php echo $r['title'];?>" height="182">
                    <h2><?php echo $r['title'];?></h2>
                </a>
            </div>
        </div>
        <?php } ?>
        <?php $n++;}?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="ad-box" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/3.js"></script></div>
            </div>
        </div>
    </div>
</div>




<!-- 视频 -->
<div class="container">
    <div class="index-video-box">
        <div class="row">
            <div class="col-xs-9">
                <div class="lanmu-content lanmu-content-bg">
                    <h2 class="lanmu-title">
                        <a href="/index.php?v=listing&cid=38&page=1" >视频</a>
                    </h2>
                    <nav>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'38','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($r['ismenu']) { ?><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a><?php } ?>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </nav>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="lanmu-content lanmu-content-bg-r">
                    <h2 class="lanmu-title">
                        <a href="#" >浏览排行</a>
                    </h2>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-2">
                <!--图片区一-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'24','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="narArts">
                    <a title="222" href="<?php echo $r['url'];?>" target="_blank">
                        <div class="crop">
                            <img  src=" <?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>">
                        </div>
                        <h2><strong>+ 专题 + </strong><br><?php echo $r['title'];?></h2>
                    </a>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>
            <div class="col-xs-4">
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'25','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php if($n==1) { ?>
                <div class="narrowArt jia-biaoqian video">
                    <a href="<?php echo $r['url'];?>" title="222" target="_blank">
                        <img  src=" <?php echo imagecut($r['thumb'],369,380,4);?>" alt="<?php echo $r['title'];?>" height="380">
                        <h1 data-autor="原创"><?php echo $r['title'];?></h1>
                    </a>
                </div>
                <?php } elseif ($n==2) { ?>
                <div class="narrowArt video jia-biaoqian">
                    <a href="<?php echo $r['url'];?>" title="222" target="_blank">
                        <img  src=" <?php echo imagecut($r['thumb'],369,181,4);?>" alt="<?php echo $r['title'];?>" height="182">
                        <h2 data-autor="原创"><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <div class="col-xs-3">
                <?php } else { ?>
                <div class="narrowArt video">
                    <a href="<?php echo $r['url'];?>" title="222">
                        <img  src=" <?php echo imagecut($r['thumb'],273,182,4);?>" alt="<?php echo $r['title'];?>" height="182">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
               <?php } ?>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>
            <div class="col-xs-3">
                <div class="list-ol-box">
                    <ol class="rectangle-list">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'weekviews DESC','cid'=>'38','start'=>'0','pagesize'=>'16','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <li ><a href="<?php echo $r['url'];?>" target="_blank"><?php echo safe_htm($r['title']);?></a></li>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="ad-box" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/4.js"></script></div>
            </div>
        </div>
    </div>
</div>



<!-- 团购 -->
<div class="container">
    <div class="index-tuangou-box">
        <div class="row">
            <div class="col-xs-9">
                <div class="lanmu-content lanmu-content-bg">
                    <h2 class="lanmu-title">
                        <a href="/index.php?v=listing&cid=27&page=1" >团购</a>
                    </h2>
                    <nav>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'27','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($r['ismenu']) { ?><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a><?php } ?>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </nav>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="lanmu-content lanmu-content-bg-r">
                    <h2 class="lanmu-title">
                        <a href="#" >特惠推荐</a>
                    </h2>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-2">
                <!--团购专场-->
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'27','start'=>'0','pagesize'=>'2','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="narArts">
                    <a title="222" href="<?php echo $r['url'];?>" target="_blank">
                        <div class="crop">
                            <img  src=" <?php echo $r['thumb'];?>" alt="">
                        </div>
                        <h2><strong>+ 团购专场 + </strong><br> <?php echo $r['title'];?></h2>
                    </a>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                

            </div>
            <!--团购推荐-->
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'28','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($n==1) { ?>
            <div class="col-xs-4">
                <div class="narrowArt tuan-price">
                    <a href="<?php echo $r['url'];?>">
                        <ins class="tuan-price_ico"><strong>￥<?php echo $r['price'];?></strong></ins>
                        <img  src=" <?php echo imagecut($r['thumb'],369,380,4);?>" alt="<?php echo $r['title'];?>" height="380">
                        <h1><?php echo $r['title'];?></h1>
                    </a>
                </div>
            </div>
            <div class="col-xs-3">
                <?php } else { ?>
                <div class="narrowArt tuan-price">
                    <a href="<?php echo $r['url'];?>">
                        <ins class="tuan-price_ico"><strong>￥<?php echo $r['price'];?></strong></ins>
                        <img  src="<?php echo imagecut($r['thumb'],273,181,4);?>" alt="" height="182">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
                <?php } ?>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>

            <div class="col-xs-3 right-thumbnail">
                <div class="row">
                    <!--特惠推荐-->
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'29','start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <div class="col-xs-6">
                        <a href="<?php echo $r['url'];?>" class="thumbnail box-and-title-img">
                            <ins class="tuijian_ico">抢购</ins>
                            <div class="imght">
                                <img src=" <?php echo imagecut($r['thumb'],126,91,4);?>" alt="<?php echo $r['title'];?>" >
                            </div>
                            <div class="caption height-hide97">
                                <h4><strong class="color_warning font_size18">￥<?php echo $r['price'];?></strong> <del class="color_999 font_size12">￥<?php echo $r['iprice'];?></del></h4>
                                <p class="font_size12">
                                    <?php echo $r['title'];?>
                                </p>
                            </div>
                        </a>
                    </div>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                
                </div>
            </div>
        </div>
    </div>


</div>

<div class="ad-box" style="margin-top: 0">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/5.js"></script></div>
            </div>
        </div>
    </div>
</div>

<!-- 积分商城 -->
<div class="container">
    <div class="index-jifenmall-box">
        <div class="row">
            <div class="col-xs-9">
                <div class="lanmu-content lanmu-content-bg">
                    <h2 class="lanmu-title">
                        <a href="/index.php?v=listing&cid=26&page=1" >积分商城</a>
                    </h2>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="lanmu-content lanmu-content-bg-r">
                    <h2 class="lanmu-title">
                        <a href="/index.php?v=listing&cid=39&page=1" >热门兑换</a>
                    </h2>
                </div>
            </div>
        </div>


        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'30','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php $attach=unserialize($r['attach'])?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control">
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo imagecut($r['thumb'],271,181,4);?>" alt="<?php echo $r['title'];?>" ></a>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><strong><?php echo $r['title'];?></strong><br>
                            <span><strong class="color_success"><?php echo $attach['point'];?></strong> 积分   <?php if($attach['price']!='0.00') { ?><?php if($attach['point_money']!=0) { ?><strong class="color_success"><?php echo $attach['point_money'];?></strong> 积分 + <?php } ?>    <strong class="color_qiyecheng"><?php echo $attach['price'];?></strong>元<?php } ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

            <!--hot-duihuan-->
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'31','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php $attach=unserialize($r['attach'])?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control">
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo imagecut($r['thumb'],271,181,4);?>" alt="<?php echo $r['title'];?>" ></a>
                        <ins class="tuijian_ico">立即兑换</ins>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><strong><?php echo $r['title'];?></strong><br>
                            <span><strong class="color_success"><?php echo $attach['point'];?></strong> 积分   <?php if($attach['price']!='0.00') { ?><?php if($attach['point_money']!=0) { ?><strong class="color_success"><?php echo $attach['point_money'];?></strong> 积分 +<?php } ?>    <strong class="color_qiyecheng"><?php echo $attach['price'];?></strong>元<?php } ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>


<div class="container">
    <div class="friend-link">
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"link\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('link_template_parse')) {
	$link_template_parse = load_class("link_template_parse", "link");
}
if (method_exists($link_template_parse, 'listing')) {
	$rs = $link_template_parse->listing(array('kid'=>'0','order'=>'sort ASC','start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $link_template_parse->pages;$number = $link_template_parse->number;}?>
        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
        <a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['sitename'];?> </a>
        <?php $n++;}?>
        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center  line_height2d0">
                <p>联系电话：010-82463345 &nbsp; &nbsp;QQ:282198327 &nbsp;Email:zhw@wuzhicms.com</p> <br>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'51','order'=>'sort ASC','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <a href="<?php echo $r[url];?>"><?php echo $r['name'];?></a>  <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                <a href="<?php echo WEBURL;?>index.php?m=link">友情链接</a> <br>
                <?php echo $siteconfigs['copyright'];?><?php echo $siteconfigs['statcode'];?> <a href="http://www.wuzhicms.com" target="_blank">五指CMS提供技术支持</a> </div>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo R;?>t3/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo R;?>t3/js/ie10-viewport-bug-workaround.js"></script>

<script src="<?php echo R;?>t3/js/my.js"></script>
<script src="<?php echo R;?>t3/js/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript">
    var _uid=getcookie('_uid');
    if(_uid!=null) {
        $("#mylogined").removeClass('hide');
        $("#mylogin").addClass('hide');
        var _username=decodeURI(getcookie('truename'));
        $("#myname").html(_username);
    }
</script>
</body>
</html>
<div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">结束：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><script>setTimeout(function(){$(".remove_debug").remove();},20000);</script>