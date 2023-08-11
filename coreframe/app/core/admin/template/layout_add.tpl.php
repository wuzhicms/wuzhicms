<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R;?>libs/colorpicker/color.js"></script>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">组件名称</label>
                <div class="col-lg-6 col-sm-6 col-xs-6 input-group">
                    <input type="text" name="form[title]" id="title" maxlength="80" class="form-control" value="<?php echo $r['title'];?>" datatype="*1-80" errormsg="请输入名称，不能超过80个字符"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">模板id</label>
                <div class="col-lg-3 col-sm-3 col-xs-3 input-group">
                    <input type="text" name="form[custom_id]" maxlength="30" class="form-control" value="<?php echo $r['custom_id'];?>" placeholder="必须唯一，且必须字母开头" datatype="/^[a-z0-9-]{3,30}$/i" errormsg="用户名为3-30位数字、字母、中划线组成，且必须字母开头" sucmsg="OK" ajaxurl="index.php?m=core&f=layout&v=check_custom_id<?php echo $this->su();?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">组件缩略图</label>
                <div class="col-lg-6 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo $form->attachment('','1','form[thumb]','','callback_thumb_dialog',0);?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">模板内容</label>
                <div class="col-lg-10 col-sm-10 col-xs-10 input-group">
                    <?php echo WUZHI_form::editor('form[templatedata]','templatedata','','basic');?>
                    <br>
                    <div class="alert alert-success fade in">
                        <strong>使用提示:</strong> 如果代码中含有特殊字体符号乱码：可以在源码模式下直接提交。
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">备注</label>
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
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })

</script>
<?php include $this->template('footer','core');?>

