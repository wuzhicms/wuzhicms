<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>

<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">


        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>

            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">变量含义</th>
                        <th class="tablehead">变量名</th>
                        <th class="tablehead">值</th>
                        <th class="tablehead">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['keyid'];?></td>
                            <td><?php echo $r['data'];?></td>
                            <td>
                                <a href="?m=core&f=set&v=edit_global_vars&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="?m=core&f=set&v=delete_global_vars&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="panel-body text-center">
                    <div>
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>