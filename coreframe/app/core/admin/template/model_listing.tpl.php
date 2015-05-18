<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
               <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body" id="panel-bodys">
                    <form name="myform" method="post" action="?m=core&f=menu&v=sort<?php echo $this->su();?>">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead hidden-phone">ID</th>
                                <th class="tablehead">模型名称</th>
                                <th class="tablehead">属性</th>
                                <th class="tablehead">主表</th>
                                <th class="tablehead">附属表</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($result AS $r) { ?>
                                <tr>
                                    <td><?php echo $r[ 'modelid'];?></td>
                                    <td><?php echo $r[ 'name'];?></td>
                                    <td>
                                        <?php if($r[ 'share_model']) {echo
                                        '<span class="label btn-primary label-mini">共享模型</span>';} else {echo '<span class="label btn-info label-mini">独立模型</span>';}?>
                                    </td>
                                    <td><?php echo $r[ 'master_table'];?></td>
                                    <td><?php echo $r[ 'attr_table'];?></td>
                                    <td>
                                        <a href="?m=core&f=model&v=field_listing&modelid=<?php echo $r['modelid'];?><?php echo $this->su();?>"
                                           class="btn btn-info btn-xs">字段管理</a>
                                        <a href="?m=core&f=model&v=edit&modelid=<?php echo $r['modelid'];?><?php echo $this->su();?>"
                                           class="btn btn-primary btn-xs">修改</a>
                                        <a href="javascript:makedo('?m=core&f=model&v=delete&modelid=<?php echo $r['modelid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                           class="btn btn-danger btn-xs">删除</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </form>
            </section>
        </div>
    </section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
    </body>
    </html>