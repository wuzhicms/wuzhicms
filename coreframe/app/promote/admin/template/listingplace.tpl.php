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
            <header class="panel-heading">
                <form action="" class="form-inline" method="get" target="_self" _lpchecked="1">
                    <input type="hidden" name="m" value="promote">
                    <input type="hidden" name="f" value="index">
                    <input type="hidden" name="v" value="search">
                    <input type="hidden" name="_su" value="<?php echo $GLOBALS['_su'];?>">
                    <div class="input-group">
                        <select name="fieldtype" class="form-control">
                            <option value="place" selected="">广告位名称</option>
                            <option value="title">广告名称</option>
                            <option value="keywords">广告关键字</option>
                        </select>
                    </div>
                    <input type="text" size="52" value="" name="keywords">
                    &nbsp;

                    <button type="submit" class="btn btn-sm btn-info" value="submit">搜索</button>
                </form>
            </header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">PID</th>
                        <th class="tablehead">名称</th>
                        <th class="tablehead">尺寸</th>
                        <th class="tablehead">预览</th>
                        <th class="tablehead">广告列表</th>
                        <th class="tablehead">添加时间</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {

                        ?>
                        <tr>
                            <td><?php echo $r['pid'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td>宽：<?php if($r['width']) echo $r['width'].'px';else echo '不限';?>  -- 高：<?php if($r['height']) echo $r['height'].'px';else echo '不限';?></td>
                            <td><a href="?m=promote&f=index&v=view&pid=<?php echo $r['pid'].$this->su();?>" target="_blank">预览</a></td>
                            <td><a href="?m=promote&f=index&v=listing&pid=<?php echo $r['pid'].$this->su();?>" class="btn btn-inverse btn-xs"><i class="icon-gears2 btn-icon" style="color: #fff;font-size: 12px;"></i>管理广告</a></td>
                            <td><?php echo time_format($r['addtime']);?></td>

                            <td>
<a href="?m=promote&f=index&v=add&pid=<?php echo $r['pid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs"><i class="icon-plus btn-icon" style="color: #fff;font-size: 12px;"></i>添加广告</a>
                                <a href="?m=promote&f=index&v=editplace&pid=<?php echo $r['pid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:makedo('?m=promote&f=index&v=deleteplace&pid=<?php echo $r['pid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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

                            <div class="pull-right">
                                <ul class="pagination pagination-sm mr0">
                                    <?php echo $pages;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

</div>

<!-- page end-->
</section>
<script>
    $("#index-listingplace").html('广告位管理');
</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>