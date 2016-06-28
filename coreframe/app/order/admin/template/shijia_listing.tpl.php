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
            <?php
            if($id) {
            ?>
            <header class="panel-heading">
                 <span class="dropdown addcontent">
    <a href="javascript:window.history.go(-1);" class="btn btn-info btn-sm">返回上级</a>
                 </span>
            </header>
            <?php }?>
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">活动名称</th>
                        <th class="tablehead">姓名</th>
                        <th class="tablehead">电话</th>
                        <th class="tablehead">试驾城市</th>
                        <th class="tablehead">提交时间</th>
                        <th class="tablehead">提交人</th>
                        <th class="tablehead">ip</th>
                        <th class="tablehead">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $cr = $this->db->get_one('sjhd', array('id' => $r['id']));
                        ?>
                        <tr>
                            <td><?php echo $r['did'];?></td>
                            <td><?php echo $cr['title'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $r['cityname'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php echo $r['publisher'];?></td>
                            <td><?php echo $r['ip'];?></td>
                            <td><a href="javascript:makedo('?m=order&f=shijia&v=delete&did=<?php echo $r['did'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a></td>
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
    function view(userid){
        top.openiframe('index.php?m=member&f=index&v=view&uid='+userid+'<?php echo $this->su();?>', 'view', '查看用户信息', 660, 260);
    }

    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>