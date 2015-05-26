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
    <header class="panel-heading">
        <span>区块：<?php echo $rs['name'];?>，列表内容修改</span>
    </header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group">
                <label class="col-sm-2 control-label">标题 <font color="red">＊</font></label>
                <div class="col-sm-4 input-group">
                    <input type="text" class="form-control" name="form[title]" value="<?php echo $r['title'];?>" datatype="*" errormsg="标题不能为空">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">缩略图</label>
                <div class="col-sm-4 input-group">
                    <div class="input-group"><?php echo $form->attachment('','1','form[thumb]',$r['thumb']);?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">链接地址</label>
                <div class="col-sm-4 input-group">
                    <input type="text" class="form-control" name="form[url]" value="<?php echo $r['url'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">描述</label>
                <div class="col-sm-8 input-group">
                    <textarea name="form[remark]" style="width: 100%;height: 80px;"><?php echo p_htmlentities($r['remark']);?></textarea>
                </div>
            </div>
            <?php if($attach) {
                foreach($attach as $field=>$value) {
            ?>

            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $field;?></label>
                <div class="col-sm-8 input-group">
                    <textarea name="attform[<?php echo $field;?>]" style="width: 100%;height: 80px;"><?php echo p_htmlentities($value);?></textarea>
                </div>
            </div>
                <?php
                }
            }
            ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-10 input-group">
                    <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
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
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
</script>

