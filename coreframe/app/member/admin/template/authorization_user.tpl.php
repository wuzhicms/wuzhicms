<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/2/18 18:57
 * @version    1.0.1
 */
?>
<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="panel tasks-widget">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body p-0">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">UID</th>
                    <th class="tablehead w-50">用户名</th>
                    <th class="tablehead">认证类型</th>
                    <th class="tablehead">是否通过</th>
                    <th class="tablehead">申请时间</th>
                    <th class="tablehead">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach($result AS $r) {
                ?>
                <tr>
                    <td><?php echo $r['uid'];?></td>
                    <td><?php echo $member[$r['uid']]['username'];?></td>
                    <td><?php echo $modelName[$r['modelid']];?></td>
                    <td>
                        <?php
                            if($r['status'] == 0) {
                        ?>
                            <span class="label label-default label-mini">未审核</span>
                        <?php
                            }
                        ?>
                        <?php
                        if($r['status'] == 1) {
                            ?>
                            <span class="label label-success label-mini">审核通过</span>
                            <?php
                        }
                        ?>
                        <?php
                        if($r['status'] == 9) {
                            ?>
                            <span class="label label-danger label-mini">已驳回</span>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php echo date('Y-m-d H:i:s', $r['created_at']);?></td>
                    <td>
                        <a href="index.php?m=member&f=authorization&v=verify&modelid=<?php echo $r['modelid']?>&uid=<?php echo $r['uid'] . $this->su();?>" class="btn btn-info btn-sm btn-xs">审核</a>
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
