<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'core','f'=>'model','v'=>'field_listing'));
$submenuid = $menu_r['menuid'];
?>
    <body class="body pxgridsbody">
    <section class="wrapper">
        <section class="panel">
            <?php echo $this->menu($submenuid,'&app='.$m.'&modelid='.$GLOBALS['modelid']);?>
            <div class="panel-body" id="panel-bodys">
                <form name="myform" method="post" action="?m=core&f=model&v=field_sort<?php echo $this->su();?>">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr >
                            <th class="tablehead">排序</th>
                            <th class="tablehead ">ID</th>
                            <th class="tablehead">别名</th>
                            <th class="tablehead hidden-phone">字段名</th>
                            <th class="tablehead">所在表</th>
                            <th class="tablehead">字段类型</th>
                            <th class="tablehead">禁删</th>
                            <th class="tablehead">必填</th>
                            <th class="tablehead">全文索引</th>
                            <th class="tablehead">投稿</th>
                            <th class="tablehead">管理操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($result AS $r) { ?>
                            <tr>
                                <td>
                                    <input type="text" class="text-center form-control" style="width: 35px;padding:3px;" name="sorts[<?php echo $r['id'];?>]" size="2" value="<?php echo $r['sort'];?>" >
                                </td>
                                <td><?php echo $r['id'];?></td>
                                <td><?php echo $r['name'];?></td>
                                <td><?php echo $r['field'];?></td>
                                <td><?php if($r[ 'master_field']) echo '主表';else echo '附属表';?></td>
                                <td><?php echo $r['formtype'];?></td>
                                <td><?php if($r[ 'ban_field']) echo '√';else echo 'x';?></td>
                                <td><?php if($r[ 'minlength']) echo '√';else echo 'x';?></td>
                                <td><?php if($r[ 'to_fulltext']) echo '√';else echo 'x';?></td>
                                <td><?php if($r[ 'ban_contribute']) echo '√';else echo 'x';?></td>
                                <td>
                                    <a href="?m=core&f=model&v=field_edit&id=<?php echo $r['id'];?>&app=<?php echo $m;?>&modelid=<?php echo $r['modelid'];?><?php echo $this->su();?>"
                                       class="btn btn-primary btn-sm btn-xs">修改</a>
                                    <?php
                                    if($r['disabled']) {
                                        ?>
                                        <a href="?m=core&f=model&v=field_baned&id=<?php echo $r['id'];?>&app=<?php echo $m;?>&modelid=<?php echo $r['modelid'];?>&ban_field=0<?php echo $this->su();?>"
                                           class="btn btn-danger btn-sm btn-xs" title="点击开启">已禁用</a>
                                        <?php
                                    } else {?>
                                        <a href="?m=core&f=model&v=field_baned&id=<?php echo $r['id'];?>&app=<?php echo $m;?>&modelid=<?php echo $r['modelid'];?>&ban_field=1<?php echo $this->su();?>"
                                           class="btn btn-default btn-sm btn-xs" title="点击禁用">使用中</a>
                                        <?php
                                    }?>
                                    <?php if(!$r[ 'ban_field']) {
?>
                                        <a href="javascript:makedo('?m=core&f=model&v=field_delete&id=<?php echo $r['id'];?>&app=<?php echo $m;?>&modelid=<?php echo $r['modelid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                            class="btn btn-danger btn-sm btn-xs">删除</a>
                                    <?php
                                    }?>

                                    <?php
                                    if($r['master_field']) {
                                        ?>
                                        <a href="?m=core&f=model&v=field_copy&id=<?php echo $r['id'];?>&app=<?php echo $m;?>&modelid=<?php echo $r['modelid'];?>&ban_field=0<?php echo $this->su();?>"
                                                class="btn btn-info btn-sm btn-xs">复制到其它模型</a>
                                        <?php
                                    }?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pull-left"> <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </section>
    </section>
    <script>
        $("#model-field_listing").html('字段管理 - <?php echo $model_data['name'];?>');
    </script>
<?php include $this->template('footer','core');?>
