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
                        <th class="tablehead">创建时间</th>
                        <th class="hidden-phone tablehead">名称</th>
                        <th class="tablehead">订单号</th>
                        <th class="tablehead">对方</th>
                        <th class="tablehead">金额</th>
                        <th class="tablehead">支付方式</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {

                        ?>
                        <tr>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo "<a href='?m=pay&f=index&v=view&id=".$r['id'].$this->su()."'>".safe_htm($r['payname'])."</a>";?></a></td>
                            <td><?php echo $r['order_no'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td style="font-weight: 700;"><?php if($r['plus_minus']==1) {
                                    echo "<font color='green'>+".$r['money']."</font>";
                                } elseif($r['plus_minus']==-1) {
                                    echo "<font color='#f37800'>-".$r['money']."</font>";
                                }
                                ?></td>
                            <td><?php if($r['payment']==2) {
                                    echo "<font color='#f37800'>".$payments[$r['payment']]."</font>";
                                } else {
                                    echo $payments[$r['payment']];
                                }

                                ?></td>
                            <td><?php echo $status_arr[$r['status']];?></td>
                            <td>
<?php if($r['status']==6) {?>
                                <a href="javascript:edit(<?php echo $r['id'];?>);" class="btn btn-primary btn-xs">改价</a><?php }?>
                                <a href="javascript:makedo('?m=pay&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>