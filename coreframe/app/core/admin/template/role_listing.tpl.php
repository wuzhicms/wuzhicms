<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
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
                        <th class="tablehead">角色名称</th>
                        <th class="tablehead">描述</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['role'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['remark'];?></td>

                            <td>
                                <?php if($r['role']!=1){?><a href="?m=core&f=power&v=private_set&role=<?php echo $r['role'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs" title="菜单访问权限">权限设置</a>
                                    <a href="?m=content&f=category&v=private_set&role=<?php echo $r['role'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs" title="内容模块：栏目内容管理权限设置">内容管理权限</a>
                                <?php }?>
                                <a href="?m=core&f=power&v=role_edit&role=<?php echo $r['role'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <?php if($r['role']!=1) {?>
                                <a href="?m=core&f=power&v=role_delete&role=<?php echo $r['role'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">删除</a>
                            <?php } else {?>
<button class="btn btn-default btn-xs">删除</button>
                                <?php }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>



                    </tbody>
                </table>
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