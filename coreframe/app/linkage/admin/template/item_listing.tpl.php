<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'linkage','f'=>'index','v'=>'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($submenuid,'&linkageid='.input('linkageid').'&pid='.$GLOBALS['pid']);?>
        <div id="position" style="padding: 15px;">当前位置：<?php echo $data['name'].' > '.$this->current_pos($pid);?></div>
        <form action="?m=linkage&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">排序</th>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">名称</th>
                    <th class="tablehead">首字母</th>
                    <th class="tablehead">描述</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td><input class="text-center form-control" style="width: 35px;padding:3px;" name="sorts[<?php echo $r['lid'];?>]" type="text" size="3" value="<?php echo $r['sort'];?>"></td>
                        <td><?php echo $r['lid'];?></td>
                        <td><?php echo $r['name'];?></td>
                        <td><?php echo $r['initial'];?></td>
                        <td><?php echo $r['remark'];?></td>
                        <td>
                            <a href="?m=linkage&f=index&v=item_listing&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">管理子选项</a>
                            <a href="?m=linkage&f=index&v=add_item&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-default btn-sm btn-xs">添加子选项</a>
                            <?php if($r['isgroup']=='0') {?>
                            <a href="?m=linkage&f=index&v=set_group&lid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-default btn-sm btn-xs">设为群组项</a>
                            <?php } else {?>
                                <a href="?m=linkage&f=index&v=set_group&lid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-warning btn-sm btn-xs">设为常规项</a>
                            <?php }?>
                            <a href="?m=linkage&f=index&v=edit_item&linkageid=<?php echo $GLOBALS['linkageid'];?>&pid=<?php echo $GLOBALS['pid'];?>&lid=<?php echo $r['lid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                            <a href="javascript:makedo('?m=linkage&f=index&v=delete_item&lid=<?php echo $r['lid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                class="btn btn-danger btn-sm btn-xs">删除</a>
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
                        <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                    </div>
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
<script>
    $(this).focus();
</script>
<?php include $this->template('footer','core');?>
