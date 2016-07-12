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
                <label class="col-sm-2 col-xs-4 control-label">支付方式</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo  $r['name'];?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">描述</label>
                <div class="col-lg-3 col-sm-8 col-xs-8">
                    <?php echo  $r['remark'];?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">支付宝帐户</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="setting[alipay_account]" value="<?php echo output($setting,'alipay_account');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">合作者身份(parterID)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="setting[partner]" value="<?php echo output($setting,'partner');?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">交易安全校验码(key)</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="setting[key]" value="<?php echo output($setting,'key');?>">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">选择接口类型</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline"> <input type="radio" name="setting[service_type]" value="0" <?php if(!output($setting,'service_type')) echo 'checked';?>> 担保交易接口</label>
                    <label class="radio-inline"> <input type="radio" name="setting[service_type]" value="1"  <?php if(output($setting,'service_type')==1) echo 'checked';?>> 标准双接口</label><label class="radio-inline"> <input type="radio" name="setting[service_type]" value="2"  <?php if(output($setting,'service_type')==2) echo 'checked';?>> 即时到账接口</label>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">支付帮助说明（提示用户）</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="note" class="form-control" cols="60" rows="4"><?php echo $r['note'];?></textarea>                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">状态</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline"> <input type="radio" name="status" value="1" <?php if($r['status']==1) echo 'checked';?>> 开启</label>
                    <label class="radio-inline"> <input type="radio" name="status" value="2" <?php if($r['status']==2) echo 'checked';?>> 关闭</label>
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
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })

</script>

