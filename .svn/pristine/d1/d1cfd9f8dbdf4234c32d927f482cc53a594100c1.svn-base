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
                        <th class="hidden-phone tablehead">物流名称</th>
                        <th class="tablehead">网址</th>
                        <th class="tablehead">缩略图</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['eid'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['url'];?></td>
                            <td><img src="<?php echo $r['thumb'];?>" style="max-height: 100px;max-width: 100px;"></td>
                            <td>

                                <a href="?m=order&f=express&v=edit&id=<?php echo $r['eid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=order&f=express&v=delete&id=<?php echo $r['eid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
<script type="text/javascript">
    function send_goods(id,username){
        top.openiframe('index.php?m=order&f=index&v=send_goods&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 430);
    }
    function view(id,username){
        top.openiframe('index.php?m=order&f=index&v=view&orderid='+id+'<?php echo $this->su();?>', 'view', '查看"'+username+'"的订单', 660, 260);
    }

    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>