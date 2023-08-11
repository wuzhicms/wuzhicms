<?php
    /**
     * 单位列表页模板
     */
    defined('IN_WZ') or exit('No direct script access allowed');
    include $this->template('header', 'core');
?>
<body>
    <section class="wrapper">
        <!-- page start-->
        <form name="myform" method="post" action="?m=member&f=org&v=sort<?php echo $this->su(); ?>">
            <section class="panel">
                        <?php echo $this->menu($GLOBALS['_menuid']); ?>
                        <div class="panel-body" id="panel-bodys">
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="tablehead">排序</th>
                                        <th class="tablehead">ID</th>
                                        <th class="tablehead">所属站点</th>
                                        <th class="tablehead w-50">单位名称</th>
                                        <th class="tablehead">状态</th>
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
    <?php include $this->template('footer', 'core'); ?>