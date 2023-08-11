<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R;?>libs/colorpicker/color.js"></script>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>

        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">收件人</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" name="usernames" id="title" maxlength="80" class="form-control" value="<?php echo $r['title'];?>" placeholder="多个收件人用逗号隔开"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">内容</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="content" class="form-control" rows="10"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>

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