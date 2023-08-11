<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>
<div class="panel-body">
    <div class="alert alert-warning">
        <strong>重要提示:</strong> 以下配置仅对百度编辑器（Ueditor）起作用。
    </div>
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_imagePathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['imagePathFormat'];?>" class="form-control" name="setting[imagePathFormat]" size="100"></div>
            </div>

			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_scrawlPathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['scrawlPathFormat'];?>" class="form-control" name="setting[scrawlPathFormat]" size="100"></div>
            </div>

			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_snapscreenPathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['snapscreenPathFormat'];?>" class="form-control" name="setting[snapscreenPathFormat]" size="100"></div>
            </div>

			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_filePathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['filePathFormat'];?>" class="form-control" name="setting[filePathFormat]" size="100"></div>
            </div>

			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_videoPathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['videoPathFormat'];?>" class="form-control" name="setting[videoPathFormat]" size="100"></div>
            </div>

			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_catcherPathFormat');?></label>
                <div class="col-3"><input type="text" value="<?php echo $setting['catcherPathFormat'];?>" class="form-control" name="setting[catcherPathFormat]" size="100"></div>
            </div>
            <span class="help-block"><?php echo L('ue_path_intro');?></span>

 			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('ue_catch_mode');?></label>
                <div class="col-10">
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="setting[catchRemoteImageEnable]" id="catchRemoteImageEnable1" value="1" <?php echo $setting['catchRemoteImageEnable'] == 1 ? 'checked' : '';?>>
                            <label class="form-check-label" for="catchRemoteImageEnable1"><?php echo L('ajax_mode');?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="setting[catchRemoteImageEnable]" id="catchRemoteImageEnable0" value="0" <?php echo $setting['catchRemoteImageEnable'] == 0 ? 'checked' : '';?>>
                            <label class="form-check-label" for="catchRemoteImageEnable0"><?php echo L('syn_mode');?></label>
                        </div>
                    </div>
                    <span class="help-block"><i class="icon-info-circle"></i><?php echo L('catch_mode');?></span>
                </div>
            </div>


            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"></label>
                <div class="col-3">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>

        </form>
    </div>
<?php include $this->template('footer','core');?>
