<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<style type="text/css">
    .Validform_checktip{right: 40px;}
    .ms-btn{margin-left: 5.1rem;}
</style>
<body class="bg-white">
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label text-end">名称</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="name" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！" value="<?php echo $data['name'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label text-end">备注</label>
                    <div class="col-10">
                        <textarea name="remark" class="form-control" cols="60" rows="3"><?php echo $data['remark'];?></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label text-end"></label>
                    <div class="col-10">
                        <input type="hidden" name="v" value="edit">
                        <input type="hidden" name="keyid" value="<?php echo $keyid;?>">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="更新">
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