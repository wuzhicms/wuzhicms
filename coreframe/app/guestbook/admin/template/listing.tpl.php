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
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">留言标题</th>
                        <th class="tablehead">留言时间</th>
                        <th class="tablehead">主题领域</th>
                        <th class="tablehead">主题类别</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">联系人</th>
                        <th class="tablehead">邮箱</th>
                        <th class="tablehead">联系电话</th>
                        <th class="tablehead">用户地理位置</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo "<a href='index.php?m=guestbook&f=index&v=reply&id=".$r['id'].$this->su()."'>".safe_htm($r['title'])."</a>";?></a></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $r['area'];?></td>
                            <td><?php echo $r['category'];?></td>
                            <td><button type="button" <?php if($r['status']==1||$r['status']==9){ echo 'class="btn btn-danger btn-xs"';}else{ echo 'class="btn btn-primary btn-xs"';} ;?> ><?php echo $status[$r['status']];?></button></td>

                            <td><?php echo $r['linkman'];?></td>
                            <td><?php echo $r['email'];?></td>
                            <td><?php echo $r['tel'];?></td>
                            <td><?php echo $r['ip_location'];?></td>
                            <td>


                                <a href="?m=guestbook&f=index&v=audit&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">审核</a>

                                <a href="?m=guestbook&f=index&v=reply&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">回复</a>
                                <a href="?m=guestbook&f=index&v=end&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">完结</a>
                                <a href="javascript:makedo('?m=guestbook&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
            </form>
        </section>
        </form>
    </div>
</div>
<!-- page end-->
</section>
<script type="text/javascript">
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>