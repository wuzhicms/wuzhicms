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
                        <th class="tablehead">ID</th>
                        <th class="tablehead">配置名称</th>
                        <th class="tablehead">备注</th>
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
                               <!---排序--->
                            <td><?php echo $r['dcid'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>

                            <td>

                                <a href="?m=data_convert&f=index&v=config_field&dcid=<?php echo $r['dcid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">配置字段</a>
								<a href="?m=data_convert&f=index&v=convert&dcid=<?php echo $r['dcid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">开始转化</a>
                                <a href="javascript:makedo('?m=link&f=index&v=delete&linkid=<?php echo $r['linkid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>
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