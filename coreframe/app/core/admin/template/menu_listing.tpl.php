<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
<form name="myform" method="post" action="?m=core&f=menu&v=sort<?php echo $this->su();?>">
    <section class="panel">
        <?php
        if($pid!=0) {
            echo '<header class="panel-heading"><a href="?m=core&f=menu&v=listing&pid='.$this->parentid($pid).$this->su().'"><button type="button" class="btn btn-inverse"><i class="icon-chevron-left btn-icon"></i>返回上级</button></a>
                <a href="?m=core&f=menu&v=add&pid='.$pid.$this->su().'" class="btn btn-default btn-sm" id="index-add"><i class="icon-plus btn-icon"></i>添加菜单</a></a></header>';
        }
        ?>
        <header class="panel-heading"><span>后台菜单管理</span></header>
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">排序</th>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">菜单名称</th>
                    <th class="tablehead">模块名</th>
                    <th class="tablehead">文件名</th>
                    <th class="tablehead">方法名</th>
                    <th class="tablehead">是否显示</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td>
                            <div>
                                <input type="text" class="text-center form-control" style="padding:3px;width:30px;" name="sorts[<?php echo $r['menuid'];?>]" size="3" value="<?php echo $r['sort'];?>" >
                            </div>
                            </td>
                        <td><?php echo $r['menuid'];?></td>
                        <td><a href="?m=core&f=menu&v=listing&pid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="menunamea"><?php echo $r['name'];?> <i class="icon-gears2"></i></a> </td>
                        <td><?php echo $r['m'];?></td>
                        <td><?php echo $r['f'];?></td>
                        <td><?php echo $r['v'];?></td>
                        <td><?php if($r['display']) {echo '<span class="badge fw-normal btn-primary">显示</span>';} else {echo '<span class="badge fw-normal btn-default">隐藏</span>';}?></td>
                        <td>
                            <a href="?m=core&f=menu&v=add&pid=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">添加子菜单</a>
                            <a href="?m=core&f=menu&v=edit&id=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                            <a href="?m=core&f=menu&v=delete&id=<?php echo $r['menuid'];?><?php echo $this->su();?>" class="btn btn-danger btn-sm btn-xs">删除</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="panel-foot">
            <div class="d-flex justify-content-between align-items-center">
                <div class="panel-label">
                    <input type="submit" class="btn btn-info" name="submit" value="排序">
                </div>
            </div>
        </div>
    </section>
</form>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
