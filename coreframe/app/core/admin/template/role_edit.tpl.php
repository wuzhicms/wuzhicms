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
            <th class="hidden-phone tablehead">修改角色</th>
        </tr>
        </thead>
    </table>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">角色名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[name]" value="<?php echo $r['name'];?>" color="#000000" datatype="s2-30" errormsg="别名至少2个字符,最多30个字符！">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">角色描述</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea name="form[remark]" class="form-control" cols="60" rows="3"><?php echo $r['remark'];?></textarea>                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
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

