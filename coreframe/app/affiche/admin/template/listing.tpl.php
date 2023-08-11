<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">排序</th>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">名称</th>
                    <th class="tablehead">创建时间</th>
                    <th class="tablehead">结束时间</th>
                    <th class="tablehead">公告群体</th>
                    <th class="tablehead">发布人</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td><input name="sorts[<?php echo $r['id'];?>]" type="text" class="text-center form-control" style="padding:3px;width: 30px;" value="<?php echo $r['sort'];?>" size="3"></td>
                        <td><?php echo $r['id'];?></td>
                        <td><?php echo "<a href='index.php?m=affiche&f=index&v=show&id=".$r['id']."' target='_blank' style='".$r['css']."'>".safe_htm($r['title'])."</a>";?></a></td>
                        <td><?php echo time_format($r['addtime']);?></td>
                        <td><?php echo date('Y-m-d H:i:s',$r['endtime']);?></td>
                        <td><?php echo $status_arr[$r['status']];?></td>
                        <td><?php echo $r['publisher'];?></td>
                        <td>
                            <a href="?m=affiche&f=index&v=edit&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                            <a href="javascript:makedo('?m=affiche&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
<script type="text/javascript">
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<?php include $this->template('footer','core');?>
