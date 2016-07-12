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
            <header class="panel-heading"><span>发票申请管理</span></header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">申请时间</th>
                        <th class="hidden-phone tablehead">姓名</th>
                        <th class="tablehead">抬头</th>
                        <th class="tablehead">电话</th>
                        <th class="tablehead">地址</th>
                        <th class="tablehead">邮编</th>
                        <th class="tablehead">申请人</th>
                        <th class="tablehead">金额</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member',array('uid'=>$r['uid']));
                        $tr = $this->db->get_one('order_goods',array('orderid'=>$r['orderid'],'uid'=>$r['uid']));
                        ?>
                        <tr>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $r['linkman'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['tel'];?></td>
                            <td><?php echo $r['address'];?></td>
                            <td><?php echo $r['zip'];?></td>
                            <td><?php echo $mr['username'];?></td>
                            <td><?php echo $tr['money'];?></td>
                            <td><?php echo $status_arr[$r['status']];?></td>
                            <td><?php if($r['status']) {
?><a href="?m=receipt&f=receipt&v=check&status=0&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-default btn-xs">设为未开</a>
                                <?php
                                } else {
?> <a href="?m=receipt&f=receipt&v=check&status=1&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">设为已开</a>
                                <?php
                                }
                                ?>

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