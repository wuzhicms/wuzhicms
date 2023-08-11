<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">发件人邮箱</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="mails" color="#000000" value="<?php echo output($setting,'send_email');?>" readonly>

                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">收件人邮箱</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="receive" color="#000000" value="" >
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 col-xs-6">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
