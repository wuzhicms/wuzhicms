<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <form action="?m=topic&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">排序</th>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">所属分类</th>
                        <th class="tablehead">添加时间</th>
                        <th class="tablehead">发布状态</th>
                        <th class="tablehead">更新状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $kind_data = $this->db->get_one('kind', array('kid' => $r['kid']));
                        ?>
                        <tr>
                            <!---排序--->
                            <td><input name="sorts[<?php echo $r['tid'];?>]" type="text" class="text-center form-control" style="width: 35px;padding:3px;" value="<?php echo $r['sort'];?>" size="3"></td>
                            <td><?php echo $r['tid'];?></td>
                            <td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['name'];?></a></td>
                            <td><?php echo $kind_data['name'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php echo $status[$r['status']];?></td>
                            <td><?php echo $upgrade_status[$r['upgrade_status']];?></td>
                            <td>
                                <a href="javascript:" onclick="sub_listing(<?php echo $r['tid'];?>,'<?php echo safe_htm($r['name']);?>');" class="btn btn-info btn-sm btn-xs">管理子分类</a>
                                <a href="?m=topic&f=index&v=list_manage&tid=<?php echo $r['tid'];?><?php echo $this->su();?>" class="btn btn-inverse btn-sm btn-xs">管理内容</a>
                               <!-- <a href="?m=core&f=layout&v=view&pageid=topic&tid=<?php echo $r['tid'];?><?php echo $this->su();?>" class="btn btn-default btn-sm btn-xs" target="_blank">可视化管理</a>-->
                                <a href="?m=topic&f=index&v=edit&tid=<?php echo $r['tid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                                <a href="javascript:makedo('?m=topic&f=index&v=delete&tid=<?php echo $r['tid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
    function sub_listing(tid,name){
        top.openiframe('index.php?m=topic&f=kind&v=sub_listing&tid='+tid+'<?php echo $this->su();?>', 'edit', '【'+name+'】的子分类管理', 900, 500);
    }
</script>
<?php include $this->template('footer','core');?>
