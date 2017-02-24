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
                <div class="col-lg-8 col-sm-8 col-xs-8 attaclist">
                    <div id="files"><ul id="files_ul"></ul></div>
                    <?php echo WUZHI_form::attachment('jpg|gif|png','100','files','', 'callback_more_dialog',0);?>
                </div>

            </div>
            <div class="form-group">
                <div class="help-block" style="padding-left:20px; ">支持格式：jpg，gif，png</div>

            </div>
<!--            |txt|zip|rar|gzip|gz|doc|docx|xls|xlsx|ppt|pptx|mp4|mp3|pdf-->

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