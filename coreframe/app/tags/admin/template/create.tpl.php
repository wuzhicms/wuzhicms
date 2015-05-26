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
        <form class="form-horizontal tasi-form" method="post" action="">

			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo L('create_confirm');?></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="create_confirm" id="create_confirm" value="五指CMS" /><span class="help-block"><?php echo L('create_tips');?></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    <input class="btn btn-info" type="submit" name="dosubmit" value="<?php echo L('create_now');?>">
                </div>
            </div>
        </form>
    </div>