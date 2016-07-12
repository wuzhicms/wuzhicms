<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <form name="myform" method="post" action="?m=content&f=category&v=sort<?php echo $this->su();?>">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <?php echo $this->menu($GLOBALS['_menuid'],'','<a href="javascript:repair();" class="btn btn-default btn-sm" id="category-add"><i class="icon-wrench btn-icon"></i>修复栏目</a>');?>
                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">排序</th>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">所属站点</th>
                                <th class="tablehead">栏目名称</th>
                                <th class="tablehead">类型</th>
                                <th class="tablehead">所属模型</th>
                                <th class="tablehead">访问</th>
                                <th class="tablehead" style="width: 200px;">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo $tree_data;
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pull-left">
                                        <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                                </div>
                                <div class="pull-right">
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </form>
    <!-- page end-->
</section>
<script src="<?php echo R;?>js/jquery.min.js"></script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    function repair() {
        $.get("?m=content&f=category&v=repair<?php echo $this->su();?>",
            function(data){
                var d = dialog({
                    content: data
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
            });

    }
</script>
</body>
</html>
