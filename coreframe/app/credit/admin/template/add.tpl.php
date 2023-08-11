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
                    <label class="col-sm-2 col-xs-4 control-label text-end">用户名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="username">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 control-label text-end">操作类型</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="plus_minus" id="plus_minus1" value="1">
                            <label class="form-check-label" for="plus_minus1">增加</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="plus_minus" id="plus_minus2" value="-1">
                            <label class="form-check-label" for="plus_minus2">减少</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 control-label text-end">积分数量</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="point" value="" placeholder="正整数">
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 control-label text-end">备注</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="note" class="form-control" cols="60" rows="3"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 control-label text-end"></label>
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


