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
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">批次号</th>
                        <th class="tablehead">优惠券名</th>
                        <th class="tablehead">面值</th>
                        <th class="tablehead">过期时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr title="生成人：<?php echo $r['adminname'];?> &#10;生成时间：<?php echo time_format($r['addtime']);?>">
                            <td><?php echo $r['groupname'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['mount'];?></td>
                            <td><?php echo date('Y-m-d',$r['endtime']);?></td>
                            <td>
                                <a href="?m=coupon&f=card&v=bind_select_content&groupname=<?php echo $r['groupname'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">绑定套餐</a>
<!--                                <a href="?m=coupon&f=card&v=bind&groupname=--><?php //echo $r['groupname'];?><!----><?php //echo $this->su();?><!--" class="btn btn-primary btn-xs">套餐列表</a>-->
                                <a href="?m=coupon&f=card&v=detail_listing&groupname=<?php echo $r['groupname'];?><?php echo $this->su();?>" class="btn btn-default btn-xs">优惠券列表</a>
                                <a href="?m=coupon&f=card&v=add&groupname=<?php echo $r['groupname'];?><?php echo $this->su();?>" class="btn btn-default btn-xs"><i class="icon-plus btn-icon"></i>新增该批次优惠券</a>

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
            </form>
        </section>
        </form>
    </div>
</div>
<!-- page end-->
</section>
<script type="text/javascript">
    function send_goods(id,username){
        top.openiframe('index.php?m=order&f=index&v=send_goods&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 450);
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