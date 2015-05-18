<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'linkage','f'=>'index','v'=>'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body class="body pxgrisbody">
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($submenuid,'&linkageid='.input('linkageid').'&pid='.$GLOBALS['pid']);?>
            <form action="?m=linkage&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">排序</th>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">描述</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {

                        ?>
                        <tr>
                            <td><input class="center" name="sorts[<?php echo $r['lid'];?>]" type="text" size="3" value="<?php echo $r['sort'];?>"></td>
                            <td><?php echo $r['lid'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td>
                                <a href="?m=linkage&f=index&v=item_listing&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">管理子选项</a>
                                <a href="?m=linkage&f=index&v=add_item&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-default btn-xs">添加子选项</a>
                                <a href="?m=linkage&f=index&v=edit_item&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $GLOBALS['pid'];?>&lid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=linkage&f=index&v=delete_item&lid=<?php echo $r['lid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>



                    </tbody>
                </table>

                <div class="panel-body">
                <div class="row">
                <div class="col-lg-12">
                    <div class="pull-left"> <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                    </div>
                    <div class="pull-right">
                        <ul class="pagination pagination-sm mr0">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
                </div>
                </div>
            </div>
            </form>
        </section>
    </div>

</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script>
    $(this).focus();
</script>
</body>
</html>