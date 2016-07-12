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
    <header class="panel-heading"><span>安全设置</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">


            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">启用后台管理日志</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline">
                        <input type="radio" name="logerr" value="1" <?php if(defined('ADMIN_LOG')) echo 'checked';?> disabled>是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="logerr" value="0" <?php if(!defined('ADMIN_LOG')) echo 'checked';?> disabled>否
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">访问后台的密码串</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="su" color="#000000" value="<?php echo _SU;?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">禁止访问网站IP列表</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="form[ban_ips]" class="form-control" cols="60" rows="3"><?php echo output($setting,'ban_ips');?></textarea>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">允许登录后台IP列表</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="form[adminlogin_ips]" class="form-control" cols="60" rows="3"><?php echo output($setting,'adminlogin_ips');?></textarea>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">安全识别码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="wuzhicms_token" value="<?php echo output($setting,'wuzhicms_token');?>" size="50"><span class="input-group-btn"><button class="btn btn-white" type="button"><a href="http://www.wuzhicms.com/api/get_wuzhicms_token.php" target="_blank">获取方式？</a></button></span>
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
<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

