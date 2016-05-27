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
                <label class="col-sm-2 col-xs-4 control-label">定金</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['dingjin'];?>" class="form-control" name="setting[dingjin]" size="100"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">返还积分数</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" value="<?php echo $setting['return_point'];?>" class="form-control" name="setting[return_point]" size="100"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="更新">
                </div>
            </div>

        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>