<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="bg-white">
<style type="text/css">
    .Validform_checktip{right: 40px;}
    .ms-btn{margin-left: 5.1rem;}
</style>
<section class="wrapper p-0">
    <!-- page start-->
    <section class="panel">
        <div class="panel-body pt-4">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="mb-3 row">
                    <label class="col-2 control-label col-form-label">风格名称</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="name" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！" value="<?php echo $data['name'];?>"></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-2 control-label col-form-label">css地址</label>
                    <div class="col-10">
                        <input type="text" name="remark" class="form-control" value="<?php echo $data['remark'];?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-10 ms-btn">
                       <input type="hidden" name="v" value="edit">
                       <input type="hidden" name="keyid" value="<?php echo $keyid;?>">
                        <input class="btn btn-info w-100" type="submit" name="submit" value="更新">
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

