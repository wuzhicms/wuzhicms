<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R;?>libs/colorpicker/color.js"></script>
<section class="">
<div class="row">
<div class="col-lg-12">
    <form class="form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?php echo WUZHI_form::editor('form[templatedata]','templatedata',$templatedata,'basic');?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <input class="btn btn-primary col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
            </div>
        </div>
    </form>
</div>
</div>
<!-- page end-->
</section>
<script>
    $(function () {
        CKEDITOR.config.startupMode ='source';
        CKEDITOR.config.height = 400;
    });
</script>
<script src="<?php echo R;?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
