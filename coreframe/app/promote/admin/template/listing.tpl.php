<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
    $menu_r = $this->db->get_one('menu',array('m'=>'promote','f'=>'index','v'=>'listing'));
    $submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($submenuid,"&pid=$pid");?>
        <header class="panel-heading">
            <form action="" class="row" method="get" target="_self" _lpchecked="1">
                <input type="hidden" name="m" value="promote">
                <input type="hidden" name="f" value="index">
                <input type="hidden" name="v" value="search">
                <input type="hidden" name="_su" value="<?php echo $GLOBALS['_su'];?>">
                <div class="col-3">
                    <select name="fieldtype" class="form-select">
                        <option value="place" selected="">广告位名称</option>
                        <option value="title" >广告名称</option>
                        <option value="keywords">广告关键字</option>
                    </select>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" size="52" value="" name="keywords">
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-info px-4" value="submit">搜索</button>
                </div> 
            </form>
        </header>
        <form action="?m=link&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">

        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">名称</th>
                    <th class="tablehead">预览</th>
                    <th class="tablehead">投放时间/截止时间</th>
                    <th class="tablehead">添加时间/更新时间</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td><?php echo $r['id'];?></td>
                        <td><?php echo $r['title'];?></td>
                        <td><a href="?m=promote&f=index&v=view&id=<?php echo $r['id'];?>&pid=<?php echo $r['pid'].$this->su();?>" target="_blank">预览</a></td>
                        <td><?php echo date('Y-m-d H:i',$r['starttime']);?> /<br> <?php echo date('Y-m-d H:i',$r['endtime']);?></td>
                        <td><?php echo time_format($r['addtime']);?> /<br> <?php echo time_format($r['updatetime']);?></td>
                        <td>
                            <a href="?m=promote&f=index&v=edit&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                            <a href="javascript:makedo('?m=promote&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                class="btn btn-danger btn-sm btn-xs">删除</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <div class="panel-foot">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="panel-label">
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>