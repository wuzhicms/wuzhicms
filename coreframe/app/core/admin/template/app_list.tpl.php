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

                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">模块名称</th>
                                <th class="tablehead">模块目录</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($settings AS $r) { ?>
                                <tr>
                                    <td><?php echo $r['appname'];?></td>
                                    <td><?php echo $r['m'];?></td>

                                    <td>
                                        <?php if($r['install'] && $r['allow_uninstall']){ ?>
                                            <a href="javascript:makedo('?m=core&f=app&v=uninstall&appkey=<?php echo $r['m'];?><?php echo $this->su();?>', '【<?php echo $r['appname'].'-'.$r['m'];?>】模块数据会被清空！确认卸载该模块吗？')"
                                                class="btn btn-danger btn-xs">卸载</a>
                                        <?php } elseif($r['install']) { ?>
                                            ----
                                        <?php } else {  ?>
                                            <a href="?m=core&f=app&v=install&appkey=<?php echo $r['m'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">安装</a>
                                        <?php }  ?>

                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
            </section>
        </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>