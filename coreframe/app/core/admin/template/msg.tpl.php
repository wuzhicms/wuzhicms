<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-cn">
<meta http-equiv="content-type" content="text/html;charset=utf-8 echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<head>
    <title>五指CMS网站管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="Pixel grid studio"  />
    <link href="<?php echo R;?>libs/bootstrap/css/bootstrap.min.css?<?php echo VERSION;?>" rel="stylesheet" />
    <link href="<?php echo R;?>css/style.css?<?php echo VERSION;?>" rel="stylesheet" />
    <script src="<?php echo R;?>libs/jquery/jquery.min.js?<?php echo VERSION;?>"></script>
    <script type="text/javascript">
        var cookie_pre = "<?php echo COOKIE_PRE;?>";var cookie_domain = '<?php echo COOKIE_DOMAIN;?>';var cookie_path = '<?php echo COOKIE_PATH;?>';var web_url = '<?php echo WEBURL;?>';
    </script>
    <script src="<?php echo R;?>js/base.js"></script>
</head>
<body class="body pxgridsbody">
<div class="container">
    <div class="prompt text-center">
        <div class="promptmain">
            <div class="prompthead"></div>
            <div class="prompcontainer">
                <h6><i class="icon-info"></i><span><?php echo $msg;?></span></h6>
                <?php if($gotourl) {?><script language="javascript">setTimeout("gotourl('<?php echo $gotourl;?>');",<?php echo $time?>);</script>
                <a href="<?php echo $gotourl;?>">页面将自动跳转，请稍等</a>
                <?php }?>
            </div>
            <div class="promptfooter"><a href="javascript:history.back();" >[ 返回上一页 ]</a></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        parent.window.scroll(0,0);
    })
</script>
</body>
</html>
