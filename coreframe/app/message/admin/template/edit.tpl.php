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
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">公告名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" style="<?php echo $r['css'];?>" name="form[title]" id="title" maxlength="80" value="<?php echo $r['title'];?>" class="form-control" value="<?php echo $r['title'];?>"/><span class="input-group-btn"><input type="hidden" id="title_css" name="title_css" value="<?php echo $color;?>"><img id="title_color" src="<?php echo R;?>libs/colorpicker/picker.png" height="30" hx="#c00"></span><span class="input-group-btn"><input type="hidden" name="font_weight" id="font_weight" value="<?php echo $font_weight;?>"><button class="btn btn-white" type="button" onclick="change_fontweight();"><strong>B</strong></button></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">公告群体</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <label style="width: 100px;"> <input type="radio" name="form[status]" value="1" <?php if($r['status']==1) echo 'checked';?>> 注册会员</label>
                        <label style="width: 100px;"> <input type="radio" name="form[status]" value="2" <?php if($r['status']==2) echo 'checked';?>> 会员+游客</label>
                        <label style="width: 100px;"> <input type="radio" name="form[status]" value="3" <?php if($r['status']==3) echo 'checked';?> disabled> 后台管理员</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">公告结束时间</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo WUZHI_form::calendar('endtime',$endtime,1);?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">公告内容</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo WUZHI_form::editor('form[content]','content',$r['content']);?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">公告备注（管理员可见）</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="form[note]" class="form-control" cols="60" rows="3"><?php echo $r['note'];?></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info" type="submit" name="submit" value="提交">
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

