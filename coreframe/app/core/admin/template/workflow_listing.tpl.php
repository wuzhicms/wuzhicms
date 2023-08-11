<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<!-- page start-->
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
                        <th class="center tablehead ">管理操作</th>
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
                            <td align="center"><a href="?m=core&f=workflow&v=edit&workflowid=<?php echo $r['workflowid'];?>&level=1<?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改工作流</a> <a href="?m=core&f=workflow&v=priv_list&workflowid=<?php echo $r['workflowid'];?>&level=1<?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">工作流权限</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
