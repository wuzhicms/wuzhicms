<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">菜单名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[name]" color="#000000" datatype="s2-30" errormsg="别名至少2个字符,最多30个字符！">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">描述</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea name="form[remark]" class="form-control" cols="60" rows="3"></textarea>                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">层级数</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
<?php echo $form->select(array(1=>'1',2=>'2',3=>'3',4=>'4','5'=>'5'),1,"name='form[level]' class='form-control'");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">显示风格</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
      <select name="form[display_type]" class="form-control" onchange="javascript:$('.demo').addClass('hide');$('#demo'+this.value).removeClass('hide');">
          <option value="1">select 选项框</option>
         <!-- <option value="3">列表下拉</option>-->
      </select>                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">显示效果</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                <img src="<?php echo R;?>images/demo/linkage1.png" id="demo1" class="demo">
                <img src="<?php echo R;?>images/demo/linkage3.png" id="demo3" class="demo hide">
                </div>
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

</script>

