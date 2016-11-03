<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
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
                <label class="col-sm-2 col-xs-4 control-label">反馈时间</label>
                <div class="col-sm-8 input-group">
                    <?php echo date('Y-m-d H:i',$r['addtime']);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">邮箱</label>
                <div class="col-sm-8 input-group">
                    <?php echo $r['email'];?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">反馈问题</label>
                <div class="col-sm-8 input-group">
                    <?php echo $r['content'];?>
                </div>
            </div>

            <?php
            if(!$r['replytime']) {
            ?>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="设置为已处理">
                </div>
            </div>
            <?php }?>
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
    var fontweight = '';
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

