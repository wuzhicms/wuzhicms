<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">

<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
    <div class="row row-40">
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

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>系统公告</h5>
                        </div>
                        <div class="ibox-content" style="min-height: 500px;">
                            <div class="row">
                                <form class="form-horizontal" role="form" name="myform" action="" method="post">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <tbody>
                                        <tr>
                                            <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right"> 公告主题：</label><div class="col-sm-8 text-left "  style="padding-top: 6px;"><?php echo $r['title'];?></div></div></td>
                                        </tr>

                                        <tr>
                                            <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right">公告内容：</label><div class="col-sm-8 text-left" style="padding-top: 6px;"><?php echo $r['content'];?></div></div></td>
                                        </tr>



                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="<?php echo R;?>css/validform.css" rel="stylesheet" />
<script src="<?php echo R;?>js/validform.min.js"></script>
<!--正文部分-->
<script type="text/javascript">
    $("#submit").click(function(){
        t=setTimeout("hide_formtips()",2000);
    });
    function hide_formtips() {
        $.Hidemsg();
        clearInterval(t);
    }
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1
        });
    })
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>


