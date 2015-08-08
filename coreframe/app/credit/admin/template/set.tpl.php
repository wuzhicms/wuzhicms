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
                <label class="col-sm-2 col-xs-4 control-label">注册赠送积分：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <a href="?m=member&f=index&v=set<?php echo $this->su();?>">点击这里单独修改</a>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">是否开启后台充值入帐</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label style="width: 60px;"> <input type="radio" name="form[status]" value="1" <?php if(output($setting,'status')==1) echo 'checked';?>> 开启</label>
                    <label style="width: 60px;"> <input type="radio" name="form[status]" value="0" <?php if(!output($setting,'status')) echo 'checked';?>> 关闭</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">验证手机赠送积分：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[mobile_check]" value="<?php echo output($setting,'mobile_check');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">验证邮件赠送积分：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[email_check]" value="<?php echo output($setting,'email_check');?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">竞价每次增加积分：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[jingjia_pre_point]" value="<?php echo output($setting,'jingjia_pre_point');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">发布信息扣除积分数：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[cominfoadd]" value="<?php echo output($setting,'cominfoadd');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">刷新信息扣除：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[cominfo_f5]" value="<?php echo output($setting,'cominfo_f5');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">积分购买兑换比例(1元：？积分)：</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[exchange_point]" value="<?php echo output($setting,'exchange_point');?>">
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

