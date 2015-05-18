<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<style type="text/css">
    .showimg{
        max-height: 100px;max-width: 100px;
        margin: 1px 5px;
    }
</style>
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
                        <th class="tablehead">商家信息</th>
                        <th class="tablehead">总评</th>
                        <th class="tablehead">环境</th>
                        <th class="tablehead">服务</th>
                        <th class="tablehead">价格</th>
                        <th class="tablehead">停车信息</th>
                        <th class="tablehead">点评时间</th>
                        <th class="tablehead">点评人</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member',array('uid'=>$r['uid']));
                        $mecid = substr($r['keyid'],3);
                        $tr = $this->db->get_one('mec',array('id'=>$mecid),'title,url');
                        ?>
                        <tr class="tr<?php echo $r['id'];?>" title="IP：<?php echo $r['ip'];?> &#10;地区：<?php echo $r['ip_location'];?>">
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $tr['title'];?></td>
                            <td><?php echo $r['field1'];?></td>
                            <td><?php echo $r['field2'];?></td>
                            <td><?php echo $r['field3'];?></td>
                            <td><?php echo $r['field4'];?></td>
                            <td><?php echo $r['field6'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php echo $mr['username'];?></td>
                            <td>
                                <a href="javascript:;" onclick="delete_dianping(<?php echo $r['id'];?>,this)" class="btn btn-primary btn-xs">删除</a>

                            </td>
                        </tr>

                        <?php if($r['data']) {
                            $datas = explode("\r\n",$r['data']);
                            ?>
                            <tr class="tr<?php echo $r['id'];?>"><td></td><td colspan="9">
                                    <?php
foreach($datas as $dr) {
    echo "<a href='$dr' target='_blank'><img src='$dr' class='showimg'></a>";
}
                                    ?></td></tr>
                            <?php }?>
                        <tr class="tr<?php echo $r['id'];?>" style="border-bottom: 10px solid #F1F2F7;" ><td></td><td colspan="9"><?php echo $r['field5'];?></td></tr>
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

    $("#index-listing").html('商家信息－点评信息');
    function delete_dianping(id,obj) {
        $.post("index.php?m=dianping&f=index&v=delete<?php echo $this->su();?>", { id: id, time: Math.random() },
            function(data){
                if(data=='1') {
                    $('.tr'+id).fadeOut();
                } else {
                    alert(data);
                }
            });
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>