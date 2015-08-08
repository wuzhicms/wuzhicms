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
                <label class="col-sm-2 col-xs-4 control-label">公告名称</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <input type="text" name="form[title]" id="title" maxlength="80" class="form-control" value="<?php echo $r['title'];?>"/><span class="input-group-btn"><input type="hidden" id="title_css" name="title_css" value=""><img id="title_color" src="<?php echo R;?>js/colorpicker/picker.png" height="30" hx="#c00"></span><span class="input-group-btn"><input type="hidden" name="font_weight" id="font_weight" value=""><button class="btn btn-white" type="button" onclick="change_fontweight();"><strong>B</strong></button></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">公告群体</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <label class="radio-inline"> <input type="radio" name="form[status]" value="1" checked> 注册会员</label>
                    <label class="radio-inline"> <input type="radio" name="form[status]" value="2" > 会员+游客</label>
                    <label class="radio-inline"> <input type="radio" name="form[status]" value="3" disabled> 后台管理员</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">公告结束时间</label>
                <div class="col-lg-1 col-sm-2 col-xs-1 input-group">
                    <?php echo WUZHI_form::calendar('endtime',$endtime,1);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">公告内容</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <?php echo WUZHI_form::editor('form[content]','content');?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">公告备注（管理员可见）</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <textarea name="form[note]" class="form-control" cols="60" rows="3"></textarea>                </div>
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

