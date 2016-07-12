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
        <form class="form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">

				<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tags_batch');?></label>
                <div class="row">
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea class="form-control" name="import" id="import"  cols="80" rows="10"></textarea>
                </div>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo L('batch_note');?>
                </div>
                </div>
                
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tags_upload');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="file" accept=".txt" name="file" id="file" value="<?php echo L('select_file');?>" /> 
                    <span class="help-block"><i class="icon-info-circle"></i><?php echo L('file_note');?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="<?php echo L('submit');?>">
                </div>
            </div>
        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>