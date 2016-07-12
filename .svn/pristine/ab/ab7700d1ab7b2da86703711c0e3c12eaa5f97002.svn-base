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
                            <label class="col-sm-2 col-xs-4 control-label">所属城市</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php
                                echo $form->tree_select($categorys, $pid, 'name="cityid" class="form-control"', '≡ 全国 ≡');
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">用户名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="username" value="" datatype="s2-20" errormsg="请输入2-20个字符">
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
    <!-- page end--><div class="alert alert-success fade in hide" id="success">
        <strong>生成成功:</strong> <a href="<?php echo WEBURL;?>/index.php?m=order&f=card&v=listing<?php echo $this->su();?>"> 点击这里返回列表</a>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1,
            postonce:true,
            beforeSubmit:function(curform){

            }
        });
    })

</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

