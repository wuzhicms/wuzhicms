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
            <header class="panel-heading"><a href="?m=order&f=sign_up&v=listing<?php echo $this->su();?>" class="btn btn-info btn-sm" id="index-listing"><i class="icon-gears2 btn-icon"></i>返回上一级</a> </header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">活动标题</th>
                        <th colspan="6"><a href="<?php echo $data['url'];?>" target="_blank"><?php echo $data['title'];?></a></th>
                    </tr>
                    <tr>
                        <th class="hidden-phone tablehead">订单ID</th>
                        <th class="tablehead">提交人姓名</th>
                        <th class="tablehead">提交人电话</th>
                        <th class="tablehead">成人数</th>
                        <th class="tablehead">儿童数</th>
                        <th class="tablehead">紧急联系人</th>
                        <th class="tablehead">紧急联系电话</th>
                        <th class="tablehead">提交时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result2 AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $r['truename'];?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $r['cr_num'];?></td>
                            <td><?php echo $r['et_num'];?></td>
                            <td><?php echo $r['jjname'];?></td>
                            <td><?php echo $r['jjmobile'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">序号</th>
                        <th class="tablehead">参团人姓名</th>
                        <th class="tablehead">性别</th>
                        <th class="tablehead">参团人电话</th>
                        <th class="tablehead">证件类型</th>
                        <th class="tablehead">证件号码</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $n = 1;
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td>第<?php echo $n;?>位</td>
                            <td><?php echo $r['truename'];?></td>
                            <td><?php echo $r['sex']==1 ? '男' : '女'?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $cardtypes[$r['cardtype']];?></td>
                            <td><?php echo $r['cardid'];?></td>
                            </td>
                        </tr>
                    <?php
                        $n++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
        </form>
    </div>
</div>
<!-- page end-->
</section>
<script type="text/javascript">
    function send_goods(id,username){
        top.openiframe('index.php?m=order&f=index&v=send&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 450);
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