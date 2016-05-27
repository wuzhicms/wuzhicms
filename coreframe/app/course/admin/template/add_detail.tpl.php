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
        <?php echo $data['title'];?> >
        <?php echo $data2['title'];?>
    </header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label ">上课时间</label>
                <div class="col-lg-10 col-sm-10 col-xs-10 input-group">
                    <table class="time-pick">
                        <tr>
                            <td><input type="text" class="form-control" name="starttime" datatype="*" errormsg="请选择上课时间" nullmsg="请选择上课时间！" placeholder="上课时间"></td>
                            <td><input type="text" class="form-control" style="margin-left: 4px;" name="endtime" datatype="*" errormsg="请选择下课时间" nullmsg="请选择下课时间！" placeholder="下课时间"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label ">上课日期</label>
                <div class="col-lg-10 col-sm-10 col-xs-10 input-group">
                    <table>
                        <tr>
                            <td><?php echo WUZHI_form::calendar('startdate','',0,0,0,'placeholder="开始日期"');?></td>
                            <td><?php echo WUZHI_form::calendar('enddate','',0,0,0,'placeholder="截止日期,可留空"');?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">排课规则</label>
                <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                    <label class="radio-inline"> <input type="radio" name="type" value="1" checked> 每周</label>
                    <label class="radio-inline"> <input type="radio" name="type" value="2" > 单周有课</label>
                    <label class="radio-inline"> <input type="radio" name="type" value="3" > 双周有课</label>
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

