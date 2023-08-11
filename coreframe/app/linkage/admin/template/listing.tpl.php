<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">名称</th>
                    <th class="tablehead">描述</th>
                    <th class="tablehead">调用代码</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td><?php echo $r['linkageid'];?></td>
                        <td><?php echo $r['name'];?></td>
                        <td><?php echo $r['remark'];?></td>
                        <td><div class="col-sm-8"><input type="text" class="form-control" value="{linkage(<?php echo $r['linkageid'];?>,'myfieldid<?php echo $r['linkageid'];?>')}"></div>
                        </td>
                        <td>
                            <a href="?m=linkage&f=index&v=item_listing&linkageid=<?php echo $r['linkageid'];?>&pid=0<?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">管理选项</a>
                            <a href="?m=linkage&f=index&v=add_item&linkageid=<?php echo $r['linkageid'];?><?php echo $this->su();?>" class="btn btn-default btn-sm btn-xs">添加选项</a>
                            <a href="?m=linkage&f=index&v=edit&linkageid=<?php echo $r['linkageid'];?>&pid=0<?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                            <a href="javascript:makedo('?m=linkage&f=index&v=delete&linkageid=<?php echo $r['linkageid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
                        <ul class="pagination pagination-sm">
                            <?php echo $pages; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="alert alert-success fade show">
                <strong>使用提示:</strong> 在调用时，如果需要多个字段显示，可以修改红色部分。{linkage(1,'<font color="red">myfieldid</font>')}
            </div>
        </div>
    </section> 
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
