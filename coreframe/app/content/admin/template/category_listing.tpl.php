<?php
    /**
     * 栏目列表页模板
     */
    defined('IN_WZ') or exit('No direct script access allowed');
    include $this->template('header', 'core');
?>
<body>
    <section class="wrapper">
        <!-- page start-->
        <form name="myform" method="post" action="?m=content&f=category&v=sort<?php echo $this->su(); ?>">
            <section class="panel">
                        <?php echo $this->menu($GLOBALS['_menuid'], '', '<a href="javascript:repair();" class="btn btn-default btn-sm" id="category-add"><i class="icon-wrench btn-icon"></i>修复栏目</a>'); ?>
                        <div class="panel-body" id="panel-bodys">
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="tablehead">排序</th>
                                        <th class="tablehead">ID</th>
                                        <th class="tablehead">所属站点</th>
                                        <th class="tablehead w-50">栏目名称</th>
                                        <th class="tablehead">类型</th>
                                        <th class="tablehead">所属模型</th>
                                        <th class="tablehead">访问</th>
                                        <th class="tablehead">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    echo $tree_data;
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="panel-foot">
                            <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                        </div>
                    </section>
        </form>
        <!-- page end-->
    </section>
    <script src="<?php echo R; ?>libs/jquery/jquery.min.js"></script>
    <script type="text/javascript">
        function repair() {
            $.get("?m=content&f=category&v=repair<?php echo $this->su(); ?>",
                function(data) {
                    var d = dialog({
                        content: data
                    });
                    d.show();
                    setTimeout(function() {
                        d.close().remove();
                    }, 2000);
                });

        }
    </script>
    <?php include $this->template('footer', 'core'); ?>