<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'content','f'=>'block','v'=>'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">审批时间</th>
                    <th class="tablehead">审批结果</th>
                    <th class="tablehead">审批意见</th>
                    <th class="tablehead">审批人</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($result) {
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo date('Y-m-d H:i:s',$r['checktime']);?></td>
                            <td><?php echo $r['status_msg'];?></td>
                            <td><?php echo $r['msg'];?></td>
                            <td><?php echo $r['admin_username'];?></td>
                        </tr>
                        <?php
                    }
                } else {

                }

                ?>
                </tbody>
            </table>

        </div>
    </section>
    <!-- page end-->
</section>
<?php include $this->template('footer','core');?>