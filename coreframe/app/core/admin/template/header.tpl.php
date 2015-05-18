<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="zh-cn" class="no-js sidebar-large"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8 echo CHARSET;?>" />
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="" />
    <meta name="author" content="wuzhicms.cn,Pixel grid studio" />
    <title>五指互联网站内容管理系统</title>
    <link href="<?php echo R;?>css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/bootstrapreset.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/style.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/responsive.css" rel="stylesheet" media="screen"/>
    <link href="<?php echo R;?>css/animation.css" rel="stylesheet" />
    <script src="<?php echo R;?>js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="<?php echo R;?>js/jquery.min.js"></script>
    <script src="<?php echo R;?>js/wuzhicms.js"></script>
    <script src="<?php echo R;?>js/jquery-easing.js"></script>
    <script src="<?php echo R;?>js/responsivenav.js"></script>
    <?php
        if(isset($show_dialog)) {
    ?>
    <link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />
    <script src="<?php echo R;?>js/dialog/dialog-plus.js"></script>
    <?php
        }
    if(isset($show_formjs)) {
    ?>
    <link href="<?php echo R;?>css/validform.css" rel="stylesheet" />
    <script src="<?php echo R;?>js/validform.min.js"></script>
    <?php }
    ?>

    <!--[if lt IE 9]>
    <script src="<?php echo R;?>js/html5shiv.js"></script>
    <script src="<?php echo R;?>js/respond.min.js"></script>
    <![endif]-->

    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?php echo R;?>css/ie7/ie7.css">
    <!<![endif]-->

    <!--[if IE]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>WUZHICMS在谷歌浏览器下体验更好！速度更快！</strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
    </div>
    <![endif]-->

    <!--[if lte IE 8]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>您正在使用低版本浏览器，</strong> 在本页面的显示效果可能有差异。建议您升级到<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">Chrome</a>
        或以下浏览器：<a href="https://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> /<a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> /<a href="http://www.opera.com/" target="_blank">Opera</a> /<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">Internet Explorer 11</a>
    </div>
    <![endif]-->
</head>