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
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_imagePathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['imagePathFormat'];?>" class="form-control" name="setting[imagePathFormat]" size="100"></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_scrawlPathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['scrawlPathFormat'];?>" class="form-control" name="setting[scrawlPathFormat]" size="100"></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_snapscreenPathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['snapscreenPathFormat'];?>" class="form-control" name="setting[snapscreenPathFormat]" size="100"></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_filePathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['filePathFormat'];?>" class="form-control" name="setting[filePathFormat]" size="100"></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_videoPathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['videoPathFormat'];?>" class="form-control" name="setting[videoPathFormat]" size="100"></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_catcherPathFormat');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['catcherPathFormat'];?>" class="form-control" name="setting[catcherPathFormat]" size="100"></div>
            </div>
            <span class="help-block"><?php echo L('ue_path_intro');?></span>

 			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('ue_catch_mode');?></label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group"><input type="radio" name="setting[catchRemoteImageEnable]" value="1" <?php echo $setting['catchRemoteImageEnable'] == 1 ? 'checked' : '';?>><?php echo L('ajax_mode');?> &nbsp;&nbsp; <input type="radio" name="setting[catchRemoteImageEnable]" value="0" <?php echo $setting['catchRemoteImageEnable'] == 0 ? 'checked' : '';?>><?php echo L('syn_mode');?>
                <span class="help-block"><?php echo L('catch_mode');?></span>
				</div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>

        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>