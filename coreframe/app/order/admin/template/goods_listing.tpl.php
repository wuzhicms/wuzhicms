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
            <header class="panel-heading">
                <form class="form-inline" role="form">
                    <input type="hidden" name="m" value="<?php echo M;?>" />
                    <input type="hidden" name="f" value="<?php echo F;?>" />
                    <input type="hidden" name="v" value="<?php echo V;?>" />
                    <input type="hidden" name="_su" value="<?php echo _SU;?>" />
                    <input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
                    <input type="hidden" name="search" />

                    <div class="input-group">
                        <select name="cardtype" class="form-control">
                            <option value="-1" <?php if($cardtype=='-1') echo 'selected';?>>全部类型</option>
                            <option value="1" <?php if($cardtype==1) echo 'selected';?>>实体卡</option>
                            <option value="0" <?php if($cardtype==0) echo 'selected';?>>虚拟卡</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <select name="keytype" class="form-control">
                            <option value="0" <?php if($keytype==0) echo 'selected';?>>订单ID</option>
                            <option value="1" <?php if($keytype==1) echo 'selected';?>>下单会员</option>
                        </select>
                    </div>
                    <input type="text" name="keywords" class="usernamekey" value="<?php echo $keywords?>"/>

                    <button type="submit" class="btn btn-sm btn-info">搜索</button>
                </form>
            </header>
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">订单ID</th>
                        <th class="tablehead" colspan="2" >名称</th>
                        <th class="tablehead">总价</th>
                        <th class="tablehead">提交时间/发货时间</th>
                        <th class="tablehead">下单会员</th>
                        <th class="tablehead">卡类别</th>
                        <th class="tablehead">预约卡</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($result)) {
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member',array('uid'=>$r['uid']));
                        ?>
                        <tr>
                            <td><?php echo $r['order_no'];?></td>
                            <td><a href="javascript:void(0)" onclick="view('<?php echo $r['orderid'];?>','<?php echo $mr['username'];?>')" ><img src="<?php echo $r['thumb'];?>" style="max-width: 50px;max-height: 50px;"></td>
                            <td style="max-width: 250px;"><?php
                                $coupon_card = 0;
                                foreach($r['goodlist'] as $rs) {

                                    $coupon_card += $rs['coupon_card'];
                                    echo '<a href="'.$rs['url'].'" target="_blank">'.safe_htm($rs['remark']).'</a> ('.$r['quantity'].')<br>';
                                }
                                ?></td>
                            <td><?php echo $r['money'];if($coupon_card) echo '<br>券：'.$coupon_card;?></td>
                            <td><?php echo time_format($r['addtime']);?> <br><?php echo time_format($r['post_time']);?></td>
                            <td><?php echo "<a href='javascript:view2(".$mr['uid'].");'>".$mr['username'];?></a></td>
                            <td><?php if($r['cardtype']) {echo '<font color="red">实物卡</font>';}else {echo '虚拟卡';};?></td>
                            <td><?php if($r['status']==1 || $r['status']==5 || $r['status']==6) {echo '<a href="?m=order&f=card&v=listing&batchid='.$r['order_no'].$this->su().'" target="_blank">查看</a>';};?></td>

                            <td>
                                <?php if($r['cardtype']==1 && $r['status']==1) {
                                    echo '<a href="javascript:void(0)" onclick="send_goods('.$r['orderid'].',\''.$mr['username'].'\')" class="btn btn-primary btn-xs">发货</a>';
                                } else {
                                    echo $status[$r['status']];
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }}
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
        top.openiframe('index.php?m=order&f=goods&v=send_goods&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 480);
    }
    function view(id,username){
        top.openiframe('index.php?m=order&f=goods&v=view&orderid='+id+'<?php echo $this->su();?>', 'view', '查看"'+username+'"的订单', 660, 260);
    }
    function view2(userid){
        top.openiframe('index.php?m=member&f=index&v=view&uid='+userid+'<?php echo $this->su();?>', 'view', '查看用户信息', 660, 260);
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>