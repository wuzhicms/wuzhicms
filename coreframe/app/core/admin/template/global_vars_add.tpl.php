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
                <label class="col-sm-2 col-xs-4 control-label">变量含义</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="title" datatype="s2-80" errormsg="至少2个字符,最多80个字符！">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">变量名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="var" datatype="s2-80" errormsg="至少2个字符,最多80个字符！" placeholder="英文数字组合">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">变量值</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="data" datatype="*1-255" errormsg="至少1个字符,最多255个字符！">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
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

