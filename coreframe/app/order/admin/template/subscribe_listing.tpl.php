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
                        <th class="hidden-phone tablehead">预约人</th>
                        <th class="hidden-phone tablehead">预约卡号</th>
                        <th class="tablehead">预约机构</th>
                        <th class="tablehead">体检时间</th>
                        <th class="tablehead">提交时间</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">设为已体检</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member', array('uid' => $r['uid']));
                        $mecr = $this->db->get_one('mec', array('id' => $r['mecid']));
                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo "<a href='javascript:view(".$mr['uid'].");'>".$mr['truename'];?></a></td>
                            <td><?php echo $r['card_no'];?></td>
                            <td><?php echo $mecr['title'];?></td>
                            <td><?php echo $r['tjtime'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php if($r['status']==1) {echo '<font color="red">待体检</font>';} elseif($r['status']==2) {echo '<font color="green">已体检</font>';}elseif($r['status']==6) {echo '<a href="?m=order&f=subscribe&v=confirm&id='.$r['id'].$this->su().'"><font color="green">点击确认</font></a>';} elseif($r['status']==7) {echo '已点评';} else {echo '已取消';}?></td>
                            <td><?php if($r['status']==1) {echo '<a href="?m=order&f=subscribe&v=setstatus&status=2&id='.$r['id'].$this->su().'"><font color="green">设为已体检</font></a>';}?></td>

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
    function view(userid){
        top.openiframe('index.php?m=member&f=index&v=view&uid='+userid+'<?php echo $this->su();?>', 'view', '查看用户信息', 660, 260);
    }

    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>