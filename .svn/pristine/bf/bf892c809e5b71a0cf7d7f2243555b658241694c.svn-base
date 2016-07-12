<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel tasks-widget">
                <header class="panel-heading">
                    <span>批量移动</span>
                </header>
                <form name="form1" method="post" action="?m=content&f=content&v=move<?php echo $this->su();?>">

                <div class="panel-body" id="panel-bodys">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="tablehead center">文章id</th>
                            <th class="tablehead center">目标栏目(<?php echo $modelname;?>)</th>

                        </tr>
                        </thead>
                        <tr>
                        <td><div class="col-lg-12 col-sm-12"><textarea name="ids" class="form-control" rows="14"><?php echo $ids;?></textarea></div></td>
                        <td><div class="col-lg-12 col-sm-12"><?php
                            echo $form->tree_select($categorys, 0, 'name="cid" style="height:260px;" class="form-control" size=2', '≡ 请选择栏目 ≡');

                            ?></div></td>
                        </tr>
                        <tr><td colspan="2" class="text-center">
                                <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                                <button type="submit" class="btn btn-primary"><i class=" icon-angle-double-right btn-icon"></i>批量移动</button></td></tr>
                        </table>
                </div>
            </form>
            </section>
        </div>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    window.scrollTo(0,0);
</script>
</body>
</html>