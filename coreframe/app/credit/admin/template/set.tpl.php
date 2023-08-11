<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">注册赠送积分：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <a class="btn btn-sm btn-xs btn-info" href="?m=member&f=index&v=set<?php echo $this->su();?>">点击这里单独修改</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">是否开启后台充值入帐</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="status1" value="1" <?php if(output($setting,'status')==1) echo 'checked';?>>
                            <label class="form-check-label" for="status1">开启</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="status0" value="0" <?php if(!output($setting,'status')) echo 'checked';?>>
                            <label class="form-check-label" for="status0">关闭</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">验证手机赠送积分：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[mobile_check]" value="<?php echo output($setting,'mobile_check');?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">验证邮件赠送积分：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[email_check]" value="<?php echo output($setting,'email_check');?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">竞价每次增加积分：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[jingjia_pre_point]" value="<?php echo output($setting,'jingjia_pre_point');?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">发布信息扣除积分数：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[cominfoadd]" value="<?php echo output($setting,'cominfoadd');?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">刷新信息扣除：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[cominfo_f5]" value="<?php echo output($setting,'cominfo_f5');?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end">积分购买兑换比例(1元：？积分)：</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[exchange_point]" value="<?php echo output($setting,'exchange_point');?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-xs-4 control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>

            </form>
        </div>
    </section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>

