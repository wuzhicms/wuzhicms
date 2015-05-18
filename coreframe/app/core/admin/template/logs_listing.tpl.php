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
                        <th class="tablehead">操作人</th>
                        <th class="tablehead">模块</th>
                        <th class="tablehead">文件</th>
                        <th class="tablehead">方法</th>
                        <th class="tablehead">操作时间</th>
                        <th class="tablehead">详细参数</th>
                        <th class="tablehead">操作ip</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('admin',array('uid'=>$r['uid']),'truename');
                        ?>
                        <tr>

                            <td><?php echo $r['id'];?></td>
                            <td><?php echo empty($mr['truename']) ? $r['uid'] : $mr['truename'];?></td>
                            <td><?php echo $r['m'];?></td>
                            <td><?php echo $r['f'];?></td>
                            <td><?php echo $r['v'];?></td>

                            <td><?php echo time_format($r['addtime']);?></td>
                            <td ><pre><?php echo $r['data'];?></pre></td>
                            <td><?php echo $r['ip'];?></td>
                        </tr>
                    <?php
                    }
                    ?>



                    </tbody>
                </table>
                <div class="panel-body text-center">
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