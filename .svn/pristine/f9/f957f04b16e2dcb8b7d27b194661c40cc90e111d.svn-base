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
            <header class="panel-heading">
                <form action="" class="form-inline" method="get" target="_self">
                    <input type="hidden" name="m" value="<?php echo M;?>" />
                    <input type="hidden" name="f" value="<?php echo F;?>" />
                    <input type="hidden" name="v" value="<?php echo V;?>" />
                    <input type="hidden" name="_su" value="<?php echo _SU;?>" />
                    <input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
                    <input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid'];?>" />

                    &nbsp;来源名称： <input type="text" size="52" value="<?php echo $GLOBALS['keywords'];?>" name="keywords">
                    &nbsp;

                    <button type="submit" class="btn btn-info btn-sm" value="submit">搜索</button>
                </form>
            </header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">链接地址</th>
                        <th class="tablehead">logo</th>
                        <th class="tablehead">备注</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>

                            <td><?php echo $r['fromid'];?></td>
                            <td><a href="index.php?f=copyfrom&id=<?php echo $r['fromid'];?>14&siteid=<?php echo $siteid;?>" target="_blank"><?php echo $r['name'];?></a></td>
                            <td><?php echo $r['url'];?></td>
                            <td><?php echo $r['logo'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td>
                                <a href="?m=core&f=copyfrom&v=edit&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=core&f=copyfrom&v=delete&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php if($total>20) {?>
                <div class="panel-body">
                    <div>
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
                <?php }?>
            </div>
        </section>
    </div>
</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>