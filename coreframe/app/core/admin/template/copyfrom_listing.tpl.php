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
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">链接地址</th>
                        <th class="tablehead">logo</th>
                        <th class="tablehead">使用次数</th>
                        <th class="tablehead">最新使用时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['fromid'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['url'];?></td>
                            <td><?php echo $r['logo'];?></td>
                            <td><?php echo $r['usetimes'];?></td>
                            <td><?php echo $r['updatetime'];?></td>
                            <td>
                                <a href="?m=core&f=copyfrom&v=edit&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=core&f=copyfrom&v=delete&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php if($total>20) {?>
                <div class="panel-body">
                    <div>
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
                <?php }?>
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