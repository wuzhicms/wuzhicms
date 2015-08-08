<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">自动回复未查询到结果时的返回内容</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea name="form[reply_content]" class="form-control" cols="60" rows="5"><?php echo output($setting,'reply_content');?></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>

            </section>
        </div>

    </div>

</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

