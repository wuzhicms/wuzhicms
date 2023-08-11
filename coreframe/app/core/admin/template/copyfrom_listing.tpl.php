<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <header class="panel-heading d-flex p-0">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <form class="position ms-auto p-3" action="" method="get" target="_self">
                <input type="hidden" name="m" value="<?php echo M;?>" />
                <input type="hidden" name="f" value="<?php echo F;?>" />
                <input type="hidden" name="v" value="<?php echo V;?>" />
                <input type="hidden" name="_su" value="<?php echo _SU;?>" />
                <input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
                <input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid'];?>" />
                <div class="input-group">
                    <span class="input-group-text">来源名称：</span>
                    <input type="text"  class="form-control"  placeholder="搜索来源" class="sr-input" value="<?php echo $GLOBALS['keywords'];?>" name="keywords">
                    <button type="submit" class="btn btn-info" value="submit"><i class="icon-search"></i></button>
                </div>
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
                                <a href="?m=core&f=copyfrom&v=edit&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                                <a href="javascript:makedo('?m=core&f=copyfrom&v=delete&fromid=<?php echo $r['fromid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-sm btn-xs">删除</a>
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
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
