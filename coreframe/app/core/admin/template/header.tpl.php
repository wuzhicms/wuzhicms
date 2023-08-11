<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="description" content="" />
    <meta name="author" content="wuzhicms.com,Pixel grid studio" />
    <title>五指CMS网站管理系统</title>
    <link href="<?php echo R;?>libs/bootstrap/css/bootstrap.min.css?<?php echo VERSION;?>" rel="stylesheet" />
    <link href="<?php echo R;?>css/style.css?<?php echo VERSION;?>" rel="stylesheet" media="screen"/>
    <script src="<?php echo R;?>libs/jquery/jquery.min.js?<?php echo VERSION;?>"></script>
    <script type="text/javascript">
        var cookie_pre = "<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';var web_url = '<?php echo WEBURL;?>';
        <?php if(!isset($set_iframe_url)) {
            echo 'var set_iframe_url = true;';
        } else {
            echo 'var set_iframe_url = false;';
        }?>
    </script>
    <script src="<?php echo R;?>js/base.js?<?php echo VERSION;?>"></script>
    <?php
        if(isset($show_dialog)) {
    ?>
    <link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css?<?php echo VERSION;?>" />
    <script src="<?php echo R;?>js/dialog/dialog-plus.js?<?php echo VERSION;?>"></script>
    <?php
        }
    if(isset($show_formjs)) {
    ?>
    <link href="<?php echo R;?>css/validform.css?<?php echo VERSION;?>" rel="stylesheet" />
    <script src="<?php echo R;?>js/validform.min.js?<?php echo VERSION;?>"></script>
    <?php }
    ?>
</head>
