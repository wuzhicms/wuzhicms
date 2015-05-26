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
                <label class="col-sm-2 control-label">所属角色</label>
                <div class="col-sm-4 input-group">
                    <?php
                    echo $form->select(key_value($roles,'role','name'), $r['role'], 'name="form[role]" class="form-control"');
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">管理员账号</label>
                <div class="col-sm-4 input-group">
                    <input type="text" class="form-control" name="form[username]" color="#000000" value="<?php echo $username;?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">密码</label>
                <div class="col-sm-4 input-group">
                    <input type="text" class="form-control" name="form[password]" value="" title="" placeholder="留空，则使用前台密码">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">真实姓名</label>
                <div class="col-sm-4 input-group">
                    <input type="text" class="form-control" name="form[truename]" value="<?php echo $r['truename'];?>" color="#000000" datatype="s2-30" errormsg="至少2个字符,最多20个字符！">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10 input-group">
                    <input class="btn btn-info" type="submit" name="submit" value="提交">
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

