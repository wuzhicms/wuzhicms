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
            <?php echo $this->menu($GLOBALS['_menuid'],'&id='.$id);?>
            <header class="panel-heading">
                <a href="<?php echo $data['url'];?>" target="_blank"><?php echo $data['title'];?></a> > <?php echo $data2['title'];?>
            </header>
            <form action="?m=course&f=index&v=delete_detail<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">选择</th>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">日期</th>
                        <th class="tablehead">星期几</th>
                        <th class="tablehead">时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $week = date("N",$r['starttime']);
                        $week_arr = array('','星期一','星期二','星期三','星期四','星期五','星期六','星期日');
                        $week = $week_arr[$week];
                        ?>
                        <tr>
                            <td ><input type="checkbox" name="cdids[]" value="<?php echo $r['cdid'];?>"></td>
                            <td><?php echo $r['cdid'];?></td>
                            <td><?php echo date('Y-m-d',$r['starttime']);?></td>
                            <td><?php echo $week;?></td>
                            <td><?php echo date('H:i',$r['starttime']).' - '.date('H:i',$r['endtime']);?></td>

                            <td>
                                <a href="?m=course&f=index&v=delete_detail&courseid=<?php echo $courseid;?>&cdids[]=<?php echo $r['cdid'];?><?php echo $this->su();?>"
                                   class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-left">
                                <input id="v" name="v" type="hidden" value="delete_detail">
                                <button type="button" onclick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                                <button type="submit" class="btn btn-default btn-sm">批量删除</button>
                            </div>
                            <div class="pull-right">
                                <ul class="pagination pagination-sm mr0">
                                    <?php echo $pages;?>
                                </ul>
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