<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">


            <section class="panel">
                <div class="panel-body">
                <form class="form-horizontal tasi-form" method="post" action="">

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-3 control-label">名称</label>
                        <div class="col-lg-7 col-sm-7 col-xs-7 input-group">
                            <input type="text" class="form-control" name="name" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！" value="<?php echo $data['name'];?>"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-3 control-label">备注</label>
                        <div class="col-lg-7 col-sm-7 col-xs-7 input-group">
                            <textarea name="remark" class="form-control" cols="60" rows="3"><?php echo $data['remark'];?></textarea>                </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label"></label>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                           <input type="hidden" name="v" value="edit">
                           <input type="hidden" name="keyid" value="<?php echo $keyid;?>">
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="更新">
                        </div>
                    </div>
                </form>
</div>

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
</body>
</html>