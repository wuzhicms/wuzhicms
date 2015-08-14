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
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('show_mode');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><label class="radio-inline"><input type="radio" name="setting[show_mode]" value="1" <?php echo $setting['show_mode'] == 1 ? 'checked' : '';?>><?php echo L('list_mode');?></label> <label class="radio-inline"><input type="radio" name="setting[show_mode]" value="2" <?php echo $setting['show_mode'] == 2 ? 'checked' : '';?>><?php echo L('thumb_mode');?></label></div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('test_attachment');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <div class="input-group"><?php echo WUZHI_form::attachment('','1','setting[attachment_test]',$setting['attachment_test']);?></div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('test_attachment_thumb');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><?php echo WUZHI_form::attachment('','1','setting[attachment_thumb_test]',isset($setting['attachment_thumb_test']) ? $setting['attachment_thumb_test'] : '', '',true);?></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('test_attachment_more');?></label>
                <div class="col-lg-10 col-sm-10 col-xs-10 attaclist"><?php echo WUZHI_form::attachment('','10','setting[attachment_more_test]',isset($setting['attachment_more_test']) ? $setting['attachment_more_test'] : '', 'callback_more_dialog',0);?></div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>

        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>