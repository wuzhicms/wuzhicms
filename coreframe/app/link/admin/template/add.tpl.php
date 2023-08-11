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
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">所属类别</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php
                        echo $form->select($options, 1, 'name="form[kid]" class="form-select"');
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">链接名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[sitename]" datatype="s2-60" errormsg="别名至少2个字符,最多60个字符！"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">链接地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[url]" datatype="url" errormsg="请填写正确的网址"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">logo</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="upload-picture-card"><?php echo $form->attachment('','1','form[logo]','');?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">备注</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="form[remark]" class="form-control" cols="60" rows="3"></textarea>
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
