<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <!-- page start-->
    <form name="myform" method="post" action="?m=mobile&f=index&v=edit_category<?php echo $this->su();?>">
        <div class="row">
            <div class="col-lg-12">

                <section class="panel">
                    <?php echo $this->menu($GLOBALS['_menuid'],'','');?>
                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">栏目名称</th>
                                <th class="tablehead">手机栏目名称</th>
                                <th class="tablehead">手机导航显示</th>
                                <th class="tablehead">所属模型</th>
                                <th class="tablehead">访问</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo $tree_data;
                            ?>
                            </tbody>
                        </table>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left"> <button type="submit" name="submit" class="btn btn-info btn-sm">提交</button></div>
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
