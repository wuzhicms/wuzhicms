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

                <div class="panel-body" id="formid">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">卡号</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="pre" value="<?php echo $r['card_no'];?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="mobile" value="" placeholder="手机或邮箱需要填写一项" datatype="m" errormsg="请填写正确的手机号码" ignore="ignore">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="email" name="email" value="" placeholder="留空不发送" datatype="e" errormsg="请填写正确的邮箱地址" ignore="ignore">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注（管理员可见）</label>
                            <div class="col-sm-4">
                                <textarea name="note" class="form-control" cols="60" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input name="forward" value="<?php echo HTTP_REFERER;?>" type="hidden">
                                <input class="btn btn-info" id="submit" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>

            </section>
        </div>

    </div>
    <!-- page end--><div class="alert alert-success fade in hide" id="success">
        <strong>生成成功:</strong> <a href="http://www.h1jk.cn/index.php?m=order&f=card&v=listing<?php echo $this->su();?>"> 点击这里返回列表</a>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        var formjs = $(".form-horizontal").Validform({
            tiptype:1,
            postonce:true,
            beforeSubmit:function(curform){

            }
        });
        //formjs.ignore("#email");
    })

</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

