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
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="hidden-phone tablehead">说明</th>
                        <th class="tablehead">用户</th>
                        <th class="tablehead">消耗/增加</th>
                        <th class="tablehead">积分数</th>
                        <th class="tablehead">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member', array('uid' => $r['uid']));
                        ?>
                        <tr>
                            <td><?php echo $r['jid'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td title="真实姓名：<?php echo $mr['truename'];?>"><?php echo $mr['username'];?></td>
                            <td><?php if($r['j_type']==1) {echo '增加';} else {echo '<font color="#f37800">消耗</font>';}?></td>
                            <td><?php echo $r['point'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>


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