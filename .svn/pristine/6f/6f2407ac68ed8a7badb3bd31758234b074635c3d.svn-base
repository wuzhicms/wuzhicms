<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<style>
    .table>tbody>tr>td, .table>tfoot>tr>td {
        border-top: 10px solid #F1F2F7;
        vertical-align: middle;
        padding: 10px;
    }
</style>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid'],'&id='.$id);?>
            <header class="panel-heading">
                <a href="<?php echo $data['url'];?>" target="_blank"><?php echo $data['title'];?></a>
            </header>
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-advance ">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead center" >ID</th>
                        <th class="tablehead">课程名</th>
                        <th class="tablehead">教室</th>
                        <th class="tablehead">教师</th>
                        <th class="tablehead">添加时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td rowspan="2" class="center"><?php echo $r['courseid'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['classroom'];?></td>
                            <td><?php echo $r['teacher'];?></td>
                            <td rowspan="2"><?php echo time_format($r['addtime']);?></td>

                            <td rowspan="2">
                                <a href="?m=course&f=index&v=add_detail&id=<?php echo $id;?>&courseid=<?php echo $r['courseid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs"> + 添加排期</a>
                                <a href="?m=course&f=index&v=manage_detail&id=<?php echo $id;?>&courseid=<?php echo $r['courseid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">管理排期</a>
                                <a href="?m=course&f=index&v=edit&id=<?php echo $r['id'];?>&courseid=<?php echo $r['courseid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=course&f=index&v=delete&id=<?php echo $r['id'];?>&courseid=<?php echo $r['courseid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #F1F2F7;"><?php echo $r['title_en'];?></td>
                            <td style="border-top: 1px solid #F1F2F7;"><?php echo $r['classroom_en'];?></td>
                            <td style="border-top: 1px solid #F1F2F7;"><?php echo $r['teacher_en'];?></td>

                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
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