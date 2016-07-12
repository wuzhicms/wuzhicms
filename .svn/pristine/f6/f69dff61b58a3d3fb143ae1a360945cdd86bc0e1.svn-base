<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>

<section class="wrapper">
<!-- page start-->
<form name="myform" method="post" action="?m=core&f=menu&v=sort<?php echo $this->su();?>">
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
        <header>
            <header class="panel-heading">
                <?php
                if($pid!=0) {
                    echo '<a href="?m=core&f=menu&v=listing&pid='.$this->parentid($pid).$this->su().'"><button type="button" class="btn btn-inverse"><i class="icon-chevron-left btn-icon"></i>返回上级</button></a>';
                }
                ?>
            </header>
        </header>

        <header class="panel-heading"><span>后台菜单管理</span></header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead"><i class="icon-home"></i> 排序</th>
                        <th class="tablehead hidden-phone">ID</th>
                        <th class="tablehead">菜单名称</th>
                        <th class="tablehead">模块名</th>
                        <th class="tablehead">文件名</th>
                        <th class="tablehead">方法名</th>
                        <th class="tablehead">是否显示</th>
                        <th class="tablehead"><i class="icon-wrench"></i> 管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td>
                                <div>
                                    <input type="text" class="center" style="padding:3px;" name="sorts[<?php echo $r['menuid'];?>]" size="3" value="<?php echo $r['sort'];?>" >
                                </div>
                                </td>
                            <td><?php echo $r['menuid'];?></td>
                            <td><a href="?m=core&f=menu&v=listing&pid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="menunamea"><?php echo $r['name'];?> <i class="icon-gears2"></i></a> </td>
                            <td><?php echo $r['m'];?></td>
                            <td><?php echo $r['f'];?></td>
                            <td><?php echo $r['v'];?></td>
                            <td class="hidden-phone"><?php if($r['display']) {echo '<span class="label btn-primary label-mini">显示</span>';} else {echo '<span class="label btn-default label-mini">隐藏</span>';}?></td>
                            <td>
                                <a href="?m=core&f=menu&v=add&pid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">添加子菜单</a>
                                <a href="?m=core&f=menu&v=edit&id=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="?m=core&f=menu&v=delete&id=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-left">
                           <input type="submit" class="btn btn-info" name="submit" value="排序">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
        
</form>
<!-- page end-->
</section>

<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>