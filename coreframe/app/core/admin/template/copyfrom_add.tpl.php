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
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">来源名称 <font color="red">＊</font></label>
                <div class="col-3">
                    <input type="text" class="form-control" name="form[name]" color="#000000" datatype="*2-30" errormsg="至少2个字符,最多20个字符！">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">链接地址</label>
                <div class="col-3">
                    <input type="text" class="form-control" name="form[url]" color="#000000">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">logo</label>
                <div class="col-3">
                    <div class="upload-picture-card"><?php echo WUZHI_form::attachment('','1','form[logo]','');?></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">备注</label>
                <div class="col-3">
                    <textarea class="form-control" name="form[remark]" id="remark" cols="80" rows="5"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-3">
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
