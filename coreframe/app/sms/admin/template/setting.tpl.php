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
                            <label class="col-sm-2 col-xs-4 control-label">用户ID(sms_uid)</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[sms_uid]"  value="<?php echo output($setting,'sms_uid');?>" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">产品ID(sms_pid)</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[sms_pid]" value="<?php echo output($setting,'sms_pid');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">密钥(sms_passwd)</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[sms_passwd]" value="<?php echo output($setting,'sms_passwd');?>">
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
    <!-- page end--><div class="alert alert-success fade in">
        <strong>短信购买:</strong> 支持全国电信、移动、联通手机用户。购买地址 <a href="http://sms.phpip.com/index.php?m=sms_service&c=center&a=init" target="_blank">http://sms.phpip.com/index.php?m=sms_service&c=center&a=init</a>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

