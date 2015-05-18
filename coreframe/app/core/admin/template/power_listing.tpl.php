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
                        <th class="tablehead">管理员账号</th>
                        <th class="tablehead">真实姓名</th>
                        <th class="tablehead">角色</th>
                        <th class="tablehead">最后登录时间</th>
                        <th class="tablehead">登录IP</th>
                        <th class="tablehead">登录历史</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $mr = $this->db->get_one('member',array('uid'=>$r['uid']),'username');
                        $lr = $this->db->get_one('logintime',array('uid'=>$r['uid'],'status'=>1),'*');
                        ?>
                        <tr>

                            <td><?php echo $r['uid'];?></td>
                            <td><?php echo $mr['username'];?></td>
                            <td><?php echo $r['truename'];?></td>
                            <td><?php echo $roles[$r['role']]['name'];?></td>
                            <td><?php echo time_format($lr['logintime']);?></td>
                            <td><?php echo $lr['ip'];?></td>
                            <td><a href="?m=core&f=power&v=logintime&uid=<?php echo $r['uid'];?><?php echo $this->su();?>" class="btn btn-default btn-xs">查看记录</a>
                            </td>
                            <td>
                                <a href="?m=core&f=power&v=edit&uid=<?php echo $r['uid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="?m=core&f=power&v=delete&uid=<?php echo $r['uid'];?><?php echo $this->su();?>" class="btn btn-danger btn-xs">删除</a>
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