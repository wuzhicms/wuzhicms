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
                                <th class="tablehead">模块名称</th>
                                <th class="tablehead">模块目录</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($result AS $r) { ?>
                                <?php $module_array=$this->db->get_one('module_app',array('m'=>$value));?>

                                <tr>
                                    <td><?php echo $r['name'];?></td>
                                    <td><?php echo $r['m'];?></td>

                                    <td>
                                        <?php if($r['iscore']!=1 && !empty($r['m'])){ ?>
                                            <?php if(empty($r['isinstall'])){?>
                                                <a href="?m=module_app&f=module_manage&v=install&moduleid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">安装</a>
                                                <?php }else{?>
                                        <a href="?m=module_app&f=module_manage&v=uninstall&moduleid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">卸载</a>
                                            <?php } ?>

                                        <?php } ?>
                                        <?php if(empty($r['m']) || $r['iscore']==1){?>
                                            <?php echo '禁止';?>
                                        <?php }?>

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