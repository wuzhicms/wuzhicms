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
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">谁？</th>
                        <th class="tablehead">时间</th>
                        <th class="tablehead">动作</th>
                        <th class="tablehead">事件</th>
                        <th class="tablehead">IP</th>
                        <th class="tablehead">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['logid'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $actions[$r['action']];?></td>
                            <td ><?php if($r['url']) {?><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a><?php } else { echo $r['title'];}?></td>
                            <td title="<?php echo $r['ip'];?>"><?php echo $r['ip_location'];?></td>
                            <td><?php if($r['editurl']) {?><a href="<?php echo $r['editurl'].$this->su();?>" class="btn btn-primary btn-xs">修改</a><?php }?></td>
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
        </section>
    </div>
</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>