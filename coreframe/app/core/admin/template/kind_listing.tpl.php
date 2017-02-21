<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">


            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body">
                <form class="form-horizontal tasi-form" method="post" action="">

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label">名称</label>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                            <input type="text" class="form-control" name="name" datatype="*2-60" errormsg="名称至少2个字符,最多60个字符！"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label">备注</label>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                            <textarea name="remark" class="form-control" cols="60" rows="3"></textarea>                </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label"></label>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                           <input type="hidden" name="v" value="add">
                           <input type="hidden" name="keyid" value="<?php echo $keyid;?>">
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="添加分类">
                        </div>
                    </div>
                </form>
</div>
                <form action="?m=core&f=kind&v=sort<?php echo $this->su();?>" name="myform" method="post">

                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="hidden-phone tablehead">排序</th>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">名称</th>
                                <th class="tablehead">备注</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($result AS $r) {

                                ?>
                                <tr>
                                    <!---排序--->
                                    <td><input name="sorts[<?php echo $r['kid'];?>]" type="text" class="center" style="padding:3px" value="<?php echo $r['sort'];?>" size="3"></td>

                                    <td><?php echo $r['kid'];?></td>
                                    <td><?php echo $r['name'];?></td>
                                    <td><?php echo $r['remark'];?></td>
                                    <td>

                                        <a href="javascript:edit(<?php echo $r['kid'];?>);" class="btn btn-primary btn-xs">修改</a>
                                        <a href="javascript:makedo('?m=core&f=kind&v=delete&keyid=<?php echo $keyid;?>&kid=<?php echo $r['kid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                            class="btn btn-danger btn-xs">删除</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>



                            </tbody>
                        </table>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left"> <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                                    </div>
                                    <div class="pull-right">
                                        <ul class="pagination pagination-sm mr0">
                                            <?php echo $pages;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
            </form>

        </div>

    </div>

    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
    function edit(kid){
        top.openiframe('index.php?m=core&f=kind&v=edit&kid='+kid+'<?php echo $this->su();?>', 'edit', '编辑分类', 500, 300);
    }
</script>
</body>
</html>