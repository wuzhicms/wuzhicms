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
            <form action="?m=link&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">

            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">排序</th>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">链接名称</th>
                        <th class="tablehead">备注</th>
                        <th class="tablehead">logo</th>
                        <th class="tablehead">添加人</th>
                        <th class="tablehead">添加时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {

                        ?>
                        <tr>

                            <td><input name="sorts[<?php echo $r['linkid'];?>]" type="text" class="center" style="padding:3px" value="<?php echo $r['sort'];?>" size="3"></td>
                            <td><?php echo $r['linkid'];?></td>
                            <td><?php echo '<a href="'.$r['url'].'" target="_blank">'.$r['sitename'];?></a></td>
                            <td><?php echo $r['remark'];?></td>
                            <td><?php if($r['logo']) echo '<img src="'.$r['logo'].'" style="max-height:35px;max-width:80px;">';?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>

                            <td>

                                <a href="?m=link&f=index&v=edit&linkid=<?php echo $r['linkid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=link&f=index&v=delete&linkid=<?php echo $r['linkid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
        </section>
        </form>

    </div>

</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>