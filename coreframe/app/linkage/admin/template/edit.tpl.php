<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <table class="table table-striped table-advance table-hover">
            <thead>
            <tr>
                <th class="hidden-phone tablehead">修改联动菜单</th>
            </tr>
            </thead>
        </table>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">菜单名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[name]" color="#000000" datatype="s2-30" errormsg="别名至少2个字符,最多30个字符！" value="<?php echo $r['name'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">描述</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="form[remark]" class="form-control" cols="60" rows="3"><?php echo $r['remark'];?></textarea>                </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">层级数</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo $form->select(array(1=>'1',2=>'2',3=>'3',4=>'4','5'=>'5'),$r['level'],"name='form[level]' class='form-select'");?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">显示风格</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <select name="form[display_type]" class="form-select" onchange="$('.demo').addClass('hide');$('#demo'+this.value).removeClass('hide');">
                            <option value="1" <?php if($r['display_type']==1) echo 'selected';?>>select 选项框</option>
                            <!--<option value="3" <?php if($r['display_type']==3) echo 'selected';?>>列表下拉</option>-->
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">显示效果</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                    <img src="<?php echo R;?>images/demo/linkage1.png" id="demo1" class="demo <?php if($r['display_type']!=1) echo 'hide';?>">
                    <img src="<?php echo R;?>images/demo/linkage3.png" id="demo3" class="demo <?php if($r['display_type']!=3) echo 'hide';?>">
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
</script>
<?php include $this->template('footer','core');?>
