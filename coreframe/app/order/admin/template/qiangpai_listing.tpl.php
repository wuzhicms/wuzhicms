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
    <a href="?m=content&f=content&v=listing&cid=<?php echo $cid.$this->su();?>" class="btn btn-info btn-sm">返回上级</a>
    <a href="<?php echo $data_r['url'];?>" class="btn btn-primary btn-sm" target="_blank"><?php echo $data_r['title'];?></a>
                 </span>
            </header>
            <?php }?>
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">订单号</th>
                        <th class="hidden-phone tablehead">时间</th>
                        <th class="tablehead">用户名</th>
                        <th class="tablehead">收件人</th>
                        <th class="tablehead">电话</th>
                        <th class="tablehead">收件人地址</th>
                        <th class="tablehead">是否中奖</th>
                        <th class="tablehead">中奖方式</th>
                        <th class="tablehead">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $addressid_r = $this->db->get_one('express_address', array('addressid' => $r['addressid']));
                        $qwr = $this->db->get_one('qiangpai_winner', array('payid' => $r['id']));
                        ?>
                        <tr>
                            <td><?php echo $r['order_no'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo $addressid_r['addressee'];?></td>
                            <td><?php echo $addressid_r['mobile'];?></td>
                            <td><?php echo $addressid_r['province'].$addressid_r['city'].$addressid_r['area'].$addressid_r['address'];?></td>
                            <td><?php if($qwr) {echo '<span class="btn btn-danger btn-xs">中奖</span>';} else {echo '<a href="javascript:makedo(\'?m=order&f=qiangpai&v=set_winner&id='.$id.'&cid='.$cid.'&payid='.$r['id'].$this->su().'\', \'确认要设置'.$r['username'].'为中奖人吗？\')" class="btn btn-default btn-xs">设置为中奖</a>';}?></td>
                            <td><?php if($qwr['draw_method']==1) {echo '系统抽取';}else{echo '<span class="btn btn-primary btn-xs">人工设置</span>';}?></td>
                            <td>
                                <?php
                                if($qwr) {
                                ?>
                                <a href="javascript:makedo('?m=order&f=qiangpai&v=delete_winner&winnerid=<?php echo $qwr['winnerid'];?>&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>', '确认要删除奖励？')"
                                    class="btn btn-danger btn-xs">删除奖励</a>
                            <?php }?>
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
                            <div class="pull-left">
                                <?php
                                if($data_r['cron_status']==1) {
                                ?>
                                <a href="?m=order&f=qiangpai&v=publish&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>" class="btn btn-danger btn-sm">立即发布 抽奖结果</a>
<?php } elseif($data_r['cron_status']==2) {?>
                                    <button class="btn btn-warning" disabled>抽奖结果已发布</button>
                                <?php } else {?>
                                    <button class="btn btn-primary" disabled>活动截止时间:<?php echo date('Y-m-d H:i',$data_r['endtime']);?></button>
                                <?php }?>
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