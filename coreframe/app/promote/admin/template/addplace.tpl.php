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
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">广告名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[name]" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！"></div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">宽</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[width]" datatype="n" errormsg="请填写正确的数字" placeholder="填写数字，0为不限"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">高</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[height]" datatype="n" errormsg="请填写正确的数字" placeholder="填写数字，0为不限"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">自定义索引</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[keyid]" placeholder="可以为数字、字母" ></div>
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