<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body">
<style type="text/css">
    .table>tbody>tr>td, .table>thead>tr>th {
        padding: 5px 10px;
    }
    .table>thead>tr>th.tablehead {
        padding: 10px 10px;
    }
</style>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                 <span class="dropdown addcontent">

                 </span>
                 <span class="dropdown examine">
                     <?php
                     echo $this->_status2($status);
                     ?>
                 </span>
                    <form class="pull-right position" action="" method="get">
                        <input name="m" value="content" type="hidden">
                        <input name="f" value="content" type="hidden">
                        <input name="v" value="listing" type="hidden">
                        <input name="_su" value="<?php echo $GLOBALS['_su'];?>" type="hidden">
                        <input name="status" value="<?php echo $status;?>" type="hidden">
                        <input name="cid" value="<?php echo $cid;?>" type="hidden">
                        <div class="input-append dropdown">
                            <input type="text" name="title" placeholder="搜索标题" class="sr-input" value="<?php echo $title;?>">
                            <button type="submit" class="btn sr-btn"><i class="icon-search"></i></button><button type="button" class="btn adsr-btn" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-sort-down"></i></button>
                            <ul class="dropdown-menu" id="adsearch">
                                <div class="adser"><i class="icon-sort-up"></i></div>
                                <li><a href="?m=content&f=content&v=search<?php echo $this->su();?>">高级搜索</a></li>
                            </ul>
                        </div>
                    </form>
                </header>

                <div class="panel-body" id="panel-bodys">
                    <form name="myform" id="myform" method="post" action="?m=content&f=content&v=sort<?php echo $this->su();?>">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead" style="width: 50px;">选择</th>
                                <th class="tablehead">ID</th>
                                <?php if($modelid==0) echo ' <th class="tablehead">所属栏目</th>';?>
                                <th class="tablehead">标题</th>
                                <th class="tablehead">更新时间</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($result as $rs) {

                            foreach($rs AS $r) { ?>
                                <tr>
                                    <td class="center"><input type="checkbox" name="ids[]" value="<?php echo $r['id'];?>"></td>
                                    <td><?php echo $r[ 'id'];?></td>
                                    <?php if($modelid==0) echo ' <td>'.$categorys[$r['cid']]['name'].'</td>';?>
                                    <td><a href="<?php if($r['status']==9) {echo $r['url'];}else{ echo '?m=content&f=content&v=view&id='.$r['id'].'&cid='.$r['cid'].$this->su();};?>" target="_blank"><?php echo p_htmlentities($r['title']);?></a></td>
                                    <td title="添加时间：<?php echo date('Y-m-d H:i:s',$r[ 'addtime']);?>"><?php echo time_format($r[ 'updatetime']);?></td>
                                    <td>
                                        <a href="?m=content&f=content&v=edit&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'].$this->su();?>" class="btn btn-primary btn-xs">编辑</a>
                                        <a href="?m=content&f=content&v=view&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'];?><?php echo $this->su();?>" target="_blank" class="btn btn-default btn-xs">审核</a>
                                        <a href="javascript:makedo('?m=content&f=content&v=<?php if($status!=0) echo 'recycle_';?>delete&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'].$this->su();?>', '确认删除该记录？')" class="btn btn-danger btn-xs">删除</a>
                                        <?php if($cid==69) {?>
                                        <a href="?m=medical&f=jingjia&v=listing&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">竞价</a><?php }?>
                                    </td>
                                </tr>
                            <?php }} ?>
                            </tbody>
                        </table>


                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left">
                                        <input id="v" name="v" type="hidden" value="<?php echo V;?>">
                                        <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                                        <button type="submit" onclick="$('#v').val('move')" class="btn btn-default btn-sm">移动</button>
                                        <input name="cid" value="<?php $cid;?>" type="hidden">
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
        </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/hover-dropdown.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>