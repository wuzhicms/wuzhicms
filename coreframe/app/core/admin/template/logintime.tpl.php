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
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">管理员账号</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">最后登录时间</th>
                        <th class="tablehead">登录IP</th>
                        <th class="tablehead">IP所在位置</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        if(V=='login_listing') $mr = $this->db->get_one('member',array('uid'=>$r['uid']),'username');
                        ?>
                        <tr>

                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $mr['username'];?></td>
                            <td>
<?php
if($r['status']==0) {
    echo '后台验证失败';
} elseif($r['status']==1) {
    echo '后台登录成功';
} elseif($r['status']==2) {
    echo '前台验证失败';
} elseif($r['status']==3) {
    echo '后台登录成功';
}
?>
                            </td>
                            <td><?php echo time_format($r['logintime']);?></td>
                            <td><?php echo $r['ip'];?></td>
                            <td><?php echo $r['ip'];?></td>
                        </tr>
                    <?php
                    }
                    ?>



                    </tbody>
                </table>
                <div class="panel-body center">
                    <div>
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
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