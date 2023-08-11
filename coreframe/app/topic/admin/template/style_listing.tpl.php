<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">风格名称</label>
                    <div class="col-3">
                        <input type="text" class="form-control" name="name" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！"></div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">css地址</label>
                    <div class="col-3">
                        <input type="text" name="remark" class="form-control" value="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-3">
                       <input type="hidden" name="v" value="add">
                       <input type="hidden" name="keyid" value="<?php echo $keyid;?>">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="添加风格">
                    </div>
                </div>
            </form>
        </div>
        <form action="?m=core&f=kind&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">风格名称</th>
                        <th class="tablehead">地址</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['kid'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td>
                                <a href="javascript:edit(<?php echo $r['kid'];?>);" class="btn btn-primary btn-sm btn-xs">修改</a>
                                <a href="javascript:makedo('?m=topic&f=style&v=delete&keyid=<?php echo $keyid;?>&kid=<?php echo $r['kid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
                        <div class="panel-label"></div>
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
    function edit(kid){
        top.openiframe('index.php?m=topic&f=style&v=edit&kid='+kid+'<?php echo $this->su();?>', 'edit', '编辑分类', 500, 300);
    }
</script>
<?php include $this->template('footer','core');?>

