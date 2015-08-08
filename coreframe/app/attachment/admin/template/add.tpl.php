<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<body class="body pxgridsbody">
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>


<div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">自定义目录名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" value="" class="form-control" id="attachment_test" name="diycat">
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">批量上传附件</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 attaclist"><?php echo WUZHI_form::attachment('jpg|jpep|gif|png|txt|zip|rar|gzip|gz|doc|docx|xls|xlsx|ppt|pptx|mp4|mp3|pdf','100','files','', 'callback_more_dialog',0);?>
                </div>
                <span class="help-block col-lg-10 col-sm-10 col-xs-10">支持格式：jpg，jpep，gif，png，txt，zip，rar，gzip，gz，doc，docx，xls，xlsx，ppt，pptx，mp4，mp3，pdf</span>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>
        </form>
    </div>
    <script>
        sync_delete_file = true;
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>