<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="zh-cn" class="no-js sidebar-large"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
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
    <script type="text/javascript">
        var cookie_pre = "<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';var web_url = '<?php echo WEBURL;?>';
        <?php if(!isset($set_iframe_url)) {
            echo 'var set_iframe_url = true;';
        } else {
            echo 'var set_iframe_url = false;';
        }?>
    </script>
    <script src="<?php echo R;?>js/base.js"></script>
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
</head>