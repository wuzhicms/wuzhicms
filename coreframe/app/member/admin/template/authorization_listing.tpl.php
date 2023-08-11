<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/1/13 22:08
 * @version    1.0.1
 */
?>
<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
    <section class="wrapper">
        <div class="panel tasks-widget">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead w-50">认证类型</th>
                        <th class="tablehead">是否启用</th>
                        <th class="tablehead">管理</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td><?php echo ($r['status'] == 1) ? '启用' : '禁用';?></td>
                            <td>
                                <a href="index.php?m=member&f=authorization&v=edit&id=<?php echo $r['id'].$this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                                <a href="javascript:makedo('?m=member&f=authorization&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-sm btn-xs">删除</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
