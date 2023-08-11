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
                        <th class="hidden-phone tablehead">索引</th>
                        <th class="tablehead">模板id</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">缩略图</th>
                        <th class="tablehead">备注</th>
                        <th class="tablehead">管理操作</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['configid'];?></td>
                            <td><?php echo $r['custom_id'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php if($r['thumb']) echo "<img src='".$r['thumb']."' style='max-height:60px;max-width:300px;'>";?></td>
                            <td><?php echo $r['note'];?></td>


                            <td>
                                <a href="?m=core&f=layout&v=edit&configid=<?php echo $r['configid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                                <a href="javascript:makedo('?m=core&f=layout&v=delete_config&configid=<?php echo $r['configid'];?><?php echo $this->su();?>', '确认删除该组件模板吗？删除后，布局中的组件不会删除')"
                                   class="btn btn-danger btn-sm btn-xs">删除</a>
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

                            <div class="pull-right">
                                <ul class="pagination pagination-sm">
                                    <?php echo $pages;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</div>
<!-- page end-->
</section>
<script type="text/javascript">
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<?php include $this->template('footer','core');?>

