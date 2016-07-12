<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">

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
                        <th class="tablehead">敏感词</th>
                        <th class="tablehead">添加时间</th>
                        <th class="tablehead">添加人</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        if($r['uid']) {
                            $mr = $this->db->get_one('member',array('uid'=>$r['uid']));
                            $username = $mr['username'];
                        } else {
                            $username = '';
                        }
                        ?>
                        <tr>

                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $r['word'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $username;?></td>

                            <td>
                                <a href="?m=core&f=badword&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">删除</a>


                            </td>
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