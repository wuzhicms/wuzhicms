<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <header class="panel-heading"><span>安全设置</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">启用后台管理日志</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="logerr" id="flexRadioDefault1" value="1" <?php if(defined('ADMIN_LOG')) echo 'checked';?> disabled>
                        <label class="form-check-label" for="flexRadioDefault1">是</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="logerr" id="flexRadioDefault2" value="0" <?php if(!defined('ADMIN_LOG')) echo 'checked';?> disabled>
                        <label class="form-check-label" for="flexRadioDefault2">否</label>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">访问后台的密码串</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="su" color="#000000" value="<?php echo _SU;?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">禁止访问网站IP列表</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea name="form[ban_ips]" class="form-control" cols="60" rows="3"><?php echo output($setting,'ban_ips');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">允许登录后台IP列表</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea name="form[adminlogin_ips]" class="form-control" cols="60" rows="3"><?php echo output($setting,'adminlogin_ips');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">安全识别码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="wuzhicms_token" value="<?php echo output($setting,'wuzhicms_token');?>" size="50"><span class="input-group-btn"><button class="btn btn-white" type="button"><a href="http://www.wuzhicms.com/api/get_wuzhicms_token.php" target="_blank">获取方式？</a></button></span>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
