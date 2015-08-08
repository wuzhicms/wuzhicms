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
                            <label class="col-sm-2 control-label">公告名称</label>
                            <div class="col-sm-8 input-group">
                                <input type="text" style="<?php echo $r['css'];?>" name="form[title]" id="title" maxlength="80" value="<?php echo $r['title'];?>" class="form-control" value="<?php echo $r['title'];?>"/><span class="input-group-btn"><input type="hidden" id="title_css" name="title_css" value="<?php echo $color;?>"><img id="title_color" src="<?php echo R;?>js/colorpicker/picker.png" height="30" hx="#c00"></span><span class="input-group-btn"><input type="hidden" name="font_weight" id="font_weight" value="<?php echo $font_weight;?>"><button class="btn btn-white" type="button" onclick="change_fontweight();"><strong>B</strong></button></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公告群体</label>
                            <div class="col-sm-8 input-group">
                                <label style="width: 100px;"> <input type="radio" name="form[status]" value="1" <?php if($r['status']==1) echo 'checked';?>> 注册会员</label>
                                <label style="width: 100px;"> <input type="radio" name="form[status]" value="2" <?php if($r['status']==2) echo 'checked';?>> 会员+游客</label>
                                <label style="width: 100px;"> <input type="radio" name="form[status]" value="3" <?php if($r['status']==3) echo 'checked';?> disabled> 后台管理员</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公告结束时间</label>
                            <div class="col-sm-2 input-group">
                                <?php echo WUZHI_form::calendar('endtime',$endtime,1);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">公告内容</label>
                            <div class="col-sm-9 input-group">
                                <?php echo WUZHI_form::editor('form[content]','content',$r['content']);?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">公告备注（管理员可见）</label>
                            <div class="col-sm-9 input-group">
                                <textarea name="form[note]" class="form-control" cols="60" rows="3"><?php echo $r['note'];?></textarea>                </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
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

