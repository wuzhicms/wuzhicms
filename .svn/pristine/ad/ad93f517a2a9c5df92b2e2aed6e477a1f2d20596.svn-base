<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>js/colorpicker/style.css" rel="stylesheet">
<link href="<?php echo R;?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo R;?>js/colorpicker/color.js"></script>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">物流名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="form[title]" id="title" maxlength="80" class="form-control" value="<?php echo $r['title'];?>" datatype="s2-60" errormsg="至少2个字符,最多20个字符！"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">网址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[url]" datatype="url" errormsg="请填写正确的网址"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">缩略图</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="input-group"><?php echo $form->attachment('','1','form[thumb]','');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">介绍</label>
                <div class="col-lg-6 col-sm-6 col-xs-6 input-group">
                    <?php echo WUZHI_form::editor('form[content]','content','','basic');?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>

        </form>
    </div>
</section>
</div>
</div>
<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
</script>

