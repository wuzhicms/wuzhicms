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
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">反馈时间</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo date('Y-m-d H:i',$r['addtime']);?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">邮箱</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo $r['email'];?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">反馈问题</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo $r['content'];?>
                    </div>
                </div>

                <?php
                if(!$r['replytime']) {
                ?>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                        <input class="btn btn-info w-100" type="submit" name="submit" value="设置为已处理">
                    </div>
                </div>
                <?php }?>
            </form>
        </div>
    </section>
<!-- page end-->
</section>
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
<?php include $this->template('footer','core');?>