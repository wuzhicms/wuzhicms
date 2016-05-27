<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>js/colorpicker/style.css" rel="stylesheet">
<link href="<?php echo R;?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo R;?>js/colorpicker/color.js"></script>
<script src="<?php echo R;?>js/jquery-timepick.js"></script>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid'],'&id='.$id);?>
    <header class="panel-heading">
        <a href="<?php echo $data['url'];?>" target="_blank"><?php echo $data['title'];?></a>
    </header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">课程名</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[title]" id="title" maxlength="80" class="form-control" value="<?php echo $r['title'];?>" datatype="*" errormsg="请填写课程名" nullmsg="请填写课程名"/><span class="input-group-btn"><input type="hidden" id="title_css" name="title_css" value=""><img id="title_color" src="<?php echo R;?>js/colorpicker/picker.png" height="30" hx="#c00"></span><span class="input-group-btn"><input type="hidden" name="font_weight" id="font_weight" value=""></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">课程名—英文</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[title_en]" maxlength="80" class="form-control" value="" datatype="*" errormsg="请填写课程名—英文" nullmsg="请填写课程名—英文！"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">教室</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[classroom]" maxlength="80" class="form-control" value="" datatype="*" errormsg="请填写所在教室" nullmsg="请填写所在教室！"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">教室—英文</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[classroom_en]" maxlength="80" class="form-control" value="" datatype="*" errormsg="请填写所在教室—英文" nullmsg="请填写所在教室—英文！"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">讲师</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[teacher]" maxlength="80" class="form-control" value="" datatype="*" errormsg="请填写讲师" nullmsg="请填写讲师！"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">讲师—英文</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[teacher_en]" maxlength="80" class="form-control" value="" datatype="*" errormsg="请填写讲师—英文" nullmsg="请填写讲师—英文！"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
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
            tiptype:1
        });
        $('.time-pick input').timepick();
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

