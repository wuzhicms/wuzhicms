<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
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
                        <th class="tablehead">工作流名称</th>
                        <th class="tablehead">层级数</th>
                        <th class="tablehead">所属模块</th>
                        <th class="center tablehead ">一审名单</th>
                        <th class="center tablehead">二审名单</th>
                        <th class="center tablehead">三审名单</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['workflowid'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['level'];?></td>
                            <td><?php echo $module_names[$r['keyid']]."(".$r['keyid'].")";?></td>
                            <td class="center"><?php echo $r['level1_user'];?>  <a href="?m=core&f=workflow&v=adduser&workflowid=<?php echo $r['workflowid'];?>&level=1<?php echo $this->su();?>" class="btn btn-primary btn-xs">添加</a></td>
                            <td class="center"><?php if($r['level']>1) {echo $r['level2_user'];?>  <a href="?m=core&f=workflow&v=adduser&workflowid=<?php echo $r['workflowid'];?>&level=2<?php echo $this->su();?>" class="btn btn-primary btn-xs">添加</a><?php }?></td>
                            <td class="center"><?php if($r['level']>2) {echo $r['level3_user'];?> <a href="?m=core&f=workflow&v=adduser&workflowid=<?php echo $r['workflowid'];?>&level=3<?php echo $this->su();?>" class="btn btn-primary btn-xs">添加</a><?php }?></td>
                        </tr>
                    <?php
                    }
                    ?>



                    </tbody>
                </table>
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