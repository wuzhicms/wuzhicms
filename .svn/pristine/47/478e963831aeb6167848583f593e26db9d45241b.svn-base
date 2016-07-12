<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="hidden-phone tablehead">修改来源</th>
        </tr>
        </thead>
    </table>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">来源名称 <font color="red">＊</font></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[name]" color="#000000" value="<?php echo $r['name'];?>" datatype="*2-30" errormsg="至少2个字符,最多20个字符！">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">链接地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[url]" color="#000000" value="<?php echo $r['url'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">logo</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo WUZHI_form::attachment('','1','form[logo]',$r['logo']);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">备注</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea class="form-control" name="form[remark]" id="remark" cols="80" rows="5"><?php echo $r['remark'];?></textarea>
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
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
</script>

