<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>js/colorpicker/style.css" rel="stylesheet">
<link href="<?php echo R;?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo R;?>js/colorpicker/color.js"></script>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">推广页面地址</label>
                            <div class="col-sm-8 input-group">
                                <input type="text" name="form[redirect_url]" id="redirect_url" maxlength="200" value="<?php echo $setting['redirect_url'];?>" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">积分奖励</label>
                            <div class="col-sm-10 input-group">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <input type="text" name="form[point]" id="point" size="20" class="input-text form-control" datatype="n" errormsg="必须为数字类型" value="<?php echo $setting['point'];?>" >
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="tablewarnings">成功注册后，赠送积分</span>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">积分兑换商品地址</label>
                            <div class="col-sm-8 input-group">
                                <input type="text" name="form[point2goods]" id="redirect_url" maxlength="200" value="<?php echo $setting['point2goods'];?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">会员复制推广链接提示语</label>
                            <div class="col-sm-8 input-group">
                                <input type="text" name="form[tips]" id="redirect_url" maxlength="200" value="<?php echo $setting['tips'];?>" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-sm-10 input-group">
                                <input class="btn btn-info" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:2
        });
    })
    var fontweight = '<?php echo $font_weight;?>';
function change_fontweight() {
    if(fontweight=='') {
        $("#title").css('font-weight','bold');
        fontweight = 1;
        $("#font_weight").val('font-weight:bold');
    } else {
        $("#title").css('font-weight','normal');
        fontweight = '';
        $("#font_weight").val('');
    }
}
</script>

