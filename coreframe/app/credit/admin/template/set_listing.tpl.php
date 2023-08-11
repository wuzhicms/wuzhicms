<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">策略名称</th>
                    <th class="tablehead">动作方法名</th>
                    <th class="tablehead">积分数量</th>
                    <th class="tablehead">动作</th>
                    <th class="tablehead">积分次数限制</th>
                    <th class="tablehead">策略所在频道</th>
                    <th class="tablehead">删除操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    $cats = $this->db->get_one('category', array('cid' => $r['cid']));
                    ?>
                    <tr>
                        <td><?php echo $r['name'];?></td>
                        <td><?php echo $r['action'];?></td>
                        <td><?php echo $r['point'];?></td>
                        <td><?php if($r['type']==1) {echo '增加';} else {echo '<font color="#f37800">减少</font>';}?></td>
                        <td><?php echo $r['quantity'];?></td>

                        <td><?php echo $cats['name'];?></td>
                        <td>

                            <a href="javascript:makedo('?m=credit&f=set&v=delete&csid=<?php echo $r['csid'];?><?php echo $this->su();?>', '确认删除该记录？')" class="btn btn-danger btn-sm btn-xs">删除</a>
                        </td>

                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <div class="panel-foot">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="panel-label">
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
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
<?php include $this->template('footer','core');?>